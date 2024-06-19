<?php

namespace App\Controller\Admin;

use App\Entity\Transporteur;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class TransporteurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transporteur::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title')->setLabel('Titre'),
            TextEditorField::new('content')->setLabel('Description'),
            MoneyField::new('price')->setLabel('Prix')->setCurrency('EUR')->setFormTypeOptions([
                'divisor' => 100, // Diviser la valeur du champ par 100 lors de l'édition
            ]),
        ];
    }
    
}
