<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Familly;
use App\Entity\Question;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('familly', EntityType::class, [
                'class' => Familly::class,
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->orderBy('u.id', 'DESC');
                },
                'required' => true
            ])
            ->add('name')
            ->add('answers', CollectionType::class, [
                'entry_type' => AnswerType::class,
                'label' => "Erantzunak",
                'block_name' => 'question_answers',
                'entry_options' => ['label'=>false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'collectionClass',
                    'autcomplete' => 'off'
                ]
            ])
            ->add('problem')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'QuestionType';
    }
}
