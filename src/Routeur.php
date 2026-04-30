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

    public function get(string $uri, callable $action): void
    {
        $this->routes[] = ['methode' => 'GET', 'uri' => $uri, 'action' => $action];
    }

    public function post(string $uri, callable $action): void
    {
        $this->routes[] = ['methode' => 'POST', 'uri' => $uri, 'action' => $action];
    }

    public function resoudre(): Reponse
    {
        foreach ($this->routes as $route) {
            if ($route['methode'] !== $this->requete->methode) {
                continue;
            }

            $parametres = $this->correspondre($route['uri'], $this->requete->uri);

            if ($parametres === null) {
                continue;
            }

            $this->requete->parametres = $parametres;
            $resultat = ($route['action'])($this->requete);

            if ($resultat instanceof Reponse) {
                return $resultat;
            }
            return Reponse::texte((string) $resultat);
        }

        return Reponse::texte('404 — Page non trouvée', 404);
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
