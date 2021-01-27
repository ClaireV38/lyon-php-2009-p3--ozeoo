<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\Company;
use App\Entity\Offer;
use App\Form\ApplicantType;
use App\Repository\ApplicantRepository;
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
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/applicant")
 */
class ApplicantController extends AbstractController
{
    /**
     * @Route("/", name="applicant_index", methods={"GET","POST"})
     * @param Request $request
     * @param ApplicantRepository $applicantRepository
     * @return Response
     */
    public function index(Request $request, ApplicantRepository $applicantRepository): Response
    {
        /* @phpstan-ignore-next-line */
        $applicant = $this->getUser()->getApplicant();

        $form = $this->createForm(ApplicantType::class, $applicant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($applicant);
            $entityManager->flush();

            return $this->redirectToRoute('applicant_index');
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


        return $this->render('applicant/index.html.twig', [
            'applicant' => $applicant,
            'form' => $form->createView(),
            'matchOffers' => $matchOffers,
            'offers' => $offersInArray
        ]);

        return $this->render('applicant/index.html.twig');
    }

    /**
     * @Route("/{id}/edit", name="applicant_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Applicant $applicant
     * @return Response
     */
    public function new(Request $request, Applicant $applicant): Response
    {
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
        ]);
    }

    /**
     * @Route("/{id}", name="applicant_show", methods={"GET"})
     * @param Applicant $applicant
     * @return Response
     */
    public function show(Applicant $applicant): Response
    {
        if ($this->getUser() != $applicant->getUser()) {
            throw new AccessDeniedException();
        }

        return $this->render('applicant/show.html.twig', [
            'applicant' => $applicant,
        ]);
    }

    /**
     * @Route("/{id}", name="applicant_delete", methods={"DELETE"})
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
     * @Route ("/{id}/offer", name="applicant_offer", methods={"GET"})
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
     * @param Applicant $applicant
     * @param Offer $offer
     * @param Company $company
     * @return Response
     */
    public function showOfferDetail(
        ApplicantRepository $applicantRepository,
        Applicant $applicant,
        Offer $offer,
        Company $company
    ): Response {
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
        ]);
    }

    /**
     * @Route ("/Apply/{id}", name="applicant_offer_apply", methods={"GET"})
     * @param Offer $offer
     * @param Company $company
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function apply(
        Company $company,
        Offer $offer,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {

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
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($mailTo)
                    ->subject('Un candidat a postulé à l\'une de vos offres')
                    ->html($this->renderView('applicant/applicationOfferEmail.html.twig', [
                        'applicant' => $applicant,
                        'offer' => $offer
                    ]));
            $mailer->send($email);
        }

        return $this->redirectToRoute('applicant_index');
    }
}
