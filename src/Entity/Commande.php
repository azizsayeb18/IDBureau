<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     */
    private $idUser;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity=PanierLigne::class, mappedBy="idCommande")
     */
    private $panierLignes;

    public function __construct()
    {
        $this->panierLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|PanierLigne[]
     */
    public function getPanierLignes(): Collection
    {
        return $this->panierLignes;
    }

    public function addPanierLigne(PanierLigne $panierLigne): self
    {
        if (!$this->panierLignes->contains($panierLigne)) {
            $this->panierLignes[] = $panierLigne;
            $panierLigne->setIdCommande($this);
        }

        return $this;
    }

    public function removePanierLigne(PanierLigne $panierLigne): self
    {
        if ($this->panierLignes->removeElement($panierLigne)) {
            // set the owning side to null (unless already changed)
            if ($panierLigne->getIdCommande() === $this) {
                $panierLigne->setIdCommande(null);
            }
        }

        return $this;
    }
}
