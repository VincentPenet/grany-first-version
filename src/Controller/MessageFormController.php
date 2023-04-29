<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contacts;
use App\Entity\Messages;
use App\Form\ContactFormType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Formulaire d'envoi d'un message.
 *
 * @param Request                $request
 * @param Contacts               $contact
 * @param Messages               $messages
 * @param EntityManagerInterface $entityManager
 *
 * @return Response
 */
class MessageFormController extends AbstractController
{
    #[Route('/message/form', name: 'app_message_form')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Requête pour contrôler l'existence ou non de l'Email dans la bdd
        $myEmailForm = $this->createFormBuilder()
        ->add('emailQuery', EmailType::class, [
            'label' => false,
            'required' => true,
            'attr' => [
                'placeholder' => 'Votre adresse mail',
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
    ->getForm();

        $myEmailForm->handleRequest($request);

        // $email = $_POST['myEmail'];
        // dd($email);
        // $resultEmail = $this->searchEmail($email);
        // if (isset($resultEmail['result'])) {
        //     $this->addFlash('danger', "Ce numéro de SIRET n'existe pas");

        //     return $this->render('entites/create.html.twig', [
        //         'entiteForm' => $form->createView(),
        //     ]);
        // }

        $contact = new Contacts();

        $contactForm = $this->createForm(contactFormType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // Vérification de la réponse Recaptcha de l'utilisateur
            if (empty($_POST['g-recaptcha-response'])) {
                $this->addFlash('danger', 'Vous n\'avez pas coché la case "je ne suis pas un robot".');
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                ]);
            } else {
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $this->getParameter('recaptcha_secret_key') . '&response=' . $_POST['g-recaptcha-response'];

                if (function_exists('curl_version')) {
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    $responseRecaptcha = curl_exec($curl);
                } else {
                    $responseRecaptcha = file_get_contents($url);
                }

                if (empty($responseRecaptcha) || is_null($responseRecaptcha)) {
                    $this->addFlash('danger', 'Captcha non valide.');
                    return $this->redirectToRoute('app_demande_acces');
                } else {
                    $data = json_decode($responseRecaptcha);

                    if ($data->success) {
                        // Traitement du formulaire

                        // TODO : Faire vérification en bdd de l'existence du mail

                        $contact->setCivilite($contactForm->get('gender')->getData());

                        $contact->setNom($contactForm->get('lastName')->getData());

                        $contact->setPrenom($contactForm->get('firstName')->getData());

                        $contact->setMail($contactForm->get('mail')->getData());

                        $contact->setCreeLe(new \DateTimeImmutable());

                        $contact->setRgpdValidation($contactForm->get('rgpd_validation')->getData());

                        // $contact->setObjetMessage($contactForm->get('objet_message')->getData());

                        // $contact->getMessages()->setMessage($contactForm->get('message')->getData());

                        // $contact->getMessages()->setContact($contactForm->get('contact')->getData());

                        // $contact->getMessages()->setCreeLe(new DateTimeImmutable());

                        // $contact->getContact()->setContact($contactForm->get('lastName')->getData());

                        // $contact->getContact()->setCategorieProduit($contactForm->get('preferences')->getData());

                        // $contact->getContact()->setCreeLe(new DateTimeImmutable());

                        $entityManager->persist($contact);

                        $entityManager->flush();

                        $this->addFlash('success', 'Votre message a bien été envoyé.');

                        return $this->render('home/index.html.twig', [
                        ]);
                    }
                }
            }
        }

        return $this->render('message/index.html.twig', [
            'breadcrumb' => 'Envoyer un message',
            'myEmailForm' => $myEmailForm->createView(),
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
