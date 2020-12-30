<?php

namespace App\Entity;

use App\Repository\ApplicantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $lastname;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $personality;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="applicants")
     * @ORM\JoinColumn(nullable=false)
     * @var City
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="applicant", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, mappedBy="applicant")
     * @var Collection<Skill>
     */
    private $skills;

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

    public function __construct()
    {
        $this->skills = new ArrayCollection();
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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

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
            $skill->addApplicant($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeApplicant($this);
        }

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
}
