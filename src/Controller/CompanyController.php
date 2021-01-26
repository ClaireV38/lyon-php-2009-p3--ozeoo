<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Form\SearchCompanyOfferType;
use App\Repository\CompanyRepository;
use App\Repository\OfferRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/company", name="company_")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/index", name="index", methods={"GET"})
     * @param Request $request
     * @param OfferRepository $offerRepository
     * @return Response
     */
    public function index(Request $request, OfferRepository $offerRepository): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        $offers = $offerRepository->findBy(
            ['company' => $company],
            ['id' => 'DESC']
        );

        $form = $this->createForm(SearchCompanyOfferType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $offers = $offerRepository->findBy(['title' => $search]);
        } else {
            $offers = $offerRepository->findAll();
        }

        $nbMatches = [];
        foreach ($offers as $offer) {
            $matchApplicants = $offerRepository->findMatchingApplicantsForOffer($offer);
            $nbMatches[$offer->getId()] = count($matchApplicants);
        }
        return $this->render('company/index.html.twig', [
            'company' => $company,
            'offers' => $offers,
            'nbMatches' => $nbMatches,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Company $company): Response
    {

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
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Company $company
     * @return Response
     */
    public function show(Company $company): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Company $company
     * @return Response
     */
    public function delete(Request $request, Company $company): Response
    {
        if ($this->isCsrfTokenValid('delete' . $company->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('company_index');
    }

    /**
     * @Route("/sort/{field}", name="offerSort", methods={"GET"})
     * @param string $field
     * @param OfferRepository $offerRepository
     * @return Response
     * @ParamConverter("field", options={"mapping": {"field": "field"}})
     */
    public function sort(string $field, OfferRepository $offerRepository): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        switch ($field) {
            case 'endDate':
                $offers = $offerRepository->findBy(
                    ['company' => $company],
                    ['endDate' => 'ASC']
                );
                break;
            case 'creationDate':
                $offers = $offerRepository->findBy(
                    ['company' => $company],
                    ['creationDate' => 'ASC']
                );
                break;
            case 'startDate':
                $offers = $offerRepository->findBy(
                    ['company' => $company],
                    ['startDate' => 'ASC']
                );
                break;
            case 'title':
                $offers = $offerRepository->findBy(
                    ['company' => $company],
                    ['title' => 'ASC']
                );
        }

        $nbMatches = [];
        if (!empty($offers)) {
            foreach ($offers as $offer) {
                $matchApplicants = $offerRepository->findMatchingApplicantsForOffer($offer);
                $nbMatches[$offer->getId()] = count($matchApplicants);
            }
        } else {
            $offers = [];
        }
        return $this->render('company/index.html.twig', [
            'company' => $company,
            'offers' => $offers,
            'nbMatches' => $nbMatches
        ]);
    }
}
