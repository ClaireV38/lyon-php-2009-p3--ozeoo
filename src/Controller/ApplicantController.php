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

/**
 * @Route("/applicant")
 */
class ApplicantController extends AbstractController
{
    /**
     * @Route("/", name="applicant_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
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
        /* @phpstan-ignore-next-line */
        $matchOffers = $applicantRepository->findMatchingOffersForApplicant($this->getUser()->getApplicant());
        return $this->render('applicant/offer.html.twig', [
            'applicant' => $applicant,
            'matchOffers' => $matchOffers
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
    public function showOfferDetail(Applicant $applicant, Offer $offer, Company $company): Response
    {
        return $this->render('applicant/offerDetail.html.twig', [
           'applicant' => $applicant,
           'offer' => $offer,
           'company' => $company,
        ]);
    }

    /**
     * @Route ("/Apply/{id}", name="applicant_offer_apply", methods={"GET"})
     * @param Offer $offer
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function apply(
        Offer $offer,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {

        /* @phpstan-ignore-next-line */
        $applicant = $this->getUser()->getApplicant();
        $applicant->addOffer($offer);
        $entityManager->flush();

        /* @phpstan-ignore-next-line */
        $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to($offer->getCompany()->getUser()->getEmail())
            ->subject('Un candidat a postulé à une de vos offres')
            ->html($this->renderView('applicant/applicationOfferEmail.html.twig', [
                'applicant' => $applicant,
                'offer' => $offer
            ]));
        $mailer->send($email);

        return $this->redirectToRoute('applicant_index');
    }
}
