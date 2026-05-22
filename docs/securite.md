# Sécurité

Flèche intègre des outils pour sécuriser vos applications contre les attaques courantes.

---

## Hachage des mots de passe

Utilisez `Hachage` pour ne jamais stocker les mots de passe en clair.

```php
use Fleche\Hachage;

// Hacher un mot de passe (bcrypt, coût 12)
$hash = Hachage::creer('mon-mot-de-passe');

// Vérifier un mot de passe lors de la connexion
if (Hachage::verifier($req->entree('mot_de_passe'), $utilisateur['mot_de_passe'])) {
    // Connexion réussie
}

// Vérifier si le hash doit être recalculé (après changement du coût)
if (Hachage::doitEtreRecalcule($utilisateur['mot_de_passe'])) {
    $nouveau = Hachage::creer($motDePasseBrut);
    DB::table('utilisateurs')->filtrer('id', $id)->modifier(['mot_de_passe' => $nouveau]);
}
```

### Exemple — Inscription + Connexion

```php
// Inscription
$id = DB::table('utilisateurs')->inserer([
    'email'        => $req->entree('email'),
    'mot_de_passe' => Hachage::creer($req->entree('mot_de_passe')),
]);

// Connexion
$utilisateur = DB::table('utilisateurs')
    ->filtrer('email', $req->entree('email'))
    ->premier();

if (!$utilisateur || !Hachage::verifier($req->entree('mot_de_passe'), $utilisateur['mot_de_passe'])) {
    return Reponse::json(['erreur' => 'Identifiants incorrects'], 401);
}
```

---

## Protection CSRF

Les attaques CSRF (Cross-Site Request Forgery) consistent à faire soumettre un formulaire à votre insu.

### Dans une vue — Générer le champ caché

```php
<form method="POST" action="/articles">
    <?= champJeton() ?>
    <!-- ou : -->
    <?= Jeton::champ() ?>

    <input type="text" name="titre">
    <button>Envoyer</button>
</form>
```

Le résultat généré :

```html
<input type="hidden" name="_jeton" value="a3f9...">
```

### Vérifier le jeton dans un middleware

```php
use Fleche\Middleware;
use Fleche\Jeton;
use Fleche\Requete;
use Fleche\Reponse;

class CsrfMiddleware implements Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        Jeton::verifierRequete($requete); // Lance une exception si invalide
        return $suivant($requete);
    }
}
```

### Vérification manuelle

```php
$jeton = $req->entree('_jeton', '');

if (!Jeton::valider($jeton)) {
    return Reponse::json(['erreur' => 'Jeton invalide'], 419);
}
```

---

## Protection XSS

Échappez toujours les variables avant de les afficher dans une vue.

```php
// Avec la fonction helper e()
<?= e($utilisateur['nom']) ?>

// Avec htmlspecialchars
<?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?>

// Ne jamais faire ça avec des données utilisateur
<?= $titre ?>   ← DANGEREUX
```

---

## Référence — Hachage

| Méthode | Description |
|---|---|
| `Hachage::creer($motDePasse, $cout)` | Hacher avec bcrypt (coût 12 par défaut) |
| `Hachage::verifier($brut, $hash)` | Vérifier un mot de passe |
| `Hachage::doitEtreRecalcule($hash)` | Vrai si le hash doit être regénéré |

---

## Référence — Jeton (CSRF)

| Méthode | Description |
|---|---|
| `Jeton::generer()` | Générer (ou retourner) le jeton CSRF |
| `Jeton::valider($jeton)` | Vérifier un jeton |
| `Jeton::champ()` | Retourner le champ `<input>` HTML |
| `Jeton::verifierRequete($req)` | Valider automatiquement (exception si invalide) |
| `champJeton()` | Helper global — équivalent à `Jeton::champ()` |
