<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        if ($this->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_index');
        } elseif ($this->isGranted('ROLE_APPLICANT')) {
            return $this->redirectToRoute('applicant_index');
        } elseif ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/mentions_legales", name="legalTerms")
     * @return Response
     */
    public function legalTerms(): Response
    {
        return $this->render('home/legalTerms.html.twig');
    }

    /**
     * @Route("/tutoriel", name="tutoriel")
     * @return Response
     */
    public function showTuto(): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();
        /* @phpstan-ignore-next-line */
        $applicant = $this->getUser()->getApplicant();
        return $this->render('home/tutoriel.html.twig', [
            'company' => $company,
            'applicant' => $applicant,
        ]);
    }
}
