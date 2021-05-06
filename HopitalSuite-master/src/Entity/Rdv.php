<?php

namespace App\Entity;

use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true, unique=true)
     */

     
    private $Date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $IdPatient;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $IdMedecin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(?\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(?string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getIdPatient(): ?User
    {
        return $this->IdPatient;
    }

    public function setIdPatient(?User $IdPatient): self
    {
        $this->IdPatient = $IdPatient;

        return $this;
    }

    public function getIdMedecin(): ?User
    {
        return $this->IdMedecin;
    }

    public function setIdMedecin(?User $IdMedecin): self
    {
        $this->IdMedecin = $IdMedecin;

        return $this;
    }
}
