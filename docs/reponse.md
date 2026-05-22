# Réponse

La classe `Reponse` construit et envoie la réponse HTTP au navigateur.

---

## Types de réponses

```php
// Texte brut
return Reponse::texte('Bonjour !');

// JSON
return Reponse::json(['statut' => 'ok']);
return Reponse::json(['erreur' => 'Non autorisé'], 401);

// Vue HTML
return Reponse::vue('accueil', ['titre' => 'Bienvenue']);
return Reponse::vue('erreur', [], 500);

// Redirection
return Reponse::rediriger('/connexion');
return Reponse::rediriger('/articles', 301); // permanente

// Téléchargement de fichier
return Reponse::telecharger('/chemin/vers/rapport.pdf');
return Reponse::telecharger('/chemin/vers/rapport.pdf', 'mon-rapport.pdf');
```

---

## Ajouter des en-têtes

```php
return Reponse::json($donnees)
    ->avecEntete('X-Api-Version', '1.0')
    ->avecEntete('Cache-Control', 'no-cache');
```

---

## Cookies

```php
// Définir un cookie
return Reponse::rediriger('/tableau-de-bord')
    ->avecCookie(
        nom:          'langue',
        valeur:       'fr',
        duree:        time() + 3600 * 24 * 30, // 30 jours
        chemin:       '/',
        domaine:      '',
        securise:     false,
        httpSeulement: true
    );

// Supprimer un cookie
return Reponse::rediriger('/')
    ->sansCookie('langue');
```

---

## Code HTTP personnalisé

```php
return Reponse::json(['erreur' => 'Non autorisé'], 401);
return Reponse::json(['erreur' => 'Introuvable'],   404);
return Reponse::vue('erreur', [],                   500);
```

---

## Référence

| Méthode | Description |
|---|---|
| `Reponse::texte($contenu, $statut)` | Réponse texte brut |
| `Reponse::json($donnees, $statut)` | Réponse JSON |
| `Reponse::vue($nom, $donnees, $statut)` | Réponse HTML via une vue |
| `Reponse::rediriger($url, $statut)` | Redirection (302 par défaut) |
| `Reponse::telecharger($chemin, $nom)` | Forcer le téléchargement d'un fichier |
| `->avecEntete($nom, $valeur)` | Ajouter un en-tête HTTP |
| `->avecCookie($nom, $valeur, ...)` | Définir un cookie |
| `->sansCookie($nom)` | Supprimer un cookie |
| `->envoyer()` | Envoyer la réponse (appelé automatiquement) |
