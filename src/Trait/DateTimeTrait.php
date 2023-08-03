<?php

namespace App\Trait;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait DateTimeTrait
{
    #[ORM\Column(type: Types::BOOLEAN, options: [
        "default" => 1
    ])]
    private ?bool $isActivated = false;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        "default" => 0
    ])]
    private ?bool $isDeleted = false;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: [
        "default" => "CURRENT_TIMESTAMP"
    ])]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: [
        "default" => "CURRENT_TIMESTAMP"
    ])]
    private ?DateTimeImmutable $updatedAt = null;


    public function isIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(bool $isActivated): self
    {
        $this->isActivated = $isActivated;
        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function create(): void
    {
        if($this->getCreatedAt() === null)
            $this->setCreatedAt(new DateTimeImmutable());
        $this->setUpdatedAt(new DateTimeImmutable());
    }

    #[ORM\PreUpdate]
    public function update(): void
    {
        $this->setUpdatedAt(new DateTimeImmutable());
    }
}
