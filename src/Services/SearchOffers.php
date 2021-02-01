<?php

namespace App\Services;

use App\Entity\Applicant;
use App\Entity\Company;
use App\Entity\Offer;
use App\Repository\ApplicantRepository;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\Collection;

class SearchOffers
{
    /**
     * @var array
     */
    private $matchOffersArray = [];

    /**
     * @var Collection<Offer>
     */
    private $offers;

    /**
     * @var ApplicantRepository
     */
    private $applicantRepository;

    /**
     * @var OfferRepository
     */
    private $offerRepository;

    public function __construct(ApplicantRepository $applicantRepository, OfferRepository $offerRepository)
    {
        $this->applicantRepository = $applicantRepository;
        $this->offerRepository = $offerRepository;
    }

    public function getSearchedOffersForApplicant(
        Applicant $applicant,
        string $searchTitle,
        string $searchCompany,
        string $field
    ): array {
        switch ($field) {
            case 'startDate':
                $this->matchOffersArray = $this->applicantRepository->findMatchingOffersForApplicantOrderBystartDate(
                    $applicant,
                    $searchTitle,
                    $searchCompany
                );
                break;
            case 'creationDate':
                $this->matchOffersArray = $this->applicantRepository->findMatchingOffersForApplicantOrderByCreationDate(
                    $applicant,
                    $searchTitle,
                    $searchCompany
                );
                break;
            case 'endDate':
                $this->matchOffersArray = $this->applicantRepository->findMatchingOffersForApplicantOrderByEndDate(
                    $applicant,
                    $searchTitle,
                    $searchCompany
                );
                break;
            case 'title':
                $this->matchOffersArray = $this->applicantRepository->findMatchingOffersForApplicantOrderByTitle(
                    $applicant,
                    $searchTitle,
                    $searchCompany
                );
                break;
            case 'company':
                $this->matchOffersArray = $this->applicantRepository->findMatchingOffersForApplicantOrderByCompany(
                    $applicant,
                    $searchTitle,
                    $searchCompany
                );
                break;
        }
        return $this->matchOffersArray;
    }

    /**
     * @param string $search
     * @param Company $company
     * @param string $field
     * @return Collection|int|mixed|string
     */
    public function getSearchedOffersForCompany(string $search, Company $company, string $field)
    {
        switch ($field) {
            case 'startDate':
                $this->offers = $this->offerRepository->findLikeTitleOrderByStartDate($search, $company);
                break;
            case 'creationDate':
                $this->offers = $this->offerRepository->findLikeTitleOrderByCreationDate($search, $company);
                break;
            case 'endDate':
                $this->offers = $this->offerRepository->findLikeTitleOrderByEndDate($search, $company);
                break;
            case 'title':
                $this->offers = $this->offerRepository->findLikeTitleOrderByTitle($search, $company);
                break;
            default:
                $this->offers = $this->offerRepository->findLikeTitleOrderById($search, $company);
        }
        return $this->offers;
    }
}
