<?php

namespace App\Controller\Admin;

use App\Entity\Applicant;
use App\Entity\Company;
use App\Entity\Skill;
use App\Entity\SkillCategory;
use App\Entity\User;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApplicantRepository;
use App\Repository\OfferRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractDashboardController
{

    protected UserRepository $userRepository;
    protected CompanyRepository $companyRepository;
    protected ApplicantRepository $applicantRepository;
    protected OfferRepository $offerRepository;

    /**
     *
     * @param UserRepository $userRepository
     * @param CompanyRepository $companyRepository
     * @param ApplicantRepository $applicantRepository
     * @param OfferRepository $offerRepository
     */
    public function __construct(
        UserRepository $userRepository,
        CompanyRepository $companyRepository,
        ApplicantRepository $applicantRepository,
        OfferRepository $offerRepository
    ) {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->applicantRepository = $applicantRepository;
        $this->offerRepository = $offerRepository;
    }

    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'countApplicant' => $this->applicantRepository->countApplicant(),
            'countCompany' => $this->companyRepository->countCompany(),
            'countOffers' => $this->offerRepository->countOffers()
            ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ozeo Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Gestion Entreprises', 'fas fa-list', Company::class);
        yield MenuItem::linkToCrud('Gestion Skills', 'fas fa-list', Skill::class);
        yield MenuItem::linkToCrud('Gestion Catégories', 'fas fa-list', SkillCategory::class);
    }
}
