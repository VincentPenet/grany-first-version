<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Civilite;
use App\Entity\Contacts;
use App\Repository\CiviliteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactFormType extends AbstractType
{
    private CiviliteRepository $civiliteRepository;

    public function __construct(CiviliteRepository $civiliteRepository)
    {
        $this->civiliteRepository = $civiliteRepository;
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
        'data_class' => Contacts::class,
    ]);
}
}
