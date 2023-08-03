<?php

namespace App\Entity;

use App\Repository\OrderUpdateRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderUpdateRepository::class)]
#[ORM\Table(name: '`order_update`')]
#[ORM\HasLifecycleCallbacks]
class OrderUpdate
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $updateNumber = null;

    #[ORM\Column]
    private ?int $nbrLine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpdateNumber(): ?string
    {
        return $this->updateNumber;
    }

    public function setUpdateNumber(string $updateNumber): self
    {
        $this->updateNumber = $updateNumber;
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
}
