# Sessions

Les sessions permettent de conserver des données entre les requêtes.

## Utilisation

```php
use Fleche\Session;

// Sauvegarder une valeur
Session::definir('utilisateur_id', 42);

// Lire une valeur
$id = Session::obtenir('utilisateur_id');

// Lire avec une valeur par défaut
$nom = Session::obtenir('nom', 'Anonyme');

// Vérifier si une clé existe
if (Session::a('utilisateur_id')) {
    // utilisateur connecté
}

// Supprimer une clé
Session::supprimer('utilisateur_id');

// Tout effacer (déconnexion)
Session::vider();
```

## Messages flash

Un message flash est lu une seule fois puis automatiquement supprimé.

```php
// Définir un message flash
Session::flash('succes', 'Votre compte a été créé !');
Session::flash('erreur', 'Email ou mot de passe incorrect.');

// Lire et supprimer le message
$message = Session::obtenirFlash('succes'); // "Votre compte a été créé !"
$message = Session::obtenirFlash('succes'); // null (déjà supprimé)
```

## Exemple — connexion / déconnexion

```php
// Connexion
$app->routeur->post('/connexion', function ($req) {
    $utilisateur = DB::table('utilisateurs')
        ->filtrer('email', $req->entree('email'))
        ->premier();

    if (!$utilisateur || $req->entree('mot_de_passe') !== $utilisateur['mot_de_passe']) {
        return Reponse::json(['erreur' => 'Identifiants incorrects'], 401);
    }

    Session::definir('utilisateur_id', $utilisateur['id']);
    return Reponse::json(['message' => 'Connecté']);
});

// Déconnexion
$app->routeur->get('/deconnexion', function () {
    Session::vider();
    return Reponse::json(['message' => 'Déconnecté']);
});
```
