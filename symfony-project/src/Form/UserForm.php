<?php
// src/Form/UserForm.php
namespace App\Form;

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

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->setAction('new')
        ->setMethod('GET')
        ->add('firstName', TextType::class)
        ->add('lastName', TextType::class)
        ->add('email', TextType::class)
        ->add('mobile', TextType::class)
        ->add('dateofBirth', DateType::class, array(
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
        ))
        ->add('education', TextareaType::class)
        ->add('bloodGroup', TextType::class)
        ->add('gender', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Add User'))
        ;
    }
}
?>