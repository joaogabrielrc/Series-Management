<?php

namespace App\Form;

use App\Dto\SeriesFormDto;
use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction($options['is_create'] ? '/series' : "/series/{$options['id']}")
            ->setMethod($options['is_create'] ? 'POST' : 'PATCH')
            ->add('name', TextType::class, ['label' => 'Nome:'])
            ->add('seasonsQuantity', IntegerType::class, ['label' => 'Quantidade de temporadas:'])
            ->add('episodesPerSeason', IntegerType::class, ['label' => 'Quantidade de episodios por temporada:'])
            ->add('submit', SubmitType::class, ['label' => $options['is_create'] ? 'Adicionar' : 'Atualizar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeriesFormDto::class,
            'is_create' => true,
            'id' => null
        ]);

        $resolver->setAllowedTypes(option: 'is_create', allowedTypes: 'bool');
    }
}
