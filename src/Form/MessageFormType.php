<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Civilite;
use App\Entity\Messages;
use App\Repository\CiviliteRepository;
use App\Repository\PreferencesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class MessageFormType extends AbstractType
{
    private CiviliteRepository $civiliteRepository;
    private PreferencesRepository $preferencesRepository;

    public function __construct(CiviliteRepository $civiliteRepository, PreferencesRepository $preferencesRepository)
    {
        $this->civiliteRepository = $civiliteRepository;
        $this->preferencesRepository = $preferencesRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', EntityType::class, [
                'label' => 'Civilité',
                'placeholder' => 'Veuillez choisir un titre',
                'mapped' => false,
                'class' => Civilite::class,
                'choice_label' => 'titre',
                'choices' => $this->civiliteRepository->findAll(),
                'multiple' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Choix d\'un titre obligatoire',
                ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'class' => 'form',
                    ],
            ])
        ->add('lastName', TextType::class, [
            'label' => 'Nom',
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
                    'minMessage' => 'Le nom doit être composé d\'au moins {{ limit }} caractères',
                ]),
            ],
        ])
        ->add('firstName', TextType::class, [
            'label' => 'Prénom',
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
                    'minMessage' => 'Le prénom doit être composé d\'au moins {{ limit }} caractères',
                ]),
            ],
        ])
        ->add('mail', EmailType::class, [
            'label' => 'Adresse mail',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'autocomplete' => 'email',
                'class' => 'form-control',
                'class' => 'form',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer votre adresse mail',
                ]),
                new Regex('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', 'Adresse mail non valide'),
            ],
        ])
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
        ->add('rgpd_validation', CheckboxType::class, [
            'label' => ' J\'ai lu et accepte la politique de confidentialité',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'class' => 'form',
                'class' => 'ps-2',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Vous devez accepter la politique de confidentialité',
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
