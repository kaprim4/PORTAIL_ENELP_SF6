<?php

namespace App\Entity;

use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CityRepository;

#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`city`')]
#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Region $region = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: GasStation::class)]
    private Collection $gasStations;

    public function __construct()
    {
        $this->gasStations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

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
            $gasStation->setCity($this);
        }

        return $this;
    }

    public function removeGasStation(GasStation $gasStation): self
    {
        if ($this->gasStations->removeElement($gasStation)) {
            // set the owning side to null (unless already changed)
            if ($gasStation->getCity() === $this) {
                $gasStation->setCity(null);
            }
        }

        return $this;
    }
}
