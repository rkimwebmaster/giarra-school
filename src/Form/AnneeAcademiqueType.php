<?php

namespace App\Form;

use App\Entity\AnneeAcademique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnneeAcademiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debut')
            ->add('fin',null,[
                "disabled"=>true,
            ])
            ->add('isEnCours')
            // ->add('isPasse')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnneeAcademique::class,
        ]);
    }
}
