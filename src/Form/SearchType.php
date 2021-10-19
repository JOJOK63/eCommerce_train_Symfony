<?php

namespace App\Form;


use App\Classe\Search;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'label' => false,
                //not required if you research juste with options filter
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre recherche ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                //not required if you research juste with text
                'required' => false,
                'class' => Category::class,
                //you can have multiple choice
                'multiple' => true,
                //you have checkbox
                'expanded' => true,

            ])
            ->add('submit' , SubmitType::class, [
                'label' => "Filtrer",
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            //because the information need to pass in the URL
            'method' => 'GET',
            //descativate security .. ???
            'csrf_protection' => false,
        ]);
    }

    // return an array with search class before in the url normally but now she return nothing
    public function getBlockPrefix()
    {
        return '';
    }
}