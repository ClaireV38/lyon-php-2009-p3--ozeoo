<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Il vous faut indiquer l'intitulé du poste")
     * @Assert\Length(max="255", maxMessage="L'intitulé ne doit pas faire plus de 255 caractères")
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $title;

    /**
     * @Assert\NotBlank(message="Il vous faut indiquer un type de contrat")
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    private $contractType;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $duration;

    /**
     * @Assert\GreaterThan("today")
     * @Assert\NotBlank(message="Il vous faut indiquer la date de début du contrat")
     * @ORM\Column(type="date")
     * @var \DateTimeInterface
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     * @var \DateTimeInterface
     */
    private $creationDate;

    /**
     * @Assert\NotBlank(message="Il vous faut indiquer la date limite de candidature")
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTimeInterface
     */
    private $endDate;

    /**
     * @Assert\NotBlank(message="Il vous faut indiquer une description du poste")
     * @ORM\Column(type="text")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $isAnonymous;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     * @var City
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     * @var Company
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, mappedBy="offer")
     * @var Collection<Skill>
     */
    private $skills;

    /**
     * @ORM\ManyToMany(targetEntity=Applicant::class, inversedBy="offers")
     * @var Collection<Applicant>
     */
    private $applicant;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->applicant = new ArrayCollection();
        $this->creationDate = new \DateTime();
        $this->startDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    public function setContractType(string $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $date): self
    {
        $this->startDate = $date;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsAnonymous(): ?bool
    {
        return $this->isAnonymous;
    }

    public function setIsAnonymous(bool $isAnonymous): self
    {
        $this->isAnonymous = $isAnonymous;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->addOffer($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeOffer($this);
        }

        return $this;
    }

    /**
     * @return Collection|Applicant[]
     */
    public function getApplicant(): Collection
    {
        return $this->applicant;
    }

    public function addApplicant(Applicant $applicant): self
    {
        if (!$this->applicant->contains($applicant)) {
            $this->applicant[] = $applicant;
        }

        return $this;
    }

    public function removeApplicant(Applicant $applicant): self
    {
        $this->applicant->removeElement($applicant);

        return $this;
    }
}
