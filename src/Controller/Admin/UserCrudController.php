<?php

namespace App\Controller\Admin;

use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('lastname')->setLabel('Nom'),
            TextField::new('firstname')->setLabel('Prénom'),
            TextField::new('city')->setLabel('Ville'),
            TextField::new('postalCode')->setLabel('Code Postal'),
            TextareaField::new('address')->setLabel('Adresse'),
            EmailField::new('email')->setLabel('Email'),
            TextField::new('password')->hideOnIndex()->setLabel('Mot de passe'),
            BooleanField::new('agreeTerms')->setLabel('Accepter les C.G.V'),
        ];

    }
    
}
