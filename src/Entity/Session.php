<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\New_;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{ 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de début ne peut pas être vide.")]
    #[Assert\Type("\DateTimeInterface", message: "La date de début doit être valide.")]
    private ?\DateTimeInterface $dateDebue = null; 


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de fin ne peut pas être vide.")]
    #[Assert\Type("\DateTimeInterface", message: "La date de fin doit être valide.")]
    #[Assert\GreaterThanOrEqual(
        propertyPath: "dateDebue",
        message: "La date de fin ne peut pas être avant la date de début."
    )]
    private ?\DateTimeInterface $dateFine = null; 


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la formation ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de la formation ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $nomFormation = '';


    public function __construct()
    {
        $this->dateDebue = new \DateTime('now');
        $this->dateFine = new \DateTime('now');
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebue(): ?\DateTimeInterface
    {
        return $this->dateDebue;
    }

    public function setDateDebue(\DateTimeInterface $dateDebue): static
    {
        $this->dateDebue = $dateDebue;
        return $this;
    }

    public function getDateFine(): ?\DateTimeInterface
    {
        return $this->dateFine;
    }

    public function setDateFine(\DateTimeInterface $dateFine): static
    {
        $this->dateFine = $dateFine;

        return $this;
    }

    public function getNomFormation(): ?string
    {
        return $this->nomFormation;
    }

    public function setNomFormation(string $nomFormation): static
    {
        $this->nomFormation = $nomFormation;

        return $this;
    }
}
