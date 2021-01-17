<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>"Nom de l'adresse",
                'attr'=>[
                    'placeholder'=>"ex: Domicile Bureau etc"
                ]
            ])
            ->add('firstname', TextType::class,[
                'label'=>"Prénom du destinataire",
            ])
            ->add('lastname', TextType::class,[
                'label'=>"Nom du destinataire",
            ])
            ->add('compagny', TextType::class,[
                'label'=>"Société (facultatif)",
                'required'=>false
            ])
            ->add('address', TextType::class,[
                'label'=>"Adresse"
            ])
            ->add('postcode',TextType::class,[
                'label'=>'Code postal'
            ])
            ->add('city', TextType::class,[
                'label'=>"Ville"
            ])
            ->add('country',CountryType::class,[
                'label'=>'Pays'
            ])
            ->add('phone', TelType::class,[
                'label'=>"Téléphone"
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Valider',
                'attr'=>[
                    'class'=>'btn btnPrimary btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
