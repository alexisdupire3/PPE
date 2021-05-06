<?php

namespace App\Entity;

use App\Repository\SejourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SejourRepository::class)
 */
class Sejour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idPatient;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateArrive;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateSortie;

    /**
     * @ORM\ManyToOne(targetEntity=Lit::class, inversedBy="sejours")
     */
    private $numeroLit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPatient(): ?Patient
    {
        return $this->idPatient;
    }

    public function setIdPatient(?Patient $idPatient): self
    {
        $this->idPatient = $idPatient;

        return $this;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->dateArrive;
    }

    public function setDateArrive(\DateTimeInterface $dateArrive): self
    {
        $this->dateArrive = $dateArrive;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(?\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getNumeroLit(): ?Lit
    {
        return $this->numeroLit;
    }

    public function setNumeroLit(?Lit $numeroLit): self
    {
        $this->numeroLit = $numeroLit;

        return $this;
    }

    /**
     * Generates the magic method
     *
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->idPatient;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
