<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Count(
     *      max = 10,
     *      maxMessage = "Tu ne peux pas choisir plus de 10 compétences"
     * )
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
     * @ORM\ManyToMany(targetEntity=Applicant::class, mappedBy="softSkills")
     * @var Collection<Applicant>
     */
    private $softApplicants;

    /**
     * @ORM\ManyToMany(targetEntity=Applicant::class, mappedBy="hardSkills")
     * @var Collection<Applicant>
     */
    private $hardApplicants;

    /**
     * @ORM\ManyToMany(targetEntity=Offer::class, inversedBy="skills")
     * @var Collection<Offer>
     */
    private $offers;

    public function __construct()
    {
        $this->softApplicants = new ArrayCollection();
        $this->hardApplicants = new ArrayCollection();
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
    public function getSoftApplicants(): Collection
    {
        return $this->softApplicants;
    }

    public function addSoftApplicant(Applicant $softApplicant): self
    {
        if (!$this->softApplicants->contains($softApplicant)) {
            $this->softApplicants[] = $softApplicant;
            $softApplicant->addSoftSkill($this);
        }

        return $this;
    }

    public function removeSoftApplicant(Applicant $softApplicant): self
    {
        if ($this->softApplicants->removeElement($softApplicant)) {
            $softApplicant->removeSoftSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection|Applicant[]
     */
    public function getHardApplicants(): Collection
    {
        return $this->hardApplicants;
    }

    public function addHardApplicant(Applicant $hardApplicant): self
    {
        if (!$this->hardApplicants->contains($hardApplicant)) {
            $this->hardApplicants[] = $hardApplicant;
            $hardApplicant->addHardSkill($this);
        }

        return $this;
    }

    public function removeHardApplicant(Applicant $hardApplicant): self
    {
        if ($this->hardApplicants->removeElement($hardApplicant)) {
            $hardApplicant->removeHardSkill($this);
        }
        return $this;
    }
}
