<?php

namespace App\Form;

use App\Entity\PromotionConcrete;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionConcreteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('promotionAbstraite')
            ->add('specification', ChoiceType::class,[
                "choices"=>["A"=>"A","B"=>"B", "C"=>"C", "D"=>"D"]
            ])
            ->add('annneeAcademique')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PromotionConcrete::class,
        ]);
    }
}
