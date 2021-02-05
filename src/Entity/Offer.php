<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use ContainerDv8rw2p\get_ServiceLocator_C9JCBPCService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

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
     * @Assert\NotBlank(message="Il vous faut indiquer l'intitulé du poste",
     *     groups={"listSkill"}
     *     )
     * @Assert\Length(max="150", maxMessage="L'intitulé ne doit pas faire plus de 150 caractères")
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $title;

    /**
     * @Assert\NotBlank(message="Il vous faut indiquer un type de contrat",
     *     groups={"listSkill"}
     *     )
     * @Assert\Length(max="50", maxMessage="L'intitulé ne doit pas faire plus de 50 caractères")
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    private $contractType;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max="50", maxMessage="L'intitulé ne doit pas faire plus de 50 caractères",
     *     groups={"listSkill"}
     *     )
     * @var string
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="50", maxMessage="L'intitulé ne doit pas faire plus de 50 caractères",
     *     groups={"listSkill"}
     *     )
     * @var string
     */
    private $duration ;

    /**
     * @Assert\GreaterThanOrEqual("today")
     * @Assert\NotBlank(message="Il vous faut indiquer la date de début du contrat",
     *     groups={"listSkill"}
     *     )
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
     * @Assert\GreaterThanOrEqual("today",
     *     groups={"listSkill"}
     *     )
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTimeInterface|null
     */
    private $endDate;

    /**
     * @Assert\NotBlank(message="Il vous faut indiquer une description du poste",
     *     groups={"listSkill"}
     *     )
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
     * @Assert\NotBlank(message="Il vous faut indiquer une ville",
     *     groups={"listSkill"}
     *     )
     * @Assert\Length(max="50", maxMessage="L'intitulé ne doit pas faire plus de 50 caractères")
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     * @var Company
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="softOffers")
     * @ORM\JoinTable(name="offer_soft_skills",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="skill_id", referencedColumnName="id")}
     *     )
     * @var Collection<Skill>
     */
    private $softSkills;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="hardOffers")
     * @ORM\JoinTable(name="offer_hard_skills",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="skill_id", referencedColumnName="id")}
     *     )
     * @var Collection<Skill>
     */
    private $hardSkills;


    /**
     * @ORM\ManyToMany(targetEntity=Applicant::class, inversedBy="offers")
     * @var Collection<Applicant>
     */
    private $applicants;

    public function __construct()
    {
        $this->applicants = new ArrayCollection();
        $this->creationDate = new DateTime();
        $this->startDate = new DateTime();
        $this->softSkills = new ArrayCollection();
        $this->hardSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    public function setContractType(?string $contractType): self
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

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
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
     * @return Collection|Applicant[]
     */
    public function getApplicants(): Collection
    {
        return $this->applicants;
    }

    public function addApplicant(Applicant $applicant): self
    {
        if (!$this->applicants->contains($applicant)) {
            $this->applicants[] = $applicant;
        }

        return $this;
    }

    public function removeApplicant(Applicant $applicant): self
    {
        $this->applicants->removeElement($applicant);

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSoftSkills(): Collection
    {
        return $this->softSkills;
    }

    public function addSoftSkill(Skill $softSkill): self
    {
        if (!$this->softSkills->contains($softSkill)) {
            $this->softSkills[] = $softSkill;
        }

        return $this;
    }

    public function removeSoftSkill(Skill $softSkill): self
    {
        $this->softSkills->removeElement($softSkill);

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getHardSkills(): Collection
    {
        return $this->hardSkills;
    }

    public function addHardSkill(Skill $hardSkill): self
    {
        if (!$this->hardSkills->contains($hardSkill)) {
            $this->hardSkills[] = $hardSkill;
        }

        return $this;
    }

    public function removeHardSkill(Skill $hardSkill): self
    {
        $this->hardSkills->removeElement($hardSkill);

        return $this;
    }
}
