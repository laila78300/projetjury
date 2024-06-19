<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\CategoryShop;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProduitsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('subtitle') 
            ->add('description')
            ->add('price')
            ->add('imageFile', VichImageType::class, [
                'required' => false,           
            ])
            ->add('datetime') 
            ->add('updated_at') 
            ->add('slug') 
            ->add('online')
            ->add('category', EntityType::class, [
                'class' => CategoryShop::class, 
                'choice_label' => 'name', 
                'placeholder' => 'Sélectionner une catégorie', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }

}


