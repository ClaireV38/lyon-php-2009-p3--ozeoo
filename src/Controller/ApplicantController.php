<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Form\ApplicantType;
use App\Repository\ApplicantRepository;
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
     */
    public function index(ApplicantRepository $applicantRepository): Response
    {
        return $this->render('applicant/index.html.twig', [
            'applicants' => $applicantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="applicant_new", methods={"GET","POST"})
     */
    public function new(Request $request, ApplicantRepository $applicantRepository): Response
    {
//        $applicant = new Applicant();
//        $applicant->setUser($this->getUser());
        $applicant = $applicantRepository->findOneByUser($this->getUser());
        $form = $this->createForm(ApplicantType::class, $applicant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($applicant);
            $entityManager->flush();

            return $this->redirectToRoute('applicant_index');
        }

        return $this->render('applicant/new.html.twig', [
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
     * @Route("/{id}/edit", name="applicant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Applicant $applicant): Response
    {
        $form = $this->createForm(ApplicantType::class, $applicant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('applicant_index');
        }

        return $this->render('applicant/edit.html.twig', [
            'applicant' => $applicant,
            'form' => $form->createView(),
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
}
