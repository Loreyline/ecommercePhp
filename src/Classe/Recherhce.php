<?php

namespace App\Classe;

use App\Entity\Category;

class Recherche
{
    /**
     * @var string
     */
    public $texte = '';

    /**
     * @var Category[]
     */
    public $categories = [];

    /**
     * @var float[]
     */
    public $prix = [];
}
