<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomFormation', TextType::class, [
                'label' => 'Nom de la Formation',
                'attr' => ['class' => 'form-control'],
                'empty_data' => '' // Set default value
                
            ])
            ->add('discription', TextType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
                'empty_data' => '' // Set default value
            ])
            ->add('nombrePlaces', IntegerType::class, [
                'label' => 'Nombre de Places',
                'attr' => ['class' => 'form-control'],
                'empty_data' =>  0  // Set default value
            
            ]);
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
