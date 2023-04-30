<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contacts;
use App\Entity\Messages;
use App\Form\ContactFormType;
use App\Form\MessageFormType;
use App\Repository\ContactsRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class MessageController extends AbstractController
{
    /**
     * Page "Envoi d'un message"
     *
     * @param Contacts               $contact
     * @param ContactsRepository     $contactsRepository
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     *
     * @return Response
     */
    #[Route('/message', name: 'app_message')]
    public function index(ContactsRepository $contactsRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        
        // Formulaire de création d'un nouveau contact
        $contact = new Contacts();

        $contactForm = $this->createForm(contactFormType::class, $contact);
        $contactForm->handleRequest($request);

        // Requête pour contrôler l'existence ou non de l'Email dans la bdd
        $emailQueryForm = $this->createFormBuilder()
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

        $emailQueryForm->handleRequest($request);

        if ($emailQueryForm->isSubmitted() && $emailQueryForm->isValid()) {
            $contactEmail = $emailQueryForm->get('emailQuery')->getData();
            $resultEmail = $contactsRepository->findByEmail($contactEmail);

            if (isset($resultEmail)) {
                return $this->render('message/send_message.html.twig', [
                    'breadcrumb' => 'Message > Envoyer un message',
                    'contact' => $contactEmail,
                    'emailQueryForm' => $emailQueryForm->createView(),
                ]);
            } else {
                // Message Flash
                $session = $request->getSession();
                $session->getFlashBag()->add('avertissement', 'Attention : Nous n\'avons pas l\'honneur de vous connaître. Êtes-vous sur d\'avoir saisi la bonne adresse mail. Sinon veuillez cocher la case "Je vous envoie un message pour la première fois"');

                return $this->render('message/index.html.twig', [
                    'breadcrumb' => ' Message',
                    'emailQueryForm' => $emailQueryForm->createView(),
                    'contactForm' => $contactForm->createView(),
                ]);
            }
        }

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // Vérification de la réponse Recaptcha de l'utilisateur
            if (empty($_POST['g-recaptcha-response'])) {
                $this->addFlash('danger', 'Vous n\'avez pas coché la case "je ne suis pas un robot".');
                return $this->render('message/index.html.twig', [
                    'contactForm' => $contactForm->createView(),
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
                    return $this->redirectToRoute('app_contact_form');
                } else {
                    $data = json_decode($responseRecaptcha);

                    if ($data->success) {
                        // Traitement du formulaire

                        // Vérification en bdd de la non existence du mail
                        $contactEmail = $contactForm->get('mail')->getData();
                        $resultEmail = $contactsRepository->findByEmail($contactEmail);
            
                        if (isset($resultEmail)) {
                            // Message Flash
                            $session = $request->getSession();
                            $session->getFlashBag()->add('avertissement', 'Attention : Nous avons l\'honneur de vous connaître. Veuillez cocher la case "Vous me connaissez. J\'ai déjà envoyé un message"');
            
                            return $this->render('message/index.html.twig', [
                                'breadcrumb' => ' Message',
                                'emailQueryForm' => $emailQueryForm->createView(),
                                'contactForm' => $contactForm->createView(),
                            ]);
                        } else {
                        }
            
                        $contact->setCivilite($contactForm->get('gender')->getData());

                        $contact->setNom($contactForm->get('lastName')->getData());

                        $contact->setPrenom($contactForm->get('firstName')->getData());

                        $contact->setMail($contactForm->get('mail')->getData());

                        $contact->setCreeLe(new \DateTimeImmutable());

                        $contact->setRgpdValidation($contactForm->get('rgpd_validation')->getData());

                        $entityManager->persist($contact);

                        $entityManager->flush();

                        return $this->render('message/send_message.html.twig', [
                        ]);
                    }
                }
            }
        }

        return $this->render('message/index.html.twig', [
            'breadcrumb' => ' Message',
            'emailQueryForm' => $emailQueryForm->createView(),
            'contactForm' => $contactForm->createView(),
        ]);
    }

    /**
     * Page "Formulaire d'envoi d'un message"
     *
     * @param Contacts               $contact
     * @param ContactsRepository     $contactsRepository
     * @param EntityManagerInterface $entityManager
     * @param Messages               $message
     * @param Request                $request
     *
     * @return Response
     */
    #[Route('/message/form', name: 'app_message_form')]
    public function sendMessage(EntityManagerInterface $entityManager, Request $request): Response
    {
        $message = new Messages();

        $messageForm = $this->createForm(MessageFormType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            // Vérification de la réponse Recaptcha de l'utilisateur
            if (empty($_POST['g-recaptcha-response'])) {
                $this->addFlash('danger', 'Vous n\'avez pas coché la case "je ne suis pas un robot".');
                return $this->render('message/send_message.html.twig', [
                    'messageForm' => $messageForm->createView(),
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
                    return $this->redirectToRoute('app_message_form');
                } else {
                    $data = json_decode($responseRecaptcha);

                    if ($data->success) {
                        // Traitement du formulaire

                        $message->setObjetMessage($messageForm->get('objet_message')->getData());
                        
                        $message->setmessage($messageForm->get('message')->getData());

                        $message->setCreeLe(new DateTimeImmutable());

                        // $message->setCategorieProduit($messageForm->get('preferences')->getData());

                        $entityManager->persist($message);

                        $entityManager->flush();

                        $this->addFlash('success', 'Votre message a bien été envoyé.');

                        return $this->render('home/index.html.twig', [
                        ]);
                    }
                }
            }
        }

        return $this->render('message/send_message.html.twig', [
            'messageForm' => $messageForm->createView(),
            'breadcrumb' => 'Envoyer un message',
        ]);
    }
}
