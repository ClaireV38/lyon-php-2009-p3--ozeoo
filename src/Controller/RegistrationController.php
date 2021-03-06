<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Security\EmailVerifier;
use App\Entity\Applicant;
use App\Entity\Company;
use App\Entity\User;
use App\Form\ApplicantRegisterType;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    /**
     * @var EmailVerifier
     */
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/inscription/entreprise", name="app_register_company")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @param MailerInterface $mailer
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function registerCompany(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        MailerInterface $mailer
    ): ?Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_COMPANY']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            $email = (new TemplatedEmail());
            $email->from(new Address($this->getParameter('mailer_from'), 'Ozeoo'));
            $email->to($user->getEmail());
            $email->subject('Ozeoo : Demande d\'inscription en cours');
            $email->html($this->renderView('company/newCompanyEmail.html.twig'));
            $mailer->send($email);

            $this->addFlash('success', 'Votre inscription a bien été prise en compte,
            votre compte sera validé par notre administrateur sous 24 à 48H.');
            return $this->redirectToRoute('home');
        }

        return $this->render('registration/registerCompany.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription/candidat", name="app_register_applicant")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @return Response
     */
    public function registerApplicant(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator
    ): ?Response {
        $user = new User();
        $applicant = new Applicant();
        $user->setApplicant($applicant);
        $form = $this->createForm(ApplicantRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_APPLICANT']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address($this->getParameter('mailer_from'), 'Ozéoo'))
                    ->to($user->getEmail())
                    ->subject('Ozeoo : Merci de confirmer votre adresse email')
                    ->htmlTemplate('applicant/newApplicantEmail.html.twig')
            );

            $this->addFlash('success', 'Votre inscription a bien été prise en compte,
            merci de confirmer votre adresse email.');
            return $this->redirectToRoute('home');
        }

        return $this->render('registration/registerApplicant.html.twig', [
            'ApplicantRegister' => $form->createView(),
        ]);
    }

    /**
     * @Route("/email", name="app_verify_email")
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');
        // Verify the user id exists and is not null
        if (null === $id) {
            return $this->redirectToRoute('home');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $user = $userRepository->find($id);
            // Ensure the user exists in persistence
            if (null === $user) {
                return $this->redirectToRoute('home');
            }
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('home');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre adresse email a bien été vérifiée.');

        return $this->redirectToRoute('home');
    }
}
