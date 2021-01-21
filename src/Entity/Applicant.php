<?php

namespace App\Entity;

use App\Repository\ApplicantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicantRepository::class)
 */
class Applicant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="Le champ est vide")
     * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="Le champ est vide")
     * @var string
     */
    private $lastname;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(message="Le champ est vide")
     * @var string
     */
    private $personality;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="applicant", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="softApplicants")
     * @ORM\JoinTable(name="applicant_soft_skills",
     *      joinColumns={@ORM\JoinColumn(name="applicant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="skill_id", referencedColumnName="id")}
     *     )
     * @var Collection<Skill>
     */
    private $softSkills;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="hardApplicants")
     * @ORM\JoinTable(name="applicant_hard_skills",
     *      joinColumns={@ORM\JoinColumn(name="applicant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="skill_id", referencedColumnName="id")}
     *     )
     * @var Collection<Skill>
     */
    private $hardSkills;

    /**
     * @ORM\ManyToMany(targetEntity=Offer::class, mappedBy="applicant")
     * @var Collection<Offer>
     */
    private $offers;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $mobility;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Le texte ne doit pas exceder 255 caractères.")
     * @var string
     */
    private $availability;

    public function __construct()
    {
        $this->softSkills = new ArrayCollection();
        $this->hardSkills = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPersonality(): ?string
    {
        return $this->personality;
    }

    public function setPersonality(string $personality): self
    {
        $this->personality = $personality;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->addApplicant($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            $offer->removeApplicant($this);
        }

        return $this;
    }

    public function getMobility(): ?string
    {
        return $this->mobility;
    }

    public function setMobility(string $mobility): self
    {
        $this->mobility = $mobility;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    public function setAvailability(string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }
}
