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
            if ($route['methode'] === $this->requete->methode && $route['uri'] === $this->requete->uri) {
                $resultat = ($route['action'])($this->requete);
                if ($resultat instanceof Reponse) {
                    return $resultat;
                }
                return Reponse::texte((string) $resultat);
            }
        }

        return Reponse::texte('404 — Page non trouvée', 404);
    }
}
