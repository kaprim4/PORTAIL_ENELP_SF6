<?php

namespace App\Entity;

use App\Repository\PriceStatisticRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceStatisticRepository::class)]
#[ORM\Table(name: '`price_statistic`')]
#[ORM\HasLifecycleCallbacks]
class PriceStatistic
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'priceStatistics', targetEntity: Price::class)]
    private Collection $prices;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ipAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $buildVersion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $webPlateform = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idSupport = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imei = null;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(?Price $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function getBuildVersion(): ?string
    {
        return $this->buildVersion;
    }

    public function setBuildVersion(?string $buildVersion): self
    {
        $this->buildVersion = $buildVersion;
        return $this;
    }

    public function getWebPlateform(): ?string
    {
        return $this->webPlateform;
    }

    public function setWebPlateform(?string $webPlateform): self
    {
        $this->webPlateform = $webPlateform;
        return $this;
    }

    public function getIdSupport(): ?string
    {
        return $this->idSupport;
    }

    public function setIdSupport(?string $idSupport): self
    {
        $this->idSupport = $idSupport;
        return $this;
    }

    public function getImei(): ?string
    {
        return $this->imei;
    }

    public function setImei(?string $imei): self
    {
        $this->imei = $imei;
        return $this;
    }

    /**
     * @return Collection<int, Price>
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices->add($price);
            $price->setPriceStatistics($this);
        }
        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->removeElement($price)) {
            // set the owning side to null (unless already changed)
            if ($price->getPriceStatistics() === $this) {
                $price->setPriceStatistics(null);
            }
        }
        return $this;
    }
}
