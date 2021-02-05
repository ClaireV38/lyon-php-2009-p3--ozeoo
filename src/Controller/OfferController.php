<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\Company;
use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use App\Repository\SkillRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/offre")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/nouvelle_offre", name="offer_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        $offer = new Offer();
        /* @phpstan-ignore-next-line */
        $offer->setCompany($this->getUser()->getCompany());
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('company_index');
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
            'company' => $company
        ]);
    }

    /**
     * @Route("/{id}", name="offer_show", methods={"GET"})
     * @param Offer $offer
     * @return Response
     */
    public function show(Offer $offer): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        /* @phpstan-ignore-next-line */
        if ($this->getUser() != $offer->getCompany()->getUser()) {
            throw new AccessDeniedException();
        }

        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
            'company' => $company
        ]);
    }

    /**
     * @Route("/{id}/modifier_annonce", name="offer_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Offer $offer
     * @return Response
     */
    public function edit(Request $request, Offer $offer): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        /* @phpstan-ignore-next-line */
        if ($this->getUser() != $offer->getCompany()->getUser()) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('company_index');
        }

        return $this->render('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
            'company' => $company
        ]);
    }

    /**
     * @Route("/{id}", name="offer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offer $offer): Response
    {
        /* @phpstan-ignore-next-line */
        if ($this->getUser() != $offer->getCompany()->getUser()) {
            throw new AccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('company_index');
    }

    /**
     * @Route("/{id}/candidats", name="offer_applicants", methods={"GET"})
     * @param Offer $offer
     * @param OfferRepository $offerRepository
     * @return Response
     */
    public function showApplicants(Offer $offer, OfferRepository $offerRepository): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        /* @phpstan-ignore-next-line */
        if ($this->getUser() != $offer->getCompany()->getUser()) {
            throw new AccessDeniedException();
        }
        $applicants = $offer->getApplicants();
        $applicantsID = [];
        foreach ($applicants as $applicant) {
            $applicantsID[] = $applicant->getId();
        }
        $matchApplicants = $offerRepository->findMatchingApplicantsForOffer($offer);
        $applicantsInArray = [];
        foreach ($matchApplicants as $matchApplicant) {
            if (in_array($matchApplicant['applicant_id'], $applicantsID)) {
                $applicantsInArray[] = $matchApplicant;
            }
        }

        return $this->render('offer/applicants.html.twig', [
            'offer' => $offer,
            'applicants' => $applicantsInArray,
            'company' => $company
        ]);
    }

    /**
     * @Route("/{offerId}/candidat/{applicantId}", name="offer_applicant_show", methods={"GET"})
     * @ParamConverter("offer", class="App\Entity\Offer", options={"mapping": {"offerId": "id"}})
     * @ParamConverter("applicant", class="App\Entity\Applicant", options={"mapping": {"applicantId": "id"}})
     * @param Offer $offer
     * @param Applicant $applicant
     * @param SkillRepository $skillRepository
     * @return Response
     */
    public function applicantShow(Offer $offer, Applicant $applicant, SkillRepository $skillRepository): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        /* @phpstan-ignore-next-line */
        if ($this->getUser() != $offer->getCompany()->getUser() || !($offer->getApplicants()->contains($applicant))) {
            throw new AccessDeniedException();
        }

        $matchHardSkills = $skillRepository->findMatchHardSkills($offer, $applicant);
        $matchSoftSkills = $skillRepository->findMatchSoftSkills($offer, $applicant);

        $skillCats = [];
        foreach ($offer->getHardSkills() as $skill) {
            if (!in_array($skill ->getSkillCategory(), $skillCats)) {
                $skillCats[] = $skill->getSkillCategory();
            }
        }

        return $this->render('offer/applicant_show.html.twig', [
            'applicant' => $applicant,
            'matchHardSkills' => $matchHardSkills,
            'matchSoftSkills' => $matchSoftSkills,
            'offer' => $offer,
            'company' => $company,
            'skillCats' => $skillCats,
        ]);
    }
}
