<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return[
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            ImageField::new('illustration')
                 ->setUploadDir('public/uploads')
                 ->setBasePath('uploads/') // ce path pourque EasyAdmin nous affichera les images de produit
                 ->setUploadedFileNamePattern('[randomhash].[extension]') // fixer un nom aleatoire de chaine de caractere au image dans le site
                 ->setRequired(false),                 
            TextField::new('subtitle'),
            TextareaField::new('description'), 
            MoneyField::new('price')->setCurrency('EUR'),           
            AssociationField::new('category')
        ];
    }
}
