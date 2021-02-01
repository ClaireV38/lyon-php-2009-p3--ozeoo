<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\Company;
use App\Entity\Offer;
use App\Form\ApplicantType;
use App\Form\SearchApplicantOfferType;
use App\Repository\ApplicantRepository;
use App\Services\SearchOffers;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\User;
use App\Repository\OfferRepository;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/applicant", name="applicant_")
 */
class ApplicantController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET","POST"})
     * @param Request $request
     * @param ApplicantRepository $applicantRepository
     * @return Response
     */
    public function index(
        Request $request,
        ApplicantRepository $applicantRepository,
        OfferRepository $offerRepository,
        SearchOffers $searchOffers
    ): Response {
        /* @phpstan-ignore-next-line */
        $applicant = $this->getUser()->getApplicant();


        if (null == ($applicant->getFirstname())) {
             return $this->redirectToRoute('applicant_edit', [
                'id' => $applicant->getId()
             ]);
        }

        $applicantOffers = $applicant->getOffers();

        $searchForm = $this->createForm(SearchApplicantOfferType::class);
        $searchForm->handleRequest($request);

        $noResult = false;
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $searchTitle = $searchForm->getData()['searchTitle'];
            $searchCompany = $searchForm->getData()['searchCompany'];
            if (empty($searchTitle)) {
                $searchTitle = "";
            }
            if (empty($searchCompany)) {
                $searchCompany = "";
            }
            $field = $searchForm->getData()['sort'];

            $matchOffersArray = $searchOffers->getSearchedOffers($applicant, $searchTitle, $searchCompany, $field);
            if (empty($matchOffersArray)) {
                $matchOffersArray = $applicantRepository->findMatchingOffersForApplicant(
                /* @phpstan-ignore-next-line */
                    $this->getUser()->getApplicant()
                );
                $noResult = true;
            }
        } else {
            /* @phpstan-ignore-next-line */
            $matchOffersArray = $applicantRepository->findMatchingOffersForApplicant($this->getUser()->getApplicant());
        }

        $matchOffers = [];
        foreach ($matchOffersArray as $matchOffer) {
            $matchOffers[] = $offerRepository->findOneBy(['id' => $matchOffer['offer_id']]);
        }

        return $this->render('applicant/index.html.twig', [
            'applicant' => $applicant,
            'matchOffers' => $matchOffers,
            'applicantOffers' => $applicantOffers,
            'searchForm' => $searchForm->createView(),
            'noResult' => $noResult
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Applicant $applicant
     * @return Response
     */
    public function new(Request $request, Applicant $applicant): Response
    {
        /* @phpstan-ignore-next-line */
        $user = $this->getUser();
        if ($this->getUser() != $applicant->getUser()) {
            throw new AccessDeniedException();
        }

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
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Applicant $applicant
     * @return Response
     */
    public function show(Applicant $applicant): Response
    {
        /* @phpstan-ignore-next-line */
        $user = $this->getUser();

        if ($this->getUser() != $applicant->getUser()) {
            throw new AccessDeniedException();
        }

        return $this->render('applicant/show.html.twig', [
            'applicant' => $applicant,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Applicant $applicant
     * @return Response
     */
    public function delete(Request $request, Applicant $applicant): Response
    {
        if ($this->getUser() != $applicant->getUser()) {
            throw new AccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $applicant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($applicant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('applicant_index');
    }

    /**
     * @Route ("/{id}/offer", name="offer", methods={"GET"})
     * @param ApplicantRepository $applicantRepository
     * @param Applicant $applicant
     * @return Response
     */
    public function showMatchOffers(ApplicantRepository $applicantRepository, Applicant $applicant): Response
    {
        if ($this->getUser() != $applicant->getUser()) {
            throw new AccessDeniedException();
        }

        $offers = $applicant->getOffers();
        $offerId = [];
        foreach ($offers as $offer) {
            $offerId[] = $offer->getId();
        }
        /* @phpstan-ignore-next-line */
        $matchOffers = $applicantRepository->findMatchingOffersForApplicant($this->getUser()->getApplicant());
        $offersInArray = [];
        foreach ($matchOffers as $matchOffer) {
            if (in_array($matchOffer['offer_id'], $offerId)) {
                $offersInArray[] = $matchOffer;
            }
        }
        return $this->render('applicant/offer.html.twig', [
            'applicant' => $applicant,
            'matchOffers' => $matchOffers,
            'offers' => $offersInArray
        ]);
    }

    /**
     * @Route ("/{applicantId}/company/{companyId}/offer/{offerId}", methods={"GET", "POST"}, name="offer_detail")
     * @ParamConverter("applicant", class="App\Entity\Applicant", options={"mapping": {"applicantId": "id"}})
     * @ParamConverter("offer", class="App\Entity\Offer", options={"mapping": {"offerId": "id"}})
     * @ParamConverter("company", class="App\Entity\Company", options={"mapping": {"companyId": "id"}})
     * @param ApplicantRepository $applicantRepository
     * @param Applicant $applicant
     * @param Offer $offer
     * @param Company $company
     * @param SkillRepository $skillRepository
     * @return Response
     */
    public function showOfferDetail(
        ApplicantRepository $applicantRepository,
        Applicant $applicant,
        Offer $offer,
        Company $company,
        SkillRepository $skillRepository
    ): Response {
        /* @phpstan-ignore-next-line */
        $user = $this->getUser();

        $matchHardSkills = $skillRepository->findMatchHardSkills($offer, $applicant);
        $matchSoftSkills = $skillRepository->findMatchSoftSkills($offer, $applicant);

        /* @phpstan-ignore-next-line */
        $matchOffers = $applicantRepository->findMatchingOffersForApplicant($this->getUser()->getApplicant());
        $matchOffersId = [];
        foreach ($matchOffers as $matchOffer) {
            $matchOffersId[] = $matchOffer['offer_id'];
        }
        if (
            $this->getUser() != $applicant->getUser()
            || $offer->getCompany() != $company
            || !(in_array($offer->getId(), $matchOffersId))
        ) {
            throw new AccessDeniedException();
        }

        return $this->render('applicant/offerDetail.html.twig', [
            'applicant' => $applicant,
            'offer' => $offer,
            'company' => $company,
            'user' => $user,
            'matchHardSkills' => $matchHardSkills,
            'matchSoftSkills' => $matchSoftSkills,
        ]);
    }

    /**
     * @Route ("/Apply/{id}", name="offer_apply", methods={"GET"})
     * @param Company $company
     * @param Offer $offer
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     * @return RedirectResponse
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function apply(
        Company $company,
        Offer $offer,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        /* @phpstan-ignore-next-line */
        $user = $this->getUser();

        /* @phpstan-ignore-next-line */
        $applicant = $this->getUser()->getApplicant();
        $applicant->addOffer($offer);
        $entityManager->flush();
        $this->addFlash('success', 'Félicitations, tu viens de postuler à l\'offre !');

        /* @phpstan-ignore-next-line */
        $mailTo = $offer->getCompany()->getUser()->getEmail();
        /* @phpstan-ignore-next-line */
        if ($offer->getCompany()->getContactEmail()) {
            /* @phpstan-ignore-next-line */
            $mailTo = $offer->getCompany()->getContactEmail();
        }
        if ($mailTo !== null) {
            $email = (new TemplatedEmail())
                ->from(new Address($this->getParameter('mailer_from'), 'Ozéoo'))
                ->to($mailTo)
                    ->subject('Un candidat a postulé à l\'une de vos offres')
                    ->html($this->renderView('applicant/applicationOfferEmail.html.twig', [
                        'applicant' => $applicant,
                        'offer' => $offer
                    ]));
            $mailer->send($email);
        }

        return $this->redirectToRoute('applicant_index', [
            'user' => $user,
        ]);
    }
}
