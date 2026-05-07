# Validation

Flèche permet de valider les données envoyées par l'utilisateur avant de les traiter.

---

## Utilisation

```php
$erreurs = $req->valider([
    'nom'          => 'requis|chaine|max:100',
    'email'        => 'requis|email|unique:utilisateurs,email',
    'mot_de_passe' => 'requis|min:8|confirme',
    'age'          => 'requis|entier',
]);

if (!empty($erreurs)) {
    return Reponse::json(['erreurs' => $erreurs], 422);
}
```

---

## Règles disponibles

| Règle | Description | Exemple |
|---|---|---|
| `requis` | Le champ ne peut pas être vide | `requis` |
| `chaine` | Doit être du texte | `chaine` |
| `entier` | Doit être un nombre entier | `entier` |
| `numerique` | Doit être un nombre (entier ou décimal) | `numerique` |
| `email` | Doit être une adresse email valide | `email` |
| `min:X` | Minimum X caractères | `min:8` |
| `max:X` | Maximum X caractères | `max:200` |
| `unique:table,colonne` | La valeur ne doit pas déjà exister en base | `unique:utilisateurs,email` |
| `confirme` | Doit correspondre au champ `{champ}_confirmation` | `confirme` |

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

## Règle `confirme`

Vérifie que la valeur correspond au champ `{champ}_confirmation`.

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

## Format des erreurs

En cas d'échec, chaque champ contient un tableau de messages :

```json
{
    "erreurs": {
        "nom": ["Le champ nom est obligatoire."],
        "email": ["Le champ email doit être une adresse email valide."],
        "mot_de_passe": ["Le champ mot_de_passe doit contenir au minimum 8 caractères."]
    }
}
```

---

## Exemple complet — Inscription

```php
public function inscrire(Requete $req): Reponse
{
    $erreurs = $req->valider([
        'nom'                      => 'requis|chaine|max:100',
        'email'                    => 'requis|email|unique:utilisateurs,email',
        'mot_de_passe'             => 'requis|min:8|confirme',
    ]);

    if (!empty($erreurs)) {
        return Reponse::json(['erreurs' => $erreurs], 422);
    }

    $id = DB::table('utilisateurs')->inserer([
        'nom'          => $req->entree('nom'),
        'email'        => $req->entree('email'),
        'mot_de_passe' => password_hash($req->entree('mot_de_passe'), PASSWORD_DEFAULT),
    ]);

    return Reponse::json(['id' => $id], 201);
}
```
