<?php
// src/Form/UserForm.php
namespace App\Form;
use App\Document\User; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\FormTypeInterface; 

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->setMethod('POST')
        ->add('firstName', TextType::class,array("label"=>'First Name','attr' => array('class' => 'form-control')))
        ->add('lastName', TextType::class,array("label"=>'Last Name','attr' => array('class' => 'form-control')))
        ->add('email', CollectionType::class, array(
            // each entry in the array will be an "email" field
            'entry_type' => EmailType::class,
            // these options are passed to each "email" type
            'entry_options' => array(
                'attr' => array('class' => 'email-box form-control'),
            ),
            'allow_add' =>true,
            'prototype' => true,
         ))
         ->add('mobile', CollectionType::class, array(
            // each entry in the array will be an "mobile" field
            'entry_type' => TelType::class,
            // these options are passed to each "email" type
            'entry_options' => array(
                'attr' => array('class' => 'form-control'),
            ),
            'allow_add' =>true,
            'prototype' => true,
         ))
        ->add('dateofBirth', DateType::class, array(
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'attr' => array('class' => 'form-control')
        ))
        ->add('education', CollectionType::class, array(
            'entry_type' => TextType::class,
            'entry_options' => array(
                'attr' => array('class' => 'form-control'),
            ),
            'allow_add' =>true,
            'prototype' => true,
         ))
        ->add('bloodGroup', TextType::class,array("label"=>'Blood Group','attr' => array('class' => 'form-control')))
        ->add('gender', ChoiceType::class, array("label"=>'Gender',
                                                         'attr' => array('class' => 'form-control'),
                                                        'choices'  => array(
                                                            'Male' => 'Male',
                                                            'Female' => 'Female'
                                                        )));
        ;
    }
   
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => user::class,
        ));
    }
    
}
?>