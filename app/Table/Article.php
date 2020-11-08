<?php

namespace App\Table;

class Article
{
    // private $id;

    // private $titre;

    // private $contenu;

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
    public function getUrl(): string
    {
        return 'index.php?p=article&id=' . $this->id;
    }

    /**
     * Retourne le code HTML avec les 100 1ers caractères du contenu de l'article
     *
     * @return string
     */
    public function getExtrait(): string
    {
        $html = '<p>' . substr($this->contenu, 0, 100) . '...</p>';
        $html .= '<p><a href="' . $this->getURL() . '">Voir la suite</a></p>';
        return $html;
    }
}
