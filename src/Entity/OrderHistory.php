<?php

namespace App\Entity;

use App\Repository\OrderHistoryRepository;
use App\Trait\DateTimeTrait;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderHistoryRepository::class)]
#[ORM\Table(name: '`order_history`')]
#[ORM\HasLifecycleCallbacks]
class OrderHistory
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderHistories')]
    private ?OrderRow $orderRow = null;

    #[ORM\ManyToOne(inversedBy: 'orderHistories')]
    private ?OrderStatus $orderStatus = null;

    #[ORM\Column]
    private ?int $qty = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: [
        "default" => "CURRENT_TIMESTAMP"
    ])]
    private ?DateTimeImmutable $appliedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderRow(): ?OrderRow
    {
        return $this->orderRow;
    }

    public function setOrderRow(?OrderRow $orderRow): self
    {
        $this->orderRow = $orderRow;
        return $this;
    }

    public function getOrderStatus(): ?OrderStatus
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(?OrderStatus $orderStatus): self
    {
        $this->orderStatus = $orderStatus;
        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;
        return $this;
    }

    public function getAppliedAt(): ?DateTimeImmutable
    {
        return $this->appliedAt;
    }

    public function setAppliedAt(?DateTimeImmutable $appliedAt): self
    {
        $this->appliedAt = $appliedAt;
        return $this;
    }
}
