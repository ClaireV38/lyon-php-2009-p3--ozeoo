<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\Company;
use App\Entity\Offer;
use App\Entity\SkillCategory;
use App\Form\ApplicantType;
use App\Form\SearchApplicantOfferType;
use App\Repository\ApplicantRepository;
use App\Repository\SkillCategoryRepository;
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
 * @Route("/candidat")
 */
class ApplicantController extends AbstractController
{
    /**
     * @Route("/", name="applicant_index", methods={"GET","POST"})
     * @param Request $request
     * @param ApplicantRepository $applicantRepository
     * @param OfferRepository $offerRepository
     * @param SearchOffers $searchOffers
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

            $matchOffersArray = $searchOffers->getSearchedOffersForApplicant(
                $applicant,
                $searchTitle,
                $searchCompany,
                $field
            );
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
     * @Route("/{id}/profil", name="applicant_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Applicant $applicant
     * @return Response
     */
    public function new(Request $request, Applicant $applicant): Response
    {
        if ($this->getUser() != $applicant->getUser()) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(ApplicantType::class, $applicant, [
            'validation_groups' => ['listSkill']
        ]);
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
        $skillCats = [];
        foreach ($applicant->getHardSkills() as $skill) {
            if (!in_array($skill ->getSkillCategory(), $skillCats)) {
                $skillCats[] = $skill->getSkillCategory();
            }
        }

        /* @phpstan-ignore-next-line */
        $user = $this->getUser();

        if ($this->getUser() != $applicant->getUser()) {
            throw new AccessDeniedException();
        }

        return $this->render('applicant/show.html.twig', [
            'applicant' => $applicant,
            'user' => $user,
            'skillCats' => $skillCats
        ]);
    }

    /**
     * @Route ("/{id}/offre", name="applicant_offer", methods={"GET"})
     * @param ApplicantRepository $applicantRepository
     * @param Applicant $applicant
     * @param OfferRepository $offerRepository
     * @return Response
     */
    public function showMatchOffers(
        ApplicantRepository $applicantRepository,
        Applicant $applicant,
        OfferRepository $offerRepository
    ): Response {
        $applicantOffers = $applicant->getOffers();

        /* @phpstan-ignore-next-line */
        $matchOffersArray = $applicantRepository->findMatchingOffersForApplicant($this->getUser()->getApplicant());
        $matchOffers = [];
        foreach ($matchOffersArray as $matchOffer) {
            $matchOffers[] = $offerRepository->findOneBy(['id' => $matchOffer['offer_id']]);
        }

        return $this->render('applicant/offer.html.twig', [
            'applicant' => $applicant,
            'matchOffers' => $matchOffers,
            'applicantOffers' => $applicantOffers,
        ]);
    }

    /**
     * @Route ("/{applicantId}/entreprise/{companyId}/offre/{offerId}",
     *      methods={"GET", "POST"}, name="applicant_offer_detail")
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

        $skillCats = [];
        foreach ($offer->getHardSkills() as $skill) {
            if (!in_array($skill ->getSkillCategory(), $skillCats)) {
                $skillCats[] = $skill->getSkillCategory();
            }
        }

        return $this->render('applicant/offerDetail.html.twig', [
            'applicant' => $applicant,
            'offer' => $offer,
            'company' => $company,
            'matchHardSkills' => $matchHardSkills,
            'matchSoftSkills' => $matchSoftSkills,
            'skillCats' => $skillCats
        ]);
    }

    /**
     * @Route ("/postule/{id}", name="applicant_offer_apply", methods={"GET"})
     * @param Offer $offer
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     * @return RedirectResponse
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
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
                ->from(new Address($this->getParameter('mailer_from'), 'Ozeoo'))
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
