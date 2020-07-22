<?php

namespace App\Form;

use App\Entity\Questions;
use App\Entity\Tags;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content',TextType::class)
            ->add('tags', EntityType::class, [
                'class' => Tags::class,
                'expanded' => true,
                'multiple' => true,
                'mapped' => true,
                'choice_label' => 'name',
             ])
            ->add('send', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
        ]);
    }
}
