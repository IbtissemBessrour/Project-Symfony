<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dateDebue', DateType::class, [
            'label' => 'Date de début',
            'widget' => 'single_text',
            'attr' => ['class' => 'form-control'],
            'required' => true,
            //'data' => new \DateTime('now'),
        ])
        ->add('dateFine', DateType::class, [
            'label' => 'Date de fin',
            'widget' => 'single_text',
            'attr' => ['class' => 'form-control'],
            'required' => true,
            //'data' => new \DateTime('now'),
        ])
        ->add('nomFormation', TextType::class, [
            'label' => 'Nom de la formation',
            'attr' => ['class' => 'form-control'],
            'empty_data' => '' // Set default value
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
