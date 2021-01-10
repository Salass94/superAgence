<?php

namespace App\Form;

use App\Form\ImageType;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                'label' => 'Title',
            ])
            ->add('price',IntegerType::class, [
                'label' => 'Price',
            ])
            ->add('area', IntegerType::class, [
                'label' => 'Area',
            ])
            ->add('room', IntegerType::class, [
                'label' => 'Room',
            ])
            ->add('bedroom', IntegerType::class, [
                'label' => 'Bedroom',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'House' => '1',
                    'Appartement' => '2'
                ],
                'label' => 'Type Property',
            ])
            ->add('swimming_pool', CheckboxType::class,[
                'required' => false,
                'label' => 'Swimming_pool',
                'help' => 'Field optional'
            ])
            ->add('garden', CheckboxType::class,[
                'required' => false,
                'label' => 'Garden',
                'help' => 'Field optional'
            ])
            ->add('air_conditioner', CheckboxType::class,[
                'required' => false,
                'label' => 'Air conditioner',
                'help' => 'Field optional'
            ])
            ->add('terrace', CheckboxType::class,[
                'required' => false,
                'label' => 'Terrace',
                'help' => 'Field optional'
            ])
            ->add('garage', IntegerType::class,[
                'label' => 'Garage',
                'help' => 'Field optional'
            ])
        
            ->add('images', CollectionType::class, [
                'label'=> false,
                'entry_type' => ImageType::class,
                'allow_add' => true,
                // 'allow_delete' => true,
                'prototype' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
           
        ]);
    }
}
