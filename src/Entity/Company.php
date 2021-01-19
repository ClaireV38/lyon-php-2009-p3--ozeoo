<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 * @Vich\Uploadable
 */
class Company implements \Serializable
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
     * @Assert\NotBlank(message="Veuillez saisir votre nom.")
     * @Assert\Length(max="255", maxMessage="Le nom ne doit pas exceder 255 caractères.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=15)
     * @var string
     * @Assert\Regex("/^\d{14}$/",
     *      message="Le numéro de SIRET doit être composé de 14 chiffres.")
     * @Assert\NotBlank(message="Veuillez saisir un numéro de SIRET composé de 14 chiffres.")
     */
    private $siretNb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     * @Assert\NotBlank(groups={"company"})
     * @Assert\Length(max="255", maxMessage="L'email ne doit pas exceder 255 caractères.")
     */
    private $contactEmail;

    /**
     * @ORM\Column(type="string")
     * @var string
     * @Assert\Regex("/^([0-9]{4}[a-zA-Z]{1})$/",
     *     message="Veuillez saisir un numéro d'APE composé de 4 chiffres et une lettre")
     */
    private $apeNb;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @var string|null
     */
    private $picture;

    /**
     * @Vich\UploadableField(mapping="company_images", fileNameProperty="picture")
     * @var File|null
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage="Le fichier excède 2Mo.",
     * mimeTypes={"image/png", "image/jpeg", "image/jpg"},
     * mimeTypesMessage= "formats autorisés: png, jpeg, jpg"
     * )
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $video;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     * @Assert\NotBlank(groups={"company"})
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $corporateCulture;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $csr;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="company", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=Offer::class, mappedBy="company")
     * @var Collection<Offer>
     */
    private $offers;

    public function __construct()
    {
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

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(string $contactEmail): self
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getApeNb(): ?string
    {
        return $this->apeNb;
    }

    public function setApeNb(string $apeNb): self
    {
        $this->apeNb = $apeNb;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string|null $picture
     * @return $this
     */
    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return File|null
     * @Ignore()
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * @param File|null $pictureFile
     */
    public function setPictureFile(?File $pictureFile = null): void
    {
        $this->pictureFile = $pictureFile;
        // return $this;
        if (null !== $pictureFile) {
            $this->updatedAt = new DateTime("now");
        }
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

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

    public function getCorporateCulture(): ?string
    {
        return $this->corporateCulture;
    }

    public function setCorporateCulture(string $corporateCulture): self
    {
        $this->corporateCulture = $corporateCulture;

        return $this;
    }

    public function getCsr(): ?string
    {
        return $this->csr;
    }

    public function setCsr(string $csr): self
    {
        $this->csr = $csr;

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
            $offer->setCompany($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getCompany() === $this) {
                $offer->setCompany($this);
            }
        }

        return $this;
    }

    public function getSiretNb(): ?string
    {
        return $this->siretNb;
    }

    public function setSiretNb(string $siretNb): self
    {
        $this->siretNb = $siretNb;

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

    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            ) = unserialize($serialized, array('allowed_classes' => false));
    }
}
