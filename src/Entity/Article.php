<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 44)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\File(mimeTypes:['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
        return $this->picture;
    }

    public function setPicture(string|File|null $picture): self
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
    #[ORM\ArticleRemove]
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
