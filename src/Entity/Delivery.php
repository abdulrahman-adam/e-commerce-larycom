<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
class Delivery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $time = null;

    #[ORM\OneToMany(mappedBy: 'delivery', targetEntity: Commander::class)]
    private Collection $commander;

    public function __construct()
    {
        $this->commander = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return Collection<int, Commander>
     */
    public function getCommander(): Collection
    {
        return $this->commander;
    }

    public function addCommander(Commander $commander): self
    {
        if (!$this->commander->contains($commander)) {
            $this->commander->add($commander);
            $commander->setDelivery($this);
        }

        return $this;
    }

    public function removeCommander(Commander $commander): self
    {
        if ($this->commander->removeElement($commander)) {
            // set the owning side to null (unless already changed)
            if ($commander->getDelivery() === $this) {
                $commander->setDelivery(null);
            }
        }

        return $this;
    }
}
