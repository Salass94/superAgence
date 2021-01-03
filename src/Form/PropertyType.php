<?php

namespace App\Form;

use App\Form\ImageType;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'help' => 'Ce champs est optionnel'
            ])
            ->add('price',IntegerType::class, [
                'label' => 'Prix',
                'help' => 'Le prix en mru'
            ])
            ->add('area', IntegerType::class, [
                'label' => 'Surface',
                'help' => 'Surface en m²'
            ])
            ->add('room', IntegerType::class, [
                'label' => 'Chambre',
            ])
            ->add('bedroom', IntegerType::class, [
                'label' => 'Chambre à coucher',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Maison' => '1',
                    'Appartement' => '2'
                ],
                'label' => 'Type de logement',
            ])
            // ->add('swimming_pool', BooleanType::class,[
            //     'label' => 'Piscine',
            //     'help' => 'Ce champs est optionnel'
            // ])
            // ->add('garden', BooleanType::class,[
            //     'label' => 'Jardin',
            //     'help' => 'Ce champs est optionnel'
            // ])
            // ->add('air_conditioner', BooleanType::class,[
            //     'label' => 'Climatisation',
            //     'help' => 'Ce champs est optionnel'
            // ])
            // ->add('terrace', BooleanType::class,[
            //     'label' => 'Terrasse',
            //     'help' => 'Ce champs est optionnel'
            // ])
            ->add('garage', IntegerType::class,[
                'label' => 'Garage',
                'help' => 'Ce champs est optionnel'
            ])
            ->add('filename', FileType::class, [
                'label'=> false,
                'multiple' => true,
                'mapped' => false
            ])
            // ->add('images', CollectionType::class, [
            //     'entry_type' => ImageType::class,
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'prototype' => true
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
