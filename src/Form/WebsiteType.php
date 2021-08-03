<?php

namespace App\Form;

use App\Entity\Website;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class WebsiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', UrlType::class, [
                'label'=> 'Url du site web',
                'attr' => [
                    'placeholder' => 'Entrer un url valide'
                ]
            ])
            ->add('name', TextType::class, [
                'label'=> 'Nom du site',
                'attr' => [
                    'placeholder' => 'Entrer le nom du site'
                ]
            ])
            ->add('submit', SubmitType::class,
            [
                'label'=> 'Sauvegarder le site'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Website::class,
        ]);
    }
}
