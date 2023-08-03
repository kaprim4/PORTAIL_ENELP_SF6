<?php

namespace App\Entity;

use App\Repository\OrderRowRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRowRepository::class)]
#[ORM\Table(name: '`order_row`')]
#[ORM\HasLifecycleCallbacks]
class OrderRow
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderRows')]
    private ?Order $order = null;

    #[ORM\ManyToOne(inversedBy: 'orderRows')]
    private ?Product $product = null;

    #[ORM\OneToMany(mappedBy: 'orderRow', targetEntity: OrderHistory::class)]
    private Collection $orderHistories;

    #[ORM\Column]
    private ?bool $isPartial = null;

    public function __construct()
    {
        $this->orderHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;
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

    /**
     * @return Collection<int, OrderHistory>
     */
    public function getOrderHistories(): Collection
    {
        return $this->orderHistories;
    }

    public function addOrderHistory(OrderHistory $orderHistory): self
    {
        if (!$this->orderHistories->contains($orderHistory)) {
            $this->orderHistories->add($orderHistory);
            $orderHistory->setOrderRow($this);
        }

        return $this;
    }

    public function removeOrderHistory(OrderHistory $orderHistory): self
    {
        if ($this->orderHistories->removeElement($orderHistory)) {
            // set the owning side to null (unless already changed)
            if ($orderHistory->getOrderRow() === $this) {
                $orderHistory->setOrderRow(null);
            }
        }

        return $this;
    }

    public function isIsPartial(): ?bool
    {
        return $this->isPartial;
    }

    public function setIsPartial(bool $isPartial): self
    {
        $this->isPartial = $isPartial;

        return $this;
    }
}
