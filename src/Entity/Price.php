<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use App\Repository\RegionRepository;
use App\Trait\DateTimeTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: PriceRepository::class)]
#[ORM\Table(name: '`price`')]
#[ORM\HasLifecycleCallbacks]
class Price
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'prices')]
    #[ORM\JoinColumn(nullable: true)]
    private ?GasStation $gasStation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $eventNumHO = null;

    #[ORM\OneToMany(mappedBy: 'price', targetEntity: PriceRow::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Collection $priceRows = null;

    #[ORM\ManyToOne(inversedBy: 'prices')]
    #[ORM\JoinColumn(nullable: true)]
    private ?PriceStatistic $priceStatistics = null;

    #[ORM\ManyToOne(inversedBy: 'prices')]
    #[ORM\JoinColumn(nullable: true)]
    private ?PriceStatus $priceStatus = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: [
        "default" => "CURRENT_TIMESTAMP"
    ])]
    private ?DateTimeImmutable $appliedAt = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        "default" => 0
    ])]
    private ?bool $isMailSent = null;

    public function __construct()
    {
        $this->priceRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|null
     */
    public function getPriceRows(): ?Collection
    {
        return $this->priceRows;
    }

    public function addPriceRow(?PriceRow $priceRow): self
    {
        if (!$this->priceRows->contains($priceRow)) {
            $this->priceRows->add($priceRow);
            $priceRow->setPrice($this);
        }
        return $this;
    }

    public function removePriceRow(?PriceRow $priceRow): self
    {
        if ($this->priceRows->removeElement($priceRow)) {
            // set the owning side to null (unless already changed)
            if ($priceRow->getPrice() === $this) {
                $priceRow->setPrice(null);
            }
        }
        return $this;
    }

    public function getAppliedAt(): ?\DateTimeImmutable
    {
        return $this->appliedAt;
    }

    public function setAppliedAt(\DateTimeImmutable $appliedAt): self
    {
        $this->appliedAt = $appliedAt;
        return $this;
    }

    public function getEventNumHO(): ?string
    {
        return $this->eventNumHO;
    }

    public function setEventNumHO(string $eventNumHO): self
    {
        $this->eventNumHO = $eventNumHO;
        return $this;
    }

    public function getPriceStatus(): ?PriceStatus
    {
        return $this->priceStatus;
    }

    /**
     * @param PriceStatus|null $priceStatus
     */
    public function setPriceStatus(?PriceStatus $priceStatus): void
    {
        $this->priceStatus = $priceStatus;
    }

    public function getPriceStatistics(): ?PriceStatistic
    {
        return $this->priceStatistics;
    }

    /**
     * @param PriceStatistic|null $priceStatistics
     */
    public function setPriceStatistics(?PriceStatistic $priceStatistics): void
    {
        $this->priceStatistics = $priceStatistics;
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
