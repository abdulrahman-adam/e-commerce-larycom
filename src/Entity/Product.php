<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 44)]
    private ?string $name = null;

    #[ORM\Column(length: 33)]
    private ?string $type = null;

    #[ORM\Column(length: 44)]
    private ?string $original = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\File(mimeTypes:['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/pdf'])]
    private ?string $Picture = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Article::class, orphanRemoval: true)]
    private Collection $articles;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Accessoires::class)]
    private Collection $accessoires;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Bagages::class)]
    private Collection $bagages;

    
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Chaussures::class)]
    private Collection $chaussures;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->accessoires = new ArrayCollection();
        $this->bagages = new ArrayCollection();
        $this->chaussures = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOriginal(): ?string
    {
        return $this->original;
    }

    public function setOriginal(string $original): self
    {
        $this->original = $original;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPicture(): string|File|null
    {
        return $this->Picture;
    }

    public function setPicture(string|File|null $Picture): self
    {
        $this->Picture = $Picture;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setProduct($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getProduct() === $this) {
                $article->setProduct(null);
            }
        }

        return $this;
    }


      // cette méthode permet supprimer l'image 
    #[ORM\ProductRemove]
    public function deletePicture(): void
    {
        // 1. On vérifier le fichier existe 
        if(file_exists(__DIR__.'/../../public/img/upload/'. $this->picture)) {
            // 2. On supprime le fichier 
            unlink(__DIR__.'/../../public/img/upload/'. $this->picture);
        }
        // 3. On indique utiliser cette méthode
        // #[ORM\HasLifecycleCallbacks] à ajouter sur la class
        // #[ORM\ProductRemove] à ajouter sur la méthode qui prend l'évènement
    }

    /**
     * @return Collection<int, Accessoires>
     */
    public function getAccessoires(): Collection
    {
        return $this->accessoires;
    }

    public function addAccessoire(Accessoires $accessoire): self
    {
        if (!$this->accessoires->contains($accessoire)) {
            $this->accessoires->add($accessoire);
            $accessoire->setProduct($this);
        }

        return $this;
    }

    public function removeAccessoire(Accessoires $accessoire): self
    {
        if ($this->accessoires->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getProduct() === $this) {
                $accessoire->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bagages>
     */
    public function getBagages(): Collection
    {
        return $this->bagages;
    }

    public function addBagage(Bagages $bagage): self
    {
        if (!$this->bagages->contains($bagage)) {
            $this->bagages->add($bagage);
            $bagage->setProduct($this);
        }

        return $this;
    }

    public function removeBagage(Bagages $bagage): self
    {
        if ($this->bagages->removeElement($bagage)) {
            // set the owning side to null (unless already changed)
            if ($bagage->getProduct() === $this) {
                $bagage->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Parfums>
     */
    public function getParfums(): Collection
    {
        return $this->parfums;
    }

  

    /**
     * @return Collection<int, Chaussures>
     */
    public function getChaussures(): Collection
    {
        return $this->chaussures;
    }

    public function addChaussure(Chaussures $chaussure): self
    {
        if (!$this->chaussures->contains($chaussure)) {
            $this->chaussures->add($chaussure);
            $chaussure->setProduct($this);
        }

        return $this;
    }

    public function removeChaussure(Chaussures $chaussure): self
    {
        if ($this->chaussures->removeElement($chaussure)) {
            // set the owning side to null (unless already changed)
            if ($chaussure->getProduct() === $this) {
                $chaussure->setProduct(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Sport>
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }


}
