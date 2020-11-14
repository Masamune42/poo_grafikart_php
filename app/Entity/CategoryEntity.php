<?php

namespace App\Entity;

use Core\Entity\Entity;

class CategoryEntity extends Entity
{
    /**
     * Récupère l'URL de la page de l'article
     *
     * @return string le lien de la page de l'article
     */
    public function getUrl()
    {
        return 'index.php?page=posts.category&id=' . $this->id;
    }
}
