<?php

namespace BackOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
class AdministrateurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                ->add('prenom')
                ->add('email')
                ->add('mot_de_passe', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmez votre mot de passe'),
            ))
        ;
    }
    
    public function buildFormLogin(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email')->add('mot_de_passe');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackOfficeBundle\Entity\Administrateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backofficebundle_administrateur';
    }


}
