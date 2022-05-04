<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 70)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\Column(type: 'integer')]
    private $value;

    #[ORM\Column(type: 'string', length: 255)]
    private $picture;

    #[ORM\Column(type: 'datetime_immutable')]
    private $buyAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $releaseAt;

    #[ORM\Column(type: 'boolean')]
    private $isOnSale;

    #[ORM\Column(type: 'text')]
    private $description;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getBuyAt(): ?\DateTimeImmutable
    {
        return $this->buyAt;
    }

    public function setBuyAt(\DateTimeImmutable $buyAt): self
    {
        $this->buyAt = $buyAt;

        return $this;
    }

    public function getReleaseAt(): ?\DateTimeImmutable
    {
        return $this->releaseAt;
    }

    public function setReleaseAt(\DateTimeImmutable $releaseAt): self
    {
        $this->releaseAt = $releaseAt;

        return $this;
    }

    public function getIsOnSale(): ?bool
    {
        return $this->isOnSale;
    }

    public function setIsOnSale(bool $isOnSale): self
    {
        $this->isOnSale = $isOnSale;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
