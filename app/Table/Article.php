<?php

namespace App\Table;

use App\App;

class Article extends Table
{
    // private $id;

    // private $titre;

    // private $contenu;

    public static function find($id)
    {
        return self::query(
            "SELECT a.id, a.titre, a.contenu, c.titre as categorie
            FROM articles AS a
            LEFT JOIN categories AS c ON a.category_id = c.id
            WHERE a.id = ?",
            [$id],
            true
        );
    }

    protected static $table = 'articles';

    /**
     * Fonction magique : si on appelle une variable qui n'existe pas, on utilise cette variable selon nos besoins. ATTENTION : ne pas en abuser (voir ne pas l'utiliser)
     *
     * @param string $key clé de la valeur souhaitée
     * @return void
     */
    public function __get($key)
    {
        // On récupère la clé pour l'utiliser et appeler une fonction
        $method = 'get' . ucfirst($key);
        // On déclare une nouvelle propriété qui appellera la méthode voulue la prochaine fois qu'on utilisera cette propriété (= utilisation de la méthode magique une seule fois)
        $this->$key = $this->$method();
        return $this->$key;
    }

    /**
     * Récupère l'URL de la page de l'article
     *
     * @return string le lien de la page de l'article
     */
    public function getUrl()
    {
        return 'index.php?p=article&id=' . $this->id;
    }

    /**
     * Retourne le code HTML avec les 100 1ers caractères du contenu de l'article
     *
     * @return string
     */
    public function getExtrait()
    {
        $html = '<p>' . substr($this->contenu, 0, 100) . '...</p>';
        $html .= '<p><a href="' . $this->getURL() . '">Voir la suite</a></p>';
        return $html;
    }

    public static function getLast()
    {
        return self::query(
            'SELECT a.id, a.titre, a.contenu, c.titre as categorie
            FROM articles AS a
            LEFT JOIN categories AS c
                ON a.category_id = c.id
            ORDER BY a.date DESC'
        );
    }

    public static function lastByCategory($category_id)
    {
        return self::query(
            'SELECT a.id, a.titre, a.contenu, c.titre as categorie
            FROM articles AS a
            LEFT JOIN categories AS c
                ON a.category_id = c.id
            WHERE category_id = ?',
            [$category_id]
        );
    }
}
