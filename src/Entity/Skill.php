<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=SkillCategory::class, inversedBy="skills")
     * @ORM\JoinColumn(nullable=false)
     * @var SkillCategory
     */
    private $skillCategory;

    /**
     * @ORM\ManyToMany(targetEntity=Applicant::class, inversedBy="skills")
     * @var Collection<Applicant>
     */
    private $applicants;

    /**
     * @ORM\ManyToMany(targetEntity=Offer::class, inversedBy="skills")
     * @var Collection<Offer>
     */
    private $offers;

    public function __construct()
    {
        $this->applicants = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSkillCategory(): ?SkillCategory
    {
        return $this->skillCategory;
    }

    public function setSkillCategory(SkillCategory $skillCategory): self
    {
        $this->skillCategory = $skillCategory;

        return $this;
    }

    /**
     * @return Collection|Applicant[]
     */
    public function getApplicant(): Collection
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
     * @return Collection|Offer[]
     */
    public function getOffer(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        $this->offers->removeElement($offer);

        return $this;
    }

    /**
     * @return Collection|Applicant[]
     */
    public function getApplicants(): Collection
    {
        return $this->applicants;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }
}
