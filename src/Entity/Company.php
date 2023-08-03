<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`company`')]
#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: GasStation::class)]
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

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

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
            $gasStation->setCompany($this);
        }

        return $this;
    }

    public function removeGasStation(GasStation $gasStation): self
    {
        if ($this->gasStations->removeElement($gasStation)) {
            // set the owning side to null (unless already changed)
            if ($gasStation->getCompany() === $this) {
                $gasStation->setCompany(null);
            }
        }

        return $this;
    }
}
