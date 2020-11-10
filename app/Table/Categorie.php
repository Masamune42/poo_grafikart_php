<?php

namespace App\Table;

use App\App;

class Categorie extends Table
{

    protected static $table = 'categories';

    /**
     * Récupère l'URL de la page de la catégorie
     *
     * @return string le lien de la page de la catégorie
     */
    public function getUrl()
    {
        return 'index.php?p=categorie&id=' . $this->id;
    }


    /**
     * Retourne le code HTML avec les 100 1ers caractères du contenu de la catégorie
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
