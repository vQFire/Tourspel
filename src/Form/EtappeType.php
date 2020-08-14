<?php

namespace App\Form;

use App\Entity\Etappe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtappeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Stage', TextType::class, [
                'attr' => [
                    'inputmode' => 'numeric'
                ]
            ])
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Type' => [
                        'Vlak' => 'Vlak',
                        'Berg' => 'Berg',
                        'Heuvel' => 'Heuvel',
                        'Tijdrit' => 'Tijdrit',
                        'Plg. Tijdrit' => 'Plg. Tijdrit',
                        'Kasseien' => 'Kasseien',
                        'Rust dag' => 'Rust dag',
                        'Klassement' => [
                            'Voorspelling Eindklassement' => 'Voorspelling Eindklassement',
                            'Eindstand Tourspel' => 'Eindstand Tourspel',
                            'Analyse / punten per categorie' => 'Analyse / punten per categorie'
                        ]
                    ]
                ],
                'placeholder' => 'Kies een type'
            ])
            ->add('Date', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('Start')
            ->add('Finish')
            ->add('Distance', null, [
                'label' => 'Afstand'
            ])
            ->add('Renner')
            ->add('Deelnemer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etappe::class,
        ]);
    }
}
