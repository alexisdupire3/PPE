<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Sejour::class, mappedBy="idPatient", orphanRemoval=true)
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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
            $sejour->setIdPatient($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $sejour): self
    {
        if ($this->sejours->removeElement($sejour)) {
            // set the owning side to null (unless already changed)
            if ($sejour->getIdPatient() === $this) {
                $sejour->setIdPatient(null);
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
