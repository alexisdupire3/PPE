<?php

namespace App\Entity;

use App\Repository\LitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LitRepository::class)
 */
class Lit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numLit;

    /**
     * @ORM\ManyToOne(targetEntity=Chambre::class, inversedBy="lits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $numChambre;

    /**
     * @ORM\OneToMany(targetEntity=Sejour::class, mappedBy="numeroLit")
     */
    private $sejours;

    public function __construct()
    {
        $this->sejours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumLit(): ?int
    {
        return $this->numLit;
    }

    public function setNumLit(int $numLit): self
    {
        $this->numLit = $numLit;

        return $this;
    }

    public function getNumChambre(): ?Chambre
    {
        return $this->numChambre;
    }

    public function setNumChambre(?Chambre $numChambre): self
    {
        $this->numChambre = $numChambre;

        return $this;
    }

    /**
     * @return Collection|Sejour[]
     */
    public function getSejours(): Collection
    {
        return $this->sejours;
    }

    public function addSejour(Sejour $sejour): self
    {
        if (!$this->sejours->contains($sejour)) {
            $this->sejours[] = $sejour;
            $sejour->setNumeroLit($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $sejour): self
    {
        if ($this->sejours->removeElement($sejour)) {
            // set the owning side to null (unless already changed)
            if ($sejour->getNumeroLit() === $this) {
                $sejour->setNumeroLit(null);
            }
        }

        return $this;
    }

    /**
     * Generates the magic method
     *
     */
    public function __toString(): ?string {
        return $this->id;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
