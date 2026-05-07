# Validation

Flèche permet de valider les données envoyées par l'utilisateur.

## Utilisation

```php
$erreurs = $req->valider([
    'nom'    => 'requis|chaine|max:100',
    'email'  => 'requis|email',
    'age'    => 'requis|entier',
]);

if (!empty($erreurs)) {
    return Reponse::json(['erreurs' => $erreurs], 422);
}
```

## Règles disponibles

| Règle | Description |
|---|---|
| `requis` | Le champ ne peut pas être vide |
| `chaine` | Doit être du texte |
| `entier` | Doit être un nombre entier |
| `numerique` | Doit être un nombre (entier ou décimal) |
| `email` | Doit être une adresse email valide |
| `min:X` | Doit contenir au minimum X caractères |
| `max:X` | Ne doit pas dépasser X caractères |
| `unique:table,colonne` | La valeur ne doit pas déjà exister en base |
| `confirme` | Doit correspondre au champ `{champ}_confirmation` |

## Exemple de réponse d'erreur

```json
{
    "erreurs": {
        "nom": ["Le champ nom est obligatoire."],
        "email": ["Le champ email doit être une adresse email valide."]
    }
}
```

## Combiner plusieurs règles

```php
$req->valider([
    'mot_de_passe' => 'requis|chaine|min:8|max:100',
]);
```

## Règle `unique`

Vérifie que la valeur n'existe pas déjà dans la base de données.

```php
$req->valider([
    'email'  => 'requis|email|unique:utilisateurs,email',
    'pseudo' => 'requis|unique:utilisateurs', // colonne = nom du champ par défaut
]);
```

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
