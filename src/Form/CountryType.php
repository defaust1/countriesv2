<?php

namespace App\Form;

use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nombre_comun', TextType::class, ['label' => 'Nombre Comun '])
        ->add('nombre_oficial', TextType::class, ['label' => 'Nombre oficial '])
        ->add('capital', TextType::class, ['label' => 'Capital '])
        ->add('codigo_iso', TextType::class, ['label' => 'Añadir Iso: Ej: AFG '])
        ->add('region', TextType::class, ['label' => 'Region '])
        ->add('poblacion', TextType::class, ['label' => 'Numero Habitantes '])
        ->add('area', TextType::class, ['label' => 'Area Numérico '])
        ->add('lat', TextType::class, ['label' => 'Latitud Numérico '])
        ->add('lng', TextType::class, ['label' => 'Lógitud Numérico '])
        ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary'], 'label' => 'Añadir País ']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Country::class,
        ]);
    }

}
