<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Messages;
use App\Repository\PreferencesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageFormType extends AbstractType
{
    private PreferencesRepository $preferencesRepository;

    public function __construct(PreferencesRepository $preferencesRepository)
    {
        $this->preferencesRepository = $preferencesRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('objet_message', TextType::class, [
            'label' => 'Objet du message',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'class' => 'form',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut pas être vide',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'L\'objet du message doit être composé d\'au moins {{ limit }} caractères',
                ]),
            ],
        ])
        // ->add('preferences', EntityType::class, [
        //     'label' => false,
        //     'mapped' => false,
        //     'class' => Preferences::class,
        //     'choice_label' => 'préférences',
        //     'choices' => $this->preferencesRepository->findAll(),
        //     'expanded' => true,
        //     'multiple' => true,
        //     // 'data' => $options['data']->getCategorieProduit(),
        //     'constraints' => [
        //         new NotBlank(),
        //     ],
        // ])
        ->add('message', TextareaType::class, [
            'label' => 'Message',
            'required' => true,
            'attr' => [
                'rows' => 10, 'cols' => 10,
                'class' => 'form-control',
                'class' => 'form',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut pas être vide',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Votre message doit être composé d\'au moins {{ limit }} caractères',
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
