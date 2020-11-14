<?php

namespace App\Entity;

use Core\Entity\Entity;

class PostEntity extends Entity
{
    /**
     * Récupère l'URL de la page de l'article
     *
     * @return string le lien de la page de l'article
     */
    public function getUrl()
    {
        return 'index.php?page=posts.show&id=' . $this->id;
    }

    /**
     * Retourne le code HTML avec les 100 1ers caractÃ¨res du contenu de l'article
     *
     * @return string
     */
    public function getExtrait()
    {
        $html = '<p>' . substr($this->contenu, 0, 100) . '...</p>';
        $html .= '<p><a href="' . $this->getURL() . '">Voir la suite</a></p>';
        return $html;
    }
}
