<?php

namespace App\Services;

use App\Entity\Applicant;
use App\Repository\ApplicantRepository;

class SearchOffers
{
    /**
     * @var array
     */
    private $matchOffersArray = [];

    /**
     * @var ApplicantRepository
     */
    private $applicantRepository;

    public function __construct(ApplicantRepository $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }

    public function getSearchedOffers(
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
}
