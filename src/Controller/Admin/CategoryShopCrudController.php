<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use App\Entity\CategoryShop;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;


class CategoryShopCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryShop::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->setLabel('Nom'),
            SlugField::new('slug')->setTargetFieldName('name')->setLabel('Slug'),
        ];
    }
    
}
