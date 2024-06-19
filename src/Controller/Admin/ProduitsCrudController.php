<?php

namespace App\Controller\Admin;

use App\Entity\Produits;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;


class ProduitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produits::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title')->setLabel('Titre'),
            SlugField::new('slug')->setTargetFieldName('title')->setLabel('Slug'),
            TextEditorField::new('description')->setLabel('Description'),
            BooleanField::new('online')->setLabel('En ligne'),
            ImageField::new('image')->setLabel('Image')->setBasePath('/images/produits')->onlyOnIndex(), 
            Field::new('imageFile')->setLabel('Image')->setFormType(VichImageType::class)->hideOnIndex(), 
            TextareaField::new('subtitle')->setLabel('Sous-titre'),
            MoneyField::new('price')->setCurrency('EUR')->setLabel('Prix')->setFormTypeOptions([
                'divisor' => 100, // Diviser la valeur du champ par 100 lors de l'édition
            ]),
            AssociationField::new('Category')->setLabel('Catégorie'),
            DateTimeField::new('datetime')->setLabel('Date et heure'),
            DateTimeField::new('updated_at')->setLabel('Mise à jour le'),

        ];
    }

}


