# Modèle ORM

La classe `Modele` est une base Active Record qui simplifie les interactions avec la base de données.

---

## Créer un modèle

```php
// src/Modeles/Article.php
namespace App\Modeles;

use Fleche\Modele;

class Article extends Modele
{
    protected static string $table = 'articles';
    protected static string $cle   = 'id'; // clé primaire (défaut : 'id')
}
```

---

## Récupérer des enregistrements

```php
// Tous les articles
$articles = Article::tout();

// Par ID
$article = Article::trouver(42);

// Par ID — lève une exception 404 si introuvable
$article = Article::trouverOuEchouer(42);

// Premier correspondant
$article = Article::premier('slug', 'mon-article');

// Plusieurs correspondants
$articles = Article::ou('categorie', 'tech');

// Avec filtres avancés via le requêteur
$articles = Article::requeteur()
    ->filtrer('publie', 1)
    ->trier('created_at', 'DESC')
    ->paginer($page, 15);
```

---

## Accéder aux attributs

```php
$article = Article::trouver(1);

echo $article->titre;
echo $article->contenu;

// Convertir en tableau
$data = $article->versTableau();
```

---

## Créer un enregistrement

```php
$article = Article::creer([
    'titre'      => 'Mon article',
    'contenu'    => 'Le contenu...',
    'publie'     => 0,
    'created_at' => date('Y-m-d H:i:s'),
]);

echo $article->id; // ID auto-incrémenté
```

---

## Modifier et sauvegarder

```php
$article = Article::trouver(42);
$article->titre   = 'Nouveau titre';
$article->publie  = 1;
$article->sauvegarder(); // UPDATE uniquement les champs modifiés
```

---

## Supprimer

```php
$article = Article::trouver(42);
$article->supprimer();
```

---

## Compter et paginer

```php
$total = Article::compter();

$paginator = Article::paginer($page, 15);
// $paginator->items  — tableau d'objets Article
// $paginator->total  — nombre total
```

---

## Exemple complet — Contrôleur avec modèle

```php
class ArticleControleur extends Controleur
{
    public function liste(Requete $req): Reponse
    {
        $page      = (int) $req->obtenir('page', 1);
        $paginator = Article::requeteur()
            ->filtrer('publie', 1)
            ->trier('created_at', 'DESC')
            ->paginer($page, 10);

        return $this->vue('articles.liste', compact('paginator'));
    }

    public function afficher(Requete $req): Reponse
    {
        $article = Article::trouverOuEchouer($req->parametre('id'));
        return $this->vue('articles.detail', compact('article'));
    }

    public function creer(Requete $req): Reponse
    {
        $req->valider([
            'titre'   => 'requis|chaine|max:200',
            'contenu' => 'requis|chaine',
        ]);

        $article = Article::creer([
            'titre'      => $req->entree('titre'),
            'contenu'    => $req->entree('contenu'),
            'publie'     => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return Reponse::json($article->versTableau(), 201);
    }
}
```

---

## Référence

| Méthode | Description |
|---|---|
| `Modele::tout()` | Retourner tous les enregistrements |
| `Modele::trouver($id)` | Trouver par clé primaire |
| `Modele::trouverOuEchouer($id)` | Trouver ou lancer une exception |
| `Modele::premier($colonne, $valeur)` | Premier correspondant |
| `Modele::ou($colonne, $valeur)` | Tous les correspondants |
| `Modele::creer($donnees)` | INSERT et retourner l'instance |
| `Modele::compter()` | Nombre d'enregistrements |
| `Modele::paginer($page, $parPage)` | Retourner un Paginateur |
| `Modele::requeteur()` | Obtenir le Requeteur pour filtres avancés |
| `$instance->sauvegarder()` | INSERT si nouveau, UPDATE si existant |
| `$instance->supprimer()` | DELETE |
| `$instance->remplir($donnees)` | Remplir plusieurs attributs |
| `$instance->versTableau()` | Convertir en tableau associatif |
