<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            TextField::new('subtitle'),
            TextareaField::new('description'),
            MoneyField::new('prix')->setCurrency('EUR'),
            IntegerField::new('quantite'),
            ImageField::new('image')
                ->setBasePath('assets/images/produits/')
                ->setUploadDir('public/assets/images/produits/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('category'),
            BooleanField::new('isBest')
        ];
    }
}
