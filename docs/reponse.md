# Réponse

## Types de réponses

```php
// Texte brut
return Reponse::texte('Bonjour !');

// JSON
return Reponse::json(['statut' => 'ok']);

// Vue HTML
return Reponse::vue('accueil', ['titre' => 'Bienvenue']);

// Redirection
return Reponse::rediriger('/connexion');
return Reponse::rediriger('/articles', 301); // redirection permanente
```

## Code HTTP personnalisé

```php
return Reponse::json(['erreur' => 'Non autorisé'], 401);
return Reponse::vue('erreur', [], 500);
```

## Tableau des méthodes

| Méthode | Description |
|---|---|
| `Reponse::texte($contenu, $statut)` | Réponse texte brut |
| `Reponse::json($donnees, $statut)` | Réponse JSON |
| `Reponse::vue($nom, $donnees, $statut)` | Réponse HTML via une vue |
| `Reponse::rediriger($url, $statut)` | Redirection (302 par défaut) |
