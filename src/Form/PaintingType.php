<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Painting;
use App\Entity\Technical;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaintingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])

            ->add('smallDescription', TextareaType::class, [
                'label' => 'Brève description',
            ])
            ->add('fullDescription', TextareaType::class, [
                'label' => 'Description complète',
            ])
            ->add('height', NumberType::class, [
                'label' => 'Hauteur du tableau'
            ])
            ->add('width', NumberType::class, [
                'label' => 'Largeur du tableau'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label'  => 'name',
                'placeholder' => 'Sélectionnez...',
            ])
            ->add('technical', EntityType::class, [
                'class' => Technical::class,
                'choice_label'  => 'name',
                'placeholder' => 'Sélectionnez...',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Painting::class,
        ]);
    }
}
