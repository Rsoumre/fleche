<?php

namespace Fleche;

class Routeur
{
    private array $routes = [];
    private Requete $requete;

    public function __construct(Requete $requete)
    {
        $this->requete = $requete;
    }

    public function get(string $uri, callable|array $action): Route
    {
        return $this->ajouter('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action): Route
    {
        return $this->ajouter('POST', $uri, $action);
    }

    public function put(string $uri, callable|array $action): Route
    {
        return $this->ajouter('PUT', $uri, $action);
    }

    public function patch(string $uri, callable|array $action): Route
    {
        return $this->ajouter('PATCH', $uri, $action);
    }

    public function delete(string $uri, callable|array $action): Route
    {
        return $this->ajouter('DELETE', $uri, $action);
    }

    private function ajouter(string $methode, string $uri, callable|array $action): Route
    {
        $route = new Route($methode, $uri, $action);
        $this->routes[] = $route;
        return $route;
    }

    public function resoudre(): Reponse
    {
        foreach ($this->routes as $route) {
            if ($route->methode !== $this->requete->methode) {
                continue;
            }

            $parametres = $this->correspondre($route->uri, $this->requete->uri);

            if ($parametres === null) {
                continue;
            }

            $this->requete->parametres = $parametres;

            $action = fn(Requete $req) => $this->appeler($route->action, $req);
            $pipeline = $this->construirePipeline($route->middlewares, $action);

            $resultat = $pipeline($this->requete);

            if ($resultat instanceof Reponse) {
                return $resultat;
            }
            return Reponse::texte((string) $resultat);
        }

        return new Reponse(Vue::rendu('404'), 404, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    private function construirePipeline(array $middlewares, callable $action): callable
    {
        $pipeline = $action;

        foreach (array_reverse($middlewares) as $classe) {
            $suivant  = $pipeline;
            $pipeline = fn(Requete $req) => (new $classe())->traiter($req, $suivant);
        }

        return $pipeline;
    }

    private function appeler(callable|array $action, Requete $requete): mixed
    {
        if (is_array($action)) {
            [$classe, $methode] = $action;
            return (new $classe())->$methode($requete);
        }

        return $action($requete);
    }

    private function correspondre(string $routeUri, string $uriActuelle): ?array
    {
        $motif = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $routeUri);
        $motif = '#^' . $motif . '$#';

        if (!preg_match($motif, $uriActuelle, $correspondances)) {
            return null;
        }

        return array_filter($correspondances, 'is_string', ARRAY_FILTER_USE_KEY);
    }
}
