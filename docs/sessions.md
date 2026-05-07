# Sessions

Les sessions permettent de conserver des données entre les requêtes HTTP.

---

## Utilisation de base

```php
use Fleche\Session;

// Sauvegarder
Session::definir('utilisateur_id', 42);
Session::definir('nom', 'Harouna');

// Lire
$id  = Session::obtenir('utilisateur_id');
$nom = Session::obtenir('nom', 'Anonyme'); // avec valeur par défaut

// Vérifier l'existence
if (Session::a('utilisateur_id')) {
    // utilisateur connecté
}

// Supprimer une clé
Session::supprimer('utilisateur_id');

// Tout effacer (déconnexion)
Session::vider();
```

---

## Messages flash

Un message flash est **lu une seule fois** puis automatiquement supprimé. Utile pour les notifications après une redirection.

```php
// Définir un message flash
Session::flash('succes', 'Votre compte a été créé avec succès !');
Session::flash('erreur', 'Email ou mot de passe incorrect.');

// Lire et supprimer le message
$message = Session::obtenirFlash('succes'); // "Votre compte a été créé avec succès !"
$message = Session::obtenirFlash('succes'); // null — déjà supprimé
```

Afficher dans une vue :

```php
<?php $succes = Session::obtenirFlash('succes'); ?>

<?php if ($succes): ?>
    <div class="alerte alerte-succes">
        <?= htmlspecialchars($succes) ?>
    </div>
<?php endif; ?>
```

---

## Exemple complet — Connexion / Déconnexion

```php
// Connexion
$app->routeur->post('/connexion', function ($req) {
    $utilisateur = DB::table('utilisateurs')
        ->filtrer('email', $req->entree('email'))
        ->premier();

    if (!$utilisateur) {
        return Reponse::json(['erreur' => 'Identifiants incorrects'], 401);
    }

    Session::definir('utilisateur_id', $utilisateur['id']);
    Session::definir('utilisateur_nom', $utilisateur['nom']);

    return Reponse::rediriger('/tableau-de-bord');
});

// Déconnexion
$app->routeur->get('/deconnexion', function () {
    Session::vider();
    Session::flash('succes', 'Vous avez été déconnecté.');
    return Reponse::rediriger('/connexion');
});
```

---

## Référence

| Méthode | Description |
|---|---|
| `Session::definir($cle, $valeur)` | Sauvegarder une valeur |
| `Session::obtenir($cle, $defaut)` | Lire une valeur |
| `Session::a($cle)` | Vérifier si une clé existe |
| `Session::supprimer($cle)` | Supprimer une clé |
| `Session::vider()` | Effacer toute la session |
| `Session::flash($cle, $message)` | Définir un message flash |
| `Session::obtenirFlash($cle)` | Lire et supprimer un message flash |
