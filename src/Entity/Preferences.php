<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PreferencesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferencesRepository::class)]
class Preferences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $cree_le = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contacts $contact = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieProduits $categorie_produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreeLe(): ?\DateTimeInterface
    {
        return $this->cree_le;
    }

    public function setCreeLe(\DateTimeInterface $cree_le): self
    {
        $this->cree_le = $cree_le;

        return $this;
    }

    public function getContact(): ?Contacts
    {
        return $this->contact;
    }

    public function setContact(?Contacts $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getCategorieProduit(): ?CategorieProduits
    {
        return $this->categorie_produit;
    }

    public function setCategorieProduit(?CategorieProduits $categorie_produit): self
    {
        $this->categorie_produit = $categorie_produit;

        return $this;
    }
}
