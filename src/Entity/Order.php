<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use App\Trait\DateTimeTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\HasLifecycleCallbacks]
class Order
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sellDocWeb = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sellDocSap = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sellDocDate = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?GasStation $gasStation = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        "default" => false
    ])]
    private ?bool $isExported = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderRow::class)]
    private Collection $orderRows;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        "default" => 0
    ])]
    private ?bool $isMailSent = null;

    public function __construct()
    {
        $this->orderRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSellDocWeb(): ?string
    {
        return $this->sellDocWeb;
    }

    public function setSellDocWeb(?string $sellDocWeb): self
    {
        $this->sellDocWeb = $sellDocWeb;
        return $this;
    }

    public function getSellDocSap(): ?string
    {
        return $this->sellDocSap;
    }

    public function setSellDocSap(?string $sellDocSap): self
    {
        $this->sellDocSap = $sellDocSap;
        return $this;
    }

    public function getSellDocDate(): ?DateTimeInterface
    {
        return $this->sellDocDate;
    }

    public function setSellDocDate(?DateTimeInterface $sellDocDate): self
    {
        $this->sellDocDate = $sellDocDate;
        return $this;
    }

    public function getGasStation(): ?GasStation
    {
        return $this->gasStation;
    }

    public function setGasStation(?GasStation $gasStation): self
    {
        $this->gasStation = $gasStation;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function isIsExported(): ?bool
    {
        return $this->isExported;
    }

    public function setIsExported(bool $isExported): self
    {
        $this->isExported = $isExported;
        return $this;
    }

    /**
     * @return Collection<int, OrderRow>
     */
    public function getOrderRows(): Collection
    {
        return $this->orderRows;
    }

    public function addOrderRow(OrderRow $orderRow): self
    {
        if (!$this->orderRows->contains($orderRow)) {
            $this->orderRows->add($orderRow);
            $orderRow->setOrder($this);
        }
        return $this;
    }

    public function removeOrderRow(OrderRow $orderRow): self
    {
        if ($this->orderRows->removeElement($orderRow)) {
            if ($orderRow->getOrder() === $this) {
                $orderRow->setOrder(null);
            }
        }
        return $this;
    }

    public function isIsMailSent(): ?bool
    {
        return $this->isMailSent;
    }

    public function setIsMailSent(?bool $isMailSent): self
    {
        $this->isMailSent = $isMailSent;

        return $this;
    }
}
