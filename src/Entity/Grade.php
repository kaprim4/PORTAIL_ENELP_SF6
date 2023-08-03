<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`grade`')]
#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: true)]
    private ?GradeCategory $gradeCategory = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $ProductCode = null;

    #[ORM\ManyToMany(targetEntity: GasStation::class, mappedBy: 'gradeList')]
    private Collection $gasStations;

    #[ORM\OneToMany(mappedBy: 'grade', targetEntity: PriceRow::class)]
    private Collection $priceRows;

    #[ORM\OneToMany(mappedBy: 'grade', targetEntity: ActualPrice::class)]
    private Collection $actualPrices;

    #[ORM\OneToMany(mappedBy: 'grade', targetEntity: WholesalePriceDetail::class)]
    private Collection $wholesalePriceDetails;

    public function __construct()
    {
        $this->gasStations = new ArrayCollection();
        $this->priceRows = new ArrayCollection();
        $this->actualPrices = new ArrayCollection();
        $this->wholesalePriceDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGradeCategory(): ?GradeCategory
    {
        return $this->gradeCategory;
    }

    public function setGradeCategory(?GradeCategory $gradeCategory): void
    {
        $this->gradeCategory = $gradeCategory;
    }


    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getProductCode(): ?string
    {
        return $this->ProductCode;
    }

    public function setProductCode(string $ProductCode): self
    {
        $this->ProductCode = $ProductCode;
        return $this;
    }

    /**
     * @return Collection<int, GasStation>
     */
    public function getGasStations(): Collection
    {
        return $this->gasStations;
    }

    public function addGasStation(GasStation $gasStation): self
    {
        if (!$this->gasStations->contains($gasStation)) {
            $this->gasStations->add($gasStation);
            $gasStation->addGradeList($this);
        }

        return $this;
    }

    public function removeGasStation(GasStation $gasStation): self
    {
        if ($this->gasStations->removeElement($gasStation)) {
            $gasStation->removeGradeList($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PriceRow>
     */
    public function getPriceRows(): Collection
    {
        return $this->priceRows;
    }

    public function addPriceRow(PriceRow $priceRow): self
    {
        if (!$this->priceRows->contains($priceRow)) {
            $this->priceRows->add($priceRow);
            $priceRow->setGrade($this);
        }

        return $this;
    }

    public function removePriceRow(PriceRow $priceRow): self
    {
        if ($this->priceRows->removeElement($priceRow)) {
            // set the owning side to null (unless already changed)
            if ($priceRow->getGrade() === $this) {
                $priceRow->setGrade(null);
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
            $actualPrice->setGrade($this);
        }

        return $this;
    }

    public function removeActualPrice(ActualPrice $actualPrice): self
    {
        if ($this->actualPrices->removeElement($actualPrice)) {
            // set the owning side to null (unless already changed)
            if ($actualPrice->getGrade() === $this) {
                $actualPrice->setGrade(null);
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
            $wholesalePriceDetail->setGrade($this);
        }

        return $this;
    }

    public function removeWholesalePriceDetail(WholesalePriceDetail $wholesalePriceDetail): self
    {
        if ($this->wholesalePriceDetails->removeElement($wholesalePriceDetail)) {
            // set the owning side to null (unless already changed)
            if ($wholesalePriceDetail->getGrade() === $this) {
                $wholesalePriceDetail->setGrade(null);
            }
        }

        return $this;
    }
}
