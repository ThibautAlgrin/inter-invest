<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FirmRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Firm.
 *
 * @Gedmo\Loggable
 *
 * @ORM\Entity(repositoryClass=FirmRepository::class)
 */
class Firm
{
    use Behavior\TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var LegalForm
     *
     * @Gedmo\Versioned
     *
     * @ORM\ManyToOne(targetEntity=LegalForm::class, inversedBy="firm")
     * @ORM\JoinColumn(nullable=false)
     */
    private $legalForm;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     *
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     *
     * @ORM\Column(type="string", length=255)
     */
    private $siren;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     *
     * @ORM\Column(type="string", length=255)
     */
    private $registerCity;

    /**
     * @var \DateTime
     *
     * @Gedmo\Versioned
     *
     * @ORM\Column(type="date")
     */
    private $dateRegister;

    /**
     * @var float
     *
     * @Gedmo\Versioned
     *
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $capital;

    /**
     * @var array
     *
     * @Gedmo\Versioned
     *
     * @ORM\Column(type="json")
     */
    private $address;

    public function __construct()
    {
        $this->address = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegalForm(): ?LegalForm
    {
        return $this->legalForm;
    }

    public function setLegalForm(?LegalForm $legalForm): self
    {
        $this->legalForm = $legalForm;

        return $this;
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getRegisterCity(): ?string
    {
        return $this->registerCity;
    }

    public function setRegisterCity(string $registerCity): self
    {
        $this->registerCity = $registerCity;

        return $this;
    }

    public function getDateRegister(): ?\DateTimeInterface
    {
        return $this->dateRegister;
    }

    public function setDateRegister(\DateTimeInterface $dateRegister): self
    {
        $this->dateRegister = $dateRegister;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(string $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getAddress(): array
    {
        return $this->address;
    }

    /**
     * @return Firm
     */
    public function setAddress(array $address): self
    {
        $this->address = $address;

        return $this;
    }
}
