<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 11/08/16
 * Time: 07:09
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VacationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, ['required'=>true])
            ->add('endDate', DateType::class, ['required'=>true])
            ->add('reason', TextType::class, ['required'=>false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'data_class'=>'AppBundle\Entity\VacationRequest'
       ]);
    }

}