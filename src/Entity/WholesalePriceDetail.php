<?php

namespace App\Entity;

use App\Repository\WholesalePriceDetailRepository;
use App\Trait\DateTimeTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WholesalePriceDetailRepository::class)]
#[ORM\Table(name: '`wholesale_price_detail`')]
#[ORM\HasLifecycleCallbacks]
class WholesalePriceDetail
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'wholesalePriceDetails')]
    #[ORM\JoinColumn(nullable: true)]
    private ?WholesalePrice $wholesalePrice = null;

    #[ORM\ManyToOne(inversedBy: 'wholesalePriceDetails')]
    #[ORM\JoinColumn(nullable: true)]
    private ?GasStation $gasStation = null;

    #[ORM\ManyToOne(inversedBy: 'wholesalePriceDetails')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Grade $grade = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gasStationFromFile = null;

    #[ORM\Column(options: ["default" => 0])]
    private ?int $preImported = null;

    #[ORM\Column(options: ["default" => 0])]
    private ?int $reImported = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWholesalePrice(): ?WholesalePrice
    {
        return $this->wholesalePrice;
    }

    public function setWholesalePrice(?WholesalePrice $wholesalePrice): self
    {
        $this->wholesalePrice = $wholesalePrice;

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

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getGasStationFromFile(): ?string
    {
        return $this->gasStationFromFile;
    }

    public function setGasStationFromFile(?string $gasStationFromFile): self
    {
        $this->gasStationFromFile = $gasStationFromFile;

        return $this;
    }

    public function getPreImported(): ?int
    {
        return $this->preImported;
    }

    public function setPreImported(?int $preImported): self
    {
        $this->preImported = $preImported;

        return $this;
    }

    public function getReImported(): ?int
    {
        return $this->reImported;
    }

    public function setReImported(?int $reImported): self
    {
        $this->reImported = $reImported;

        return $this;
    }
}
