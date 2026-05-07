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
