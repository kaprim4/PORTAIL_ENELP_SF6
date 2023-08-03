<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use App\Trait\DateTimeTrait;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ORM\Table(name: '`session`')]
#[ORM\HasLifecycleCallbacks]
class Session
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $os = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imei = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $id_support = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $buildVersion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $versionName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MacWlanAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MacEthAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ipAddressV4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ipAddressV6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: [
        "default" => "CURRENT_TIMESTAMP"
    ])]
    private ?DateTimeImmutable $loginAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(?string $os): self
    {
        $this->os = $os;

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

    public function getIdSupport(): ?string
    {
        return $this->id_support;
    }

    public function setIdSupport(?string $id_support): self
    {
        $this->id_support = $id_support;

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

    public function getVersionName(): ?string
    {
        return $this->versionName;
    }

    public function setVersionName(?string $versionName): self
    {
        $this->versionName = $versionName;

        return $this;
    }

    public function getMacWlanAddress(): ?string
    {
        return $this->MacWlanAddress;
    }

    public function setMacWlanAddress(?string $MacWlanAddress): self
    {
        $this->MacWlanAddress = $MacWlanAddress;

        return $this;
    }

    public function getMacEthAddress(): ?string
    {
        return $this->MacEthAddress;
    }

    public function setMacEthAddress(?string $MacEthAddress): self
    {
        $this->MacEthAddress = $MacEthAddress;

        return $this;
    }

    public function getIpAddressV4(): ?string
    {
        return $this->ipAddressV4;
    }

    public function setIpAddressV4(?string $ipAddressV4): self
    {
        $this->ipAddressV4 = $ipAddressV4;

        return $this;
    }

    public function getIpAddressV6(): ?string
    {
        return $this->ipAddressV6;
    }

    public function setIpAddressV6(?string $ipAddressV6): self
    {
        $this->ipAddressV6 = $ipAddressV6;

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

    public function getLoginAt(): ?DateTimeImmutable
    {
        return $this->loginAt;
    }

    public function setLoginAt(?DateTimeImmutable $loginAt): self
    {
        $this->loginAt = $loginAt;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }
}
