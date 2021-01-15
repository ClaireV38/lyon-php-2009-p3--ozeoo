<?php

namespace App\Controller;

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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register/company", name="app_register_company")
     * @return Response
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
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($user->getEmail())
                ->subject('Prise en compte de votre inscription')
                ->html($this->renderView('company/newCompanyEmail.html.twig'));
                $mailer->send($email);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/registerCompany.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/applicant", name="app_register_applicant")
     * @return Response
     */
    public function registerApplicant(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        MailerInterface $mailer
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
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($user->getEmail())
                ->subject('Confirmation de création de compte')
                ->html($this->renderView('applicant/newApplicantEmail.html.twig'));
            $mailer->send($email);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/registerApplicant.html.twig', [
            'ApplicantRegister' => $form->createView(),
        ]);
    }
}
