<?php

namespace App\Entity;

use App\Repository\LegalFormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LegalFormRepository::class)
 */
class LegalForm
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Firm
     *
     * @ORM\OneToMany(targetEntity=Firm::class, mappedBy="legalForm", orphanRemoval=true)
     */
    private $firm;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function __construct()
    {
        $this->firm = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title ?? 'n/a';
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

    /**
     * @return Collection|Firm[]
     */
    public function getFirm(): Collection
    {
        return $this->firm;
    }

    public function addFirm(Firm $firm): self
    {
        if (!$this->firm->contains($firm)) {
            $this->firm[] = $firm;
            $firm->setLegalForm($this);
        }

        return $this;
    }

    public function removeFirm(Firm $firm): self
    {
        if ($this->firm->contains($firm)) {
            $this->firm->removeElement($firm);
            // set the owning side to null (unless already changed)
            if ($firm->getLegalForm() === $this) {
                $firm->setLegalForm(null);
            }
        }

        return $this;
    }
}
