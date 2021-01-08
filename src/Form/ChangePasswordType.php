<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                "label"=>"E-mail",
                "disabled"=>true
            ])
            ->add('firstname', TextType::class,[
                "label"=>"Prénom",
                "disabled"=>true
            ])
            ->add('lastname', TextType::class,[
                "label"=>"Nom",
                "disabled"=>true
            ])
            ->add('old_password',PasswordType::class,[
                "label"=>"Mot de passe actuel",
                "mapped"=>false,
                "attr"=>[
                    "placeholder"=>"Saisissez votre mot de passe actuel"]
            ])
            ->add('new_password', RepeatedType::class,[
                'type'=>PasswordType::class,
                'invalid_message'=>"Le message et la confirmation doivent être identiques",
                "required"=>true,
                "mapped"=>false,
                'first_options'=>[
                    "label"=>"Nouveau Mot de passe",
                    "attr"=>[
                        "placeholder"=>"Veuillez saisir votre nouveau mot de passe en respectant les consignes"
                    ]
                ],
                'second_options'=>[
                    "label"=>"Confirmer votre nouveau mot de passe",
                    "attr"=>[
                        "placeholder"=>"Veuillez confirmer votre nouveau mot de passe"
                    ]
                ]
            ])
            ->add('submit', SubmitType::class,[
                "label"=>"Valider",
                "attr"=> [
                    "class"=>'btn btnPrimary col-6 text-center'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
