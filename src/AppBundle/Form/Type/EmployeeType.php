<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'mapped' => false
            ))
            ->add('password', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, array(
                'mapped' => false
            ))
            ->add('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class, array(
                'mapped' => false
            ))
            ->add('lastName')
            ->add('firstName')
            ->add('registrationNumber')
            ->add('hiringDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class, array(
                'widget'         => 'single_text',
                'format'         => 'dd/MM/yyyy',
            ))
            ->add('maritalStatus')
            ->add('address')
            ->add('nbChildren')
            ->add('birthDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class, array(
                'widget'         => 'single_text',
                'format'         => 'dd/MM/yyyy',
            ))
            ->add('team', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                'class'         => 'AppBundle:Team',
                'choice_label'  => 'name',
                'multiple'      => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Employee'
        ));
    }
}
