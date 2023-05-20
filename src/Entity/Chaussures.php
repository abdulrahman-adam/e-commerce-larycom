<?php

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChaussuresRepository;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ChaussuresRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Chaussures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $name = null;

    #[ORM\Column(length: 55)]
    private ?string $category = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\File(mimeTypes:['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/pdf'])]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'chaussures')]
    private ?Product $product = null;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }


      // cette méthode permet supprimer l'image 
      #[ORM\ChaussuresRemove]
      public function deletePicture(): void
      {
          // 1. On vérifier le fichier existe 
          if(file_exists(__DIR__.'/../../public/img/upload/'. $this->picture)) {
              // 2. On supprime le fichier 
              unlink(__DIR__.'/../../public/img/upload/'. $this->picture);
          }
          // 3. On indique utiliser cette méthode grâce aux événements:
          // #[ORM\HasLifecycleCallbacks] à ajouter sur la class
           // #[ORM\PostRemove] à ajouter sur la méthode qui prend l'évènement
      }
}
