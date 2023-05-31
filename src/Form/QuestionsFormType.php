<?php

namespace App\Form;

use App\Entity\Questions;
use App\Entity\Types;
use App\Entity\Values;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('subject', options:[
                'label'=> 'subject',
            ])
            ->add('parent', EntityType::class,[
                'class' => Questions::class,
                'choice_label' => 'subject',
            ])
            ->add('type', EntityType::class, [
                'class' => Types::class,
                'choice_label' => 'type'
            ])
            ->add('value', EntityType::class, [
                'class' => Values::class,
                'choice_label' => 'value'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
        ]);
    }
}
