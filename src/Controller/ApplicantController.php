<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\Offer;
use App\Entity\User;
use App\Form\ApplicantType;
use App\Repository\ApplicantRepository;
use App\Repository\OfferRepository;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Route("/applicant")
 */
class ApplicantController extends AbstractController
{
    /**
     * @Route("/", name="applicant_index", methods={"GET"})
     * @param OfferRepository $offerRepository
     * @param SkillRepository $skillRepository
     * @param ApplicantRepository $applicantRepository
     * @return Response
     */
    public function index(OfferRepository $offerRepository, SkillRepository $skillRepository, ApplicantRepository $applicantRepository): Response
    {
//       $allOffers = $offerRepository->findAll();
//       $matchOffers = [];
//       foreach ($allOffers as $offer)
//       {
//           $hardSkillsMatch = $skillRepository->findMatchHardSkills($offer, $this->getUser()->getApplicant());
//           $softSkillsMatch = $skillRepository->findMatchSoftSkills($offer, $this->getUser()->getApplicant());
//           if (count($hardSkillsMatch) >= 5 && count($softSkillsMatch) >= 5)
//           {
//               $matchOffers[] = $offer;
//           }
//       }
        $matchOffers = $applicantRepository->findMatch($this->getUser()->getApplicant());
        var_dump($matchOffers);
        die();
        return $this->render('applicant/index.html.twig');
    }

    /**
     * @Route("/{id}/edit", name="applicant_edit", methods={"GET","POST"})
     */
    public function new(Request $request, Applicant $applicant): Response
    {
        $form = $this->createForm(ApplicantType::class, $applicant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($applicant);
            $entityManager->flush();

            return $this->redirectToRoute('applicant_index');
        }

        return $this->render('applicant/edit.html.twig', [
            'applicant' => $applicant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="applicant_show", methods={"GET"})
     */
    public function show(Applicant $applicant): Response
    {
        return $this->render('applicant/show.html.twig', [
            'applicant' => $applicant,
        ]);
    }

    /**
     * @Route("/{id}", name="applicant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Applicant $applicant): Response
    {
        if ($this->isCsrfTokenValid('delete' . $applicant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($applicant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('applicant_index');
    }

    /**
     * @Route {"/offer/{id}", name="applicant_offer", methods={"GET"})
     * @return Response
     */
    public function showMatch(): Response
    {

    }
}
