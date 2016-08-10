<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'required' => true
            ))
            ->add('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class, array(
                'required' => true
            ))
            ->add('plainPassword', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, array(
                'required' => true,
            ))
            ->add('lastName')
            ->add('firstName')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
