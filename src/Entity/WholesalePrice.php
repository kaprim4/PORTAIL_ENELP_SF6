<?php

namespace App\Entity;

use App\Repository\WholesalePriceRepository;
use App\Trait\DateTimeTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WholesalePriceRepository::class)]
#[ORM\Table(name: '`wholesale_price`')]
#[ORM\HasLifecycleCallbacks]
class WholesalePrice
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filename_id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: [
        "default" => "CURRENT_TIMESTAMP"
    ])]
    private ?DateTimeImmutable $appliedAt = null;

    #[ORM\OneToMany(mappedBy: 'wholesalePrice', targetEntity: WholesalePriceDetail::class)]
    private Collection $wholesalePriceDetails;

    public function __construct()
    {
        $this->wholesalePriceDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilenameId(): ?string
    {
        return $this->filename_id;
    }

    public function setFilenameId(?string $filename_id): self
    {
        $this->filename_id = $filename_id;
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

    /**
     * @return Collection<int, WholesalePriceDetail>
     */
    public function getWholesalePriceDetails(): Collection
    {
        return $this->wholesalePriceDetails;
    }

    public function addWholesalePriceDetail(WholesalePriceDetail $wholesalePriceDetail): self
    {
        if (!$this->wholesalePriceDetails->contains($wholesalePriceDetail)) {
            $this->wholesalePriceDetails->add($wholesalePriceDetail);
            $wholesalePriceDetail->setWholesalePrice($this);
        }

        return $this;
    }

    public function removeWholesalePriceDetail(WholesalePriceDetail $wholesalePriceDetail): self
    {
        if ($this->wholesalePriceDetails->removeElement($wholesalePriceDetail)) {
            // set the owning side to null (unless already changed)
            if ($wholesalePriceDetail->getWholesalePrice() === $this) {
                $wholesalePriceDetail->setWholesalePrice(null);
            }
        }

        return $this;
    }
}
