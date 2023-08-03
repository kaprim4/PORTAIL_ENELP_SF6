<?php

namespace App\Entity;

use App\Repository\OrderExportRepository;
use App\Trait\DateTimeTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderExportRepository::class)]
#[ORM\Table(name: '`order_export`')]
#[ORM\HasLifecycleCallbacks]
class OrderExport
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $exportNumber = null;

    #[ORM\Column]
    private ?int $nbrLine = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        "default" => false
    ])]
    private ?bool $isManual = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExportNumber(): ?string
    {
        return $this->exportNumber;
    }

    public function setExportNumber(string $exportNumber): self
    {
        $this->exportNumber = $exportNumber;

        return $this;
    }

    public function getNbrLine(): ?int
    {
        return $this->nbrLine;
    }

    public function setNbrLine(int $nbrLine): self
    {
        $this->nbrLine = $nbrLine;

        return $this;
    }

    public function isIsManual(): ?bool
    {
        return $this->isManual;
    }

    public function setIsManual(bool $isManual): self
    {
        $this->isManual = $isManual;

        return $this;
    }
}
