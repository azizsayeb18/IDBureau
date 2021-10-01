<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="idUser")
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity=LigneCommande::class, mappedBy="idUser")
     */
    private $ligneCommandes;

    /**
     * @ORM\OneToMany(targetEntity=PanierLigne::class, mappedBy="idUser")
     */
    private $panierLignes;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->commandes = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
        $this->panierLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setIdUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getIdUser() === $this) {
                $commande->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LigneCommande[]
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setIdUser($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getIdUser() === $this) {
                $ligneCommande->setIdUser(null);
            }
        }

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
            $panierLigne->setIdUser($this);
        }

        return $this;
    }

    public function removePanierLigne(PanierLigne $panierLigne): self
    {
        if ($this->panierLignes->removeElement($panierLigne)) {
            // set the owning side to null (unless already changed)
            if ($panierLigne->getIdUser() === $this) {
                $panierLigne->setIdUser(null);
            }
        }

        return $this;
    }
}