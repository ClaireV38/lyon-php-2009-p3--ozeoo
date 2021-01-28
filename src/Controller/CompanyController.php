<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/entreprise")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/index", name="company_index", methods={"GET"})
     * @param OfferRepository $offerRepository
     * @return Response
     */
    public function index(OfferRepository $offerRepository): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        $offers = $offerRepository->findBy(
            ['company' => $company],
            ['id' => 'DESC']
        );
        $nbMatches = [];
        foreach ($offers as $offer) {
            $matchApplicants = $offerRepository->findMatchingApplicantsForOffer($offer);
            $nbMatches[$offer->getId()] = count($matchApplicants);
        }
        return $this->render('company/index.html.twig', [
            'company' => $company,
            'offers' => $offers,
            'nbMatches' => $nbMatches
        ]);
    }

    /**
     * @Route("/{id}/modifier_profil", name="company_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Company $company
     * @return Response
     */
    public function edit(Request $request, Company $company): Response
    {
        if ($this->getUser() != $company->getUser()) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(CompanyType::class, $company, [
            'validation_groups' => ['company'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('company_index');
        }

        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="company_show", methods={"GET"})
     * @param Company $company
     * @return Response
     */
    public function show(Company $company): Response
    {
        if ($this->getUser() != $company->getUser()) {
            throw new AccessDeniedException();
        }

        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }
}
