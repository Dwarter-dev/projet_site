<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom_produit;

    #[ORM\Column(type: 'text')]
    private $description_produit;

    #[ORM\Column(type: 'string', length: 255)]
    private $image_produit;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nb_manette_produit;

    #[ORM\Column(type: 'boolean')]
    private $branchement_produit;

    #[ORM\Column(type: 'boolean')]
    private $boite_produit;

    #[ORM\Column(type: 'boolean')]
    private $notice_produit;

    #[ORM\Column(type: 'integer')]
    private $prix_produit;

    #[ORM\ManyToMany(targetEntity: GenreProduit::class, inversedBy: 'produits')]
    private $genre_produit;

    #[ORM\ManyToMany(targetEntity: LangueProduit::class, inversedBy: 'produits')]
    private $langue_produit;

    #[ORM\ManyToOne(targetEntity: RegionProduit::class, inversedBy: 'produits')]
    private $region_produit;

    #[ORM\ManyToOne(targetEntity: EtatProduit::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private $etat_produit;

    #[ORM\ManyToOne(targetEntity: CategorieProduit::class, inversedBy: 'produits')]
    private $categorie_produit;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    private $ligneCommandes;

    public function __construct()
    {
        $this->genre_produit = new ArrayCollection();
        $this->langue_produit = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): self
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->description_produit;
    }

    public function setDescriptionProduit(string $description_produit): self
    {
        $this->description_produit = $description_produit;

        return $this;
    }

    public function getImageProduit(): ?string
    {
        return $this->image_produit;
    }

    public function setImageProduit(string $image_produit): self
    {
        $this->image_produit = $image_produit;

        return $this;
    }

    public function getNbManetteProduit(): ?int
    {
        return $this->nb_manette_produit;
    }

    public function setNbManetteProduit(?int $nb_manette_produit): self
    {
        $this->nb_manette_produit = $nb_manette_produit;

        return $this;
    }

    public function getBranchementProduit(): ?bool
    {
        return $this->branchement_produit;
    }

    public function setBranchementProduit(bool $branchement_produit): self
    {
        $this->branchement_produit = $branchement_produit;

        return $this;
    }

    public function getBoiteProduit(): ?bool
    {
        return $this->boite_produit;
    }

    public function setBoiteProduit(bool $boite_produit): self
    {
        $this->boite_produit = $boite_produit;

        return $this;
    }

    public function getNoticeProduit(): ?bool
    {
        return $this->notice_produit;
    }

    public function setNoticeProduit(bool $notice_produit): self
    {
        $this->notice_produit = $notice_produit;

        return $this;
    }

    public function getPrixProduit(): ?int
    {
        return $this->prix_produit;
    }

    public function setPrixProduit(int $prix_produit): self
    {
        $this->prix_produit = $prix_produit;

        return $this;
    }

    /**
     * @return Collection|GenreProduit[]
     */
    public function getGenreProduit(): Collection
    {
        return $this->genre_produit;
    }

    public function addGenreProduit(GenreProduit $genreProduit): self
    {
        if (!$this->genre_produit->contains($genreProduit)) {
            $this->genre_produit[] = $genreProduit;
        }

        return $this;
    }

    public function removeGenreProduit(GenreProduit $genreProduit): self
    {
        $this->genre_produit->removeElement($genreProduit);

        return $this;
    }

    /**
     * @return Collection|LangueProduit[]
     */
    public function getLangueProduit(): Collection
    {
        return $this->langue_produit;
    }

    public function addLangueProduit(LangueProduit $langueProduit): self
    {
        if (!$this->langue_produit->contains($langueProduit)) {
            $this->langue_produit[] = $langueProduit;
        }

        return $this;
    }

    public function removeLangueProduit(LangueProduit $langueProduit): self
    {
        $this->langue_produit->removeElement($langueProduit);

        return $this;
    }

    public function getRegionProduit(): ?RegionProduit
    {
        return $this->region_produit;
    }

    public function setRegionProduit(?RegionProduit $region_produit): self
    {
        $this->region_produit = $region_produit;

        return $this;
    }

    public function getEtatProduit(): ?EtatProduit
    {
        return $this->etat_produit;
    }

    public function setEtatProduit(?EtatProduit $etat_produit): self
    {
        $this->etat_produit = $etat_produit;

        return $this;
    }

    public function getCategorieProduit(): ?CategorieProduit
    {
        return $this->categorie_produit;
    }

    public function setCategorieProduit(?CategorieProduit $categorie_produit): self
    {
        $this->categorie_produit = $categorie_produit;

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
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }
}
