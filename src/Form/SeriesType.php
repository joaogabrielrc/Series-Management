<?php

namespace App\Form;

use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        dd($options);
        $builder
            ->setAction($options['is_create'] ? '/series' : "/series/{$options['id']}")
            ->setMethod($options['is_create'] ? 'POST' : 'PATCH')
            ->add('name', TextType::class, ['label' => 'Nome:'])
            ->add('submit', SubmitType::class, ['label' => $options['is_create'] ? 'Adicionar' : 'Atualizar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Series::class,
            'is_create' => true,
            'id' => null
        ]);

        $resolver->setAllowedTypes(option: 'is_create', allowedTypes: 'bool');
    }
}
