# Upload de fichiers

## Formulaire HTML

```html
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="photo">
</form>
```

## Vérifier et déplacer un fichier

```php
if ($req->aFichier('photo')) {
    $fichier = $req->fichier('photo');
    // $fichier['name'] — nom original
    // $fichier['size'] — taille en octets
    // $fichier['type'] — type MIME

    $req->deplacer('photo', __DIR__ . '/uploads/' . $fichier['name']);
}
```

## Méthodes disponibles

| Méthode | Description |
|---|---|
| `$req->aFichier('cle')` | Retourne `true` si le fichier est présent et valide |
| `$req->fichier('cle')` | Retourne les infos du fichier ou `null` |
| `$req->deplacer('cle', $destination)` | Déplace le fichier vers sa destination finale |

> `deplacer()` crée automatiquement le dossier de destination s'il n'existe pas.
