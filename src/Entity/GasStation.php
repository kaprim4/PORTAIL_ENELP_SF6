<?php

namespace App\Entity;

use App\Repository\GasStationRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`gas_station`')]
#[ORM\Entity(repositoryClass: GasStationRepository::class)]
class GasStation
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeSap = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'gasStations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'gasStations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Supervisor $supervisor = null;

    #[ORM\ManyToOne(inversedBy: 'gasStations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?City $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zipCode = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\ManyToMany(targetEntity: Grade::class, inversedBy: 'gasStations')]
    private Collection $gradeList;

    #[ORM\OneToMany(mappedBy: 'gasStation', targetEntity: Price::class)]
    private Collection $prices;

    #[ORM\OneToMany(mappedBy: 'gasStation', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'gasStation', targetEntity: ActualPrice::class)]
    private Collection $actualPrices;

    #[ORM\OneToMany(mappedBy: 'gasStation', targetEntity: WholesalePriceDetail::class)]
    private Collection $wholesalePriceDetails;

    #[ORM\OneToMany(mappedBy: 'gasStation', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'gasStation', targetEntity: Claim::class)]
    private Collection $claims;

    public function __construct()
    {
        $this->gradeList = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->actualPrices = new ArrayCollection();
        $this->wholesalePriceDetails = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->claims = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupervisor(): ?Supervisor
    {
        return $this->supervisor;
    }

    public function setSupervisor(?Supervisor $supervisor): self
    {
        $this->supervisor = $supervisor;

        return $this;
    }

    public function getCodeSap(): ?string
    {
        return $this->codeSap;
    }

    public function setCodeSap(?string $codeSap): self
    {
        $this->codeSap = $codeSap;
        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;
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

    /**
     * @return Collection<int, Grade>
     */
    public function getGradeList(): Collection
    {
        return $this->gradeList;
    }

    public function addGradeList(Grade $gradeList): self
    {
        if (!$this->gradeList->contains($gradeList)) {
            $this->gradeList->add($gradeList);
        }

        return $this;
    }

    public function removeGradeList(Grade $gradeList): self
    {
        $this->gradeList->removeElement($gradeList);

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
            $price->setGasStation($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->removeElement($price)) {
            // set the owning side to null (unless already changed)
            if ($price->getGasStation() === $this) {
                $price->setGasStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setGasStation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getGasStation() === $this) {
                $user->setGasStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ActualPrice>
     */
    public function getActualPrices(): Collection
    {
        return $this->actualPrices;
    }

    public function addActualPrice(ActualPrice $actualPrice): self
    {
        if (!$this->actualPrices->contains($actualPrice)) {
            $this->actualPrices->add($actualPrice);
            $actualPrice->setGasStation($this);
        }

        return $this;
    }

    public function removeActualPrice(ActualPrice $actualPrice): self
    {
        if ($this->actualPrices->removeElement($actualPrice)) {
            // set the owning side to null (unless already changed)
            if ($actualPrice->getGasStation() === $this) {
                $actualPrice->setGasStation(null);
            }
        }

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
            $wholesalePriceDetail->setGasStation($this);
        }

        return $this;
    }

    public function removeWholesalePriceDetail(WholesalePriceDetail $wholesalePriceDetail): self
    {
        if ($this->wholesalePriceDetails->removeElement($wholesalePriceDetail)) {
            // set the owning side to null (unless already changed)
            if ($wholesalePriceDetail->getGasStation() === $this) {
                $wholesalePriceDetail->setGasStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setGasStation($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getGasStation() === $this) {
                $order->setGasStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Claim>
     */
    public function getClaims(): Collection
    {
        return $this->claims;
    }

    public function addClaim(Claim $claim): self
    {
        if (!$this->claims->contains($claim)) {
            $this->claims->add($claim);
            $claim->setGasStation($this);
        }

        return $this;
    }

    public function removeClaim(Claim $claim): self
    {
        if ($this->claims->removeElement($claim)) {
            // set the owning side to null (unless already changed)
            if ($claim->getGasStation() === $this) {
                $claim->setGasStation(null);
            }
        }

        return $this;
    }
}
