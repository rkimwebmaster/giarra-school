<?php

namespace App\Form;

use App\Entity\PromotionAbstraite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionAbstraiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', ChoiceType::class,[
                "choices"=>["Première"=>"Première","Deuxième"=>"Deuxième ","Troisième"=>"Troisième","Quatrième"=>"Quatrième","Cinquième"=>"Cinquième","Sixième"=>"Sixième",]
            ])
            ->add('description')
            ->add('departement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PromotionAbstraite::class,
        ]);
    }
}
