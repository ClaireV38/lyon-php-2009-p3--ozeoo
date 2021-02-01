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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/entreprise")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/index", name="company_index", methods={"GET","POST"})
     * @param Request $request
     * @param OfferRepository $offerRepository
     * @return Response
     */
    public function index(Request $request, OfferRepository $offerRepository): Response
    {
        /* @phpstan-ignore-next-line */
        $company = $this->getUser()->getCompany();

        $form = $this->createForm(SearchCompanyOfferType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            if (empty($search)) {
                $search = "";
            }
            $field = $form->getData()['sort'];
            switch ($field) {
                case 'startDate':
                    $offers = $offerRepository->findLikeTitleOrderByStartDate($search, $company);
                    break;
                case 'creationDate':
                    $offers = $offerRepository->findLikeTitleOrderByCreationDate($search, $company);
                    break;
                case 'endDate':
                    $offers = $offerRepository->findLikeTitleOrderByEndDate($search, $company);
                    break;
                case 'title':
                    $offers = $offerRepository->findLikeTitleOrderByTitle($search, $company);
                    break;
                default:
                    $offers = $offerRepository->findLikeTitleOrderById($search, $company);
            }
        } else {
            $offers = $offerRepository->findBy(
                ['company' => $company],
                ['id' => 'DESC']
            );
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
