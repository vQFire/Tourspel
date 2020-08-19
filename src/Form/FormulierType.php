<?php

namespace App\Form;

use App\Entity\Formulier;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titel')
            ->add('Year', null, [
                'label' => 'Jaar'
            ])
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Regels' => 'Regels',
                    'Formulier' => 'Formulier'
                ]
            ])
            ->add('Content', CKEditorType::class, [
                'config' => [
                    'allowedContent' => true,
                    'extra_allow_content' => 'table(*)',
                    'paste_filter' => null,
                    'language' => 'nl'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formulier::class
        ]);
    }
}
