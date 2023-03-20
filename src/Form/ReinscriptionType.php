<?php

namespace App\Form;

use App\Entity\Reinscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReinscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('promotionConcrete')
            // ->add('utilisateur')
            // ->add('etudiantAnneeAcademique')
            // ->add('inscription')
            ->add('anneeAcademique')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reinscription::class,
        ]);
    }
}
