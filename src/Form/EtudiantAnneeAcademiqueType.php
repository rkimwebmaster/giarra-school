<?php

namespace App\Form;

use App\Entity\EtudiantAnneeAcademique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantAnneeAcademiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('matricule')
            ->add('telephoneTuteur')
            // ->add('hasReussie')
            ->add('identite', IdentiteType::class)
            ->add('adresse', AdresseType::class)
            ->add('genre', ChoiceType::class,[
                "choices"=>["Homme"=>"Mr", "Femme"=>"Mme"],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtudiantAnneeAcademique::class,
        ]);
    }
}
