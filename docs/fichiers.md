# Upload de fichiers

---

## Formulaire HTML

```html
<form method="POST" action="/photos" enctype="multipart/form-data">
    <?= champJeton() ?>
    <input type="file" name="photo" accept="image/*">
    <button type="submit">Envoyer</button>
</form>
```

---

## Lire et déplacer un fichier

```php
$app->routeur->post('/photos', function ($req) {
    $fichier = $req->fichier('photo');

    if (!$fichier || $fichier['error'] !== UPLOAD_ERR_OK) {
        return Reponse::json(['erreur' => 'Aucun fichier valide reçu'], 400);
    }

    // Informations disponibles
    $nom       = $fichier['name'];     // nom original
    $taille    = $fichier['size'];     // taille en octets
    $type      = $fichier['type'];     // type MIME
    $tmpName   = $fichier['tmp_name']; // chemin temporaire

    // Déplacer vers sa destination finale
    $destination = __DIR__ . '/../uploads/' . basename($nom);
    move_uploaded_file($tmpName, $destination);

    return Reponse::json(['chemin' => '/uploads/' . basename($nom)]);
});
```

---

## Exemple complet avec validation

```php
public function upload(Requete $req): Reponse
{
    $fichier = $req->fichier('photo');

    if (!$fichier || $fichier['error'] !== UPLOAD_ERR_OK) {
        return Reponse::json(['erreur' => 'Fichier manquant ou invalide'], 400);
    }

    // Vérifier le type MIME
    $typesAutorises = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($fichier['type'], $typesAutorises)) {
        return Reponse::json(['erreur' => 'Type de fichier non autorisé'], 422);
    }

    // Vérifier la taille (5 Mo max)
    if ($fichier['size'] > 5 * 1024 * 1024) {
        return Reponse::json(['erreur' => 'Fichier trop volumineux (max 5 Mo)'], 422);
    }

    // Générer un nom unique
    $extension   = pathinfo($fichier['name'], PATHINFO_EXTENSION);
    $nomUnique   = uniqid('photo_', true) . '.' . $extension;
    $destination = __DIR__ . '/../public/uploads/' . $nomUnique;

    if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
        return Reponse::json(['erreur' => 'Impossible de sauvegarder le fichier'], 500);
    }

    return Reponse::json(['url' => '/uploads/' . $nomUnique], 201);
}
```

---

## Codes d'erreur PHP

| Code | Signification |
|---|---|
| `UPLOAD_ERR_OK` (0) | Succès |
| `UPLOAD_ERR_INI_SIZE` (1) | Fichier trop grand (php.ini) |
| `UPLOAD_ERR_FORM_SIZE` (2) | Fichier trop grand (formulaire) |
| `UPLOAD_ERR_PARTIAL` (3) | Upload incomplet |
| `UPLOAD_ERR_NO_FILE` (4) | Aucun fichier envoyé |
| `UPLOAD_ERR_NO_TMP_DIR` (6) | Dossier temporaire manquant |
| `UPLOAD_ERR_CANT_WRITE` (7) | Impossible d'écrire sur le disque |
