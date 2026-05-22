# Validation

Flèche permet de valider les données d'une requête avant de les traiter.

---

## Utilisation de base

```php
// Lève une exception si la validation échoue
$req->valider([
    'nom'          => 'requis|chaine|max:100',
    'email'        => 'requis|email|unique:utilisateurs,email',
    'mot_de_passe' => 'requis|min:8|confirme',
    'age'          => 'nullable|entier|min_val:18',
]);

// Sans exception — vérifier manuellement
$validateur = $req->validerSans([
    'email' => 'requis|email',
]);

if ($validateur->echoue()) {
    return Reponse::json(['erreurs' => $validateur->erreurs()], 422);
}
```

---

## Utilisation directe du Validateur

```php
use Fleche\Validateur;

$validateur = Validateur::verifier($donnees, [
    'titre'   => 'requis|chaine|max:200',
    'contenu' => 'requis|chaine',
]);

if ($validateur->echoue()) {
    $toutesLesErreurs = $validateur->erreurs();
    $premiereErreur   = $validateur->premiere('titre');
}
```

---

## Règles disponibles

| Règle | Description | Exemple |
|---|---|---|
| `requis` | Le champ ne peut pas être vide | `requis` |
| `nullable` | Ignorer les autres règles si le champ est vide | `nullable\|email` |
| `chaine` | Doit être du texte | `chaine` |
| `entier` | Doit être un nombre entier | `entier` |
| `numerique` | Doit être un nombre (entier ou décimal) | `numerique` |
| `booleen` | Doit être un booléen (`true/false/0/1`) | `booleen` |
| `email` | Doit être une adresse email valide | `email` |
| `url` | Doit être une URL valide | `url` |
| `min:X` | Minimum X **caractères** | `min:8` |
| `max:X` | Maximum X **caractères** | `max:200` |
| `min_val:X` | Valeur numérique ≥ X | `min_val:18` |
| `max_val:X` | Valeur numérique ≤ X | `max_val:120` |
| `regex:motif` | Doit correspondre à l'expression régulière | `regex:/^[a-z]+$/` |
| `dans:a,b,c` | La valeur doit être dans la liste | `dans:admin,editeur,lecteur` |
| `confirme` | Doit correspondre au champ `{champ}_confirmation` | `confirme` |
| `unique:table,col` | La valeur ne doit pas déjà exister en base | `unique:utilisateurs,email` |

---

## Règle `nullable`

Permet qu'un champ soit absent ou vide — les autres règles sont ignorées dans ce cas.

```php
$req->valider([
    'site_web'  => 'nullable|url',           // optionnel mais doit être une URL si présent
    'telephone' => 'nullable|chaine|max:20', // optionnel
]);
```

---

## Règle `confirme`

Le champ `{nom}_confirmation` doit exister et avoir la même valeur.

```php
$req->valider([
    'mot_de_passe' => 'requis|min:8|confirme',
]);
```

```html
<input type="password" name="mot_de_passe">
<input type="password" name="mot_de_passe_confirmation">
```

---

## Règle `unique`

Vérifie que la valeur n'existe pas déjà dans la base de données.

```php
$req->valider([
    'email'  => 'requis|email|unique:utilisateurs,email',
    'pseudo' => 'requis|unique:utilisateurs', // colonne = nom du champ par défaut
]);
```

---

## Format des erreurs

```json
{
    "erreurs": {
        "nom":          ["Le champ nom est obligatoire."],
        "email":        ["Le champ email doit être une adresse email valide."],
        "mot_de_passe": ["Le champ mot_de_passe doit contenir au minimum 8 caractères."]
    }
}
```

---

## Exemple complet — Inscription

```php
public function inscrire(Requete $req): Reponse
{
    $validateur = $req->validerSans([
        'nom'                      => 'requis|chaine|max:100',
        'email'                    => 'requis|email|unique:utilisateurs,email',
        'mot_de_passe'             => 'requis|min:8|confirme',
        'role'                     => 'nullable|dans:admin,editeur,lecteur',
    ]);

    if ($validateur->echoue()) {
        return Reponse::json(['erreurs' => $validateur->erreurs()], 422);
    }

    $id = DB::table('utilisateurs')->inserer([
        'nom'          => $req->entree('nom'),
        'email'        => $req->entree('email'),
        'mot_de_passe' => Hachage::creer($req->entree('mot_de_passe')),
        'role'         => $req->entree('role', 'lecteur'),
    ]);

    return Reponse::json(['id' => $id], 201);
}
```

---

## Référence — Validateur

| Méthode | Description |
|---|---|
| `Validateur::verifier($donnees, $regles)` | Créer et valider en une fois |
| `->valider()` | Lancer la validation — retourne le tableau d'erreurs |
| `->echoue()` | `true` si des erreurs existent |
| `->reussi()` | `true` si aucune erreur |
| `->erreurs()` | Tableau complet des erreurs |
| `->premiere($champ)` | Première erreur d'un champ |
