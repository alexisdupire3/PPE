<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChambreRepository::class)
 */
class Chambre
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
    private $numChambre;

    /**
     * @ORM\OneToMany(targetEntity=Lit::class, mappedBy="numChambre")
     */
    private $lits;

    public function __construct()
    {
        $this->lits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumChambre(): ?int
    {
        return $this->numChambre;
    }

    public function setNumChambre(int $numChambre): self
    {
        $this->numChambre = $numChambre;

        return $this;
    }

    /**
     * @return Collection|Lit[]
     */
    public function getLits(): Collection
    {
        return $this->lits;
    }

    public function addLit(Lit $lit): self
    {
        if (!$this->lits->contains($lit)) {
            $this->lits[] = $lit;
            $lit->setNumChambre($this);
        }

        return $this;
    }

    public function removeLit(Lit $lit): self
    {
        if ($this->lits->removeElement($lit)) {
            // set the owning side to null (unless already changed)
            if ($lit->getNumChambre() === $this) {
                $lit->setNumChambre(null);
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
