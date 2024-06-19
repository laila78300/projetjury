<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), 
            DateTimeField::new('createdAt', 'Créé le'),
            AssociationField::new('user')->setLabel('Adresse e-mail du User'),
            TextField::new('delivery')->setLabel('Livraison'),
            BooleanField::new('isPaid')->setLabel('Payé'),
            TextField::new('method')->setLabel('Méthode'),
            TextField::new('reference')->setLabel('Référence'),
            TextField::new('stripeSessionId')->hideOnIndex()->setLabel('ID de session Stripe'), 
            TextField::new('paypalOrderId')->hideOnIndex()->setLabel('ID de commande PayPal'), 
        ];
    }
    
}
