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
        }
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/mention_legal", name="legalTerms")
     * @return Response
     */
    public function legalTerms(): Response
    {
        return $this->render('home/legalTerms.html.twig');
    }
}
