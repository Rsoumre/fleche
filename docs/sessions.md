# Sessions

Les sessions permettent de conserver des données entre les requêtes HTTP.

---

## Utilisation de base

```php
use Fleche\Session;

// Sauvegarder
Session::definir('utilisateur_id', 42);

// Lire (avec valeur par défaut)
$id = Session::obtenir('utilisateur_id', null);

// Vérifier l'existence
if (Session::a('utilisateur_id')) {
    // utilisateur connecté
}

// Ajouter à un tableau
Session::pousser('panier', $produitId);

// Supprimer une clé
Session::supprimer('utilisateur_id');

// Effacer toute la session
Session::vider();

// Régénérer l'ID de session (après connexion)
Session::regenerer();
```

---

## Messages flash

Un message flash est **lu une seule fois** puis automatiquement supprimé.

```php
// Définir
Session::flash('succes', 'Votre compte a été créé !');
Session::flash('erreur', 'Email ou mot de passe incorrect.');

// Lire et supprimer
$message = Session::obtenirFlash('succes');

// Vérifier sans lire
if (Session::aFlash('succes')) { ... }

// Lire et supprimer tous les flash d'un coup
$tousLesFlash = Session::toutesLesFlash();
```

Afficher dans une vue :

```php
<?php $succes = Session::obtenirFlash('succes'); ?>
<?php if ($succes): ?>
    <div class="alerte alerte-succes"><?= e($succes) ?></div>
<?php endif; ?>
```

Avec les helpers globaux :

```php
// Définir un flash
flash('succes', 'Profil mis à jour !');

// Lire un flash
$message = flash('succes');
```

---

## Exemple — Connexion / Déconnexion

```php
// Connexion
$app->routeur->post('/connexion', function ($req) {
    $utilisateur = DB::table('utilisateurs')
        ->filtrer('email', $req->entree('email'))
        ->premier();

    if (!$utilisateur || !Hachage::verifier($req->entree('mot_de_passe'), $utilisateur['mot_de_passe'])) {
        return Reponse::json(['erreur' => 'Identifiants incorrects'], 401);
    }

    Session::definir('utilisateur_id', $utilisateur['id']);
    Session::regenerer(); // Prévenir la fixation de session
    Session::flash('succes', 'Bienvenue !');

    return Reponse::rediriger('/tableau-de-bord');
});

// Déconnexion
$app->routeur->get('/deconnexion', function () {
    Session::vider();
    return Reponse::rediriger('/connexion');
});
```

---

## Référence

| Méthode | Description |
|---|---|
| `Session::demarrer()` | Démarrer la session (automatique via Application) |
| `Session::definir($cle, $val)` | Sauvegarder une valeur |
| `Session::obtenir($cle, $defaut)` | Lire une valeur |
| `Session::a($cle)` | Vérifier si une clé existe |
| `Session::pousser($cle, $val)` | Ajouter à un tableau en session |
| `Session::supprimer($cle)` | Supprimer une clé |
| `Session::vider()` | Effacer toute la session |
| `Session::regenerer()` | Régénérer l'ID de session |
| `Session::id()` | Obtenir l'ID de session courant |
| `Session::flash($cle, $msg)` | Définir un message flash |
| `Session::obtenirFlash($cle)` | Lire et supprimer un flash |
| `Session::aFlash($cle)` | Vérifier si un flash existe |
| `Session::toutesLesFlash()` | Lire et supprimer tous les flash |
