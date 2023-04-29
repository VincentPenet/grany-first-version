<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ContactsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactsRepository::class)]
class Contacts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(
        message: 'Cette adresse mail n\'est pas valide',
    )]
    private ?string $mail = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $cree_le = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $maj_le = null;

    #[ORM\Column]
    private ?int $rgpd_validation = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Civilite $civilite = null;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: Messages::class)]
    private Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
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

    public function getMajLe(): ?\DateTimeInterface
    {
        return $this->maj_le;
    }

    public function setMajLe(?\DateTimeInterface $maj_le): self
    {
        $this->maj_le = $maj_le;

        return $this;
    }

    public function getRgpdValidation(): ?int
    {
        return $this->rgpd_validation;
    }

    public function setRgpdValidation(int $rgpd_validation): self
    {
        $this->rgpd_validation = $rgpd_validation;

        return $this;
    }

    public function getCivilite(): ?Civilite
    {
        return $this->civilite;
    }

    public function setCivilite(?Civilite $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setContact($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getContact() === $this) {
                $message->setContact(null);
            }
        }

        return $this;
    }
}
