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
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
                "label"=>"Prénom",
                "constraints"=>new Length([
                    "min"=>1,
                    "max"=>50,
                ])
            ])
            ->add('lastname', TextType::class,[
                "label"=>"Nom",
                "constraints"=>new Length([
                    "min"=>1,
                    "max"=>50,
                ])
            ])
            ->add('email', EmailType::class,[
                "label"=>"E-mail",
                "attr"=>[
                    "placeholder"=>"Entrez une adresse valide"
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type'=>PasswordType::class,
                'invalid_message'=>"Le message et la confirmation doivent être identiques",
                "required"=>true,
                'first_options'=>[
                    "label"=>"Mot de passe",
                    "attr"=>[
                        "placeholder"=>"Veuillez saisir votre mot de passe en respectant les consignes"
                    ]
                ],
                'second_options'=>[
                    "label"=>"Confirmer votre mot de passe",
                    "attr"=>[
                        "placeholder"=>"Veuillez confirmer votre mot de passe"
                    ]
                ]
            ])
            ->add('submit', SubmitType::class,[
                "label"=>"Valider",
                "attr"=> [
                    "class"=>'btn btnPrimary'
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
