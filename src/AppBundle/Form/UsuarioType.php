<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tipo_usuarios = array('NORMAL'=>'ROLE_USER', 'TECNICO'=>'ROLE_ADMIN');

        $builder->add('nombre',TextType::class,array('label'=>'Nombre:','required'=>true,'attr'=>array('class'=>'form-control nombre','placeholder'=>'Ingrese su nombre completo')))
            ->add('username', TextType::class,array('label'=>'Correo:','required'=>true,'attr'=>array('class'=>'form-control username','placeholder'=>'alhidalgo@correo.com')))
            ->add('tipo_usuario', ChoiceType::class ,array('label'=>'Tipo de Usuario:','choices'=>$tipo_usuarios,
                'choices_as_values' => true,'multiple'=>false,'expanded'=>true,'required'=>true,'attr'=>array('class'=>'tipo_usuario')
            ))
            ->add('contrasena',RepeatedType::class,array(
                'type'=>PasswordType::class,
                'first_options'=>array('label'=>'Contraseña:','required'=>true,'attr'=>array('class'=>'form-control contrasena')),
                'second_options'=>array('label'=>'Repetir Contraseña:','required'=>true,'attr'=>array('class'=>'form-control contrasena2'))
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario',
            'csrf_protection' =>false,
            'cascade_validation' => true, //Permite validacion de formularios dentro de otro
            'allow_extra_fields' =>true, //Permitir campos que no esten definidos en el formulario
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_usuario';
    }


}
