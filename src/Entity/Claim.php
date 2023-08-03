<?php

namespace App\Entity;

use App\Repository\ClaimRepository;
use App\Trait\DateTimeTrait;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ClaimRepository::class)]
#[ORM\Table(name: '`claim`')]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Claim
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'claims')]
    private ?GasStation $gasStation = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $audio = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: ["default" => null])]
    private ?string $imageName1 = null;
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $imageSize1 = null;
    #[Vich\UploadableField(mapping: 'claim_img', fileNameProperty: 'imageName1', size: 'imageSize1')]
    private ?File $imageFile1 = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: ["default" => null])]
    private ?string $imageName2 = null;
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $imageSize2 = null;
    #[Vich\UploadableField(mapping: 'claim_img', fileNameProperty: 'imageName2', size: 'imageSize2')]
    private ?File $imageFile2 = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: ["default" => null])]
    private ?string $imageName3 = null;
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $imageSize3 = null;
    #[Vich\UploadableField(mapping: 'claim_img', fileNameProperty: 'imageName3', size: 'imageSize3')]
    private ?File $imageFile3 = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: ["default" => null])]
    private ?string $imageName4 = null;
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $imageSize4 = null;
    #[Vich\UploadableField(mapping: 'claim_img', fileNameProperty: 'imageName4', size: 'imageSize4')]
    private ?File $imageFile4 = null;

    #[ORM\Column]
    private ?bool $isNewlyAdded = null;

    #[ORM\Column]
    private ?bool $isMailSent = null;

    #[ORM\ManyToOne(inversedBy: 'claims')]
    private ?ClaimStatus $claimStatus = null;

    #[ORM\ManyToOne(inversedBy: 'claims')]
    private ?ClaimStatistic $claimStatistic = null;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName1(): ?string
    {
        return $this->imageName1;
    }

    /**
     * @param string|null $imageName1
     */
    public function setImageName1(?string $imageName1): void
    {
        $this->imageName1 = $imageName1;
    }

    /**
     * @return File|null
     */
    public function getImageFile1(): ?File
    {
        return $this->imageFile1;
    }

    /**
     * @param File|null $imageFile1
     */
    public function setImageFile1(?File $imageFile1): void
    {
        $this->imageFile1 = $imageFile1;
        if (null !== $imageFile1) {
            $this->updatedAt = new DateTimeImmutable;
        }
    }

    /**
     * @return int|null
     */
    public function getImageSize1(): ?int
    {
        return $this->imageSize1;
    }

    /**
     * @param int|null $imageSize1
     */
    public function setImageSize1(?int $imageSize1): void
    {
        $this->imageSize1 = $imageSize1;
    }

    /**
     * @return string|null
     */
    public function getImageName2(): ?string
    {
        return $this->imageName2;
    }

    /**
     * @param string|null $imageName2
     */
    public function setImageName2(?string $imageName2): void
    {
        $this->imageName2 = $imageName2;
    }

    /**
     * @return File|null
     */
    public function getImageFile2(): ?File
    {
        return $this->imageFile2;
    }

    /**
     * @param File|null $imageFile2
     */
    public function setImageFile2(?File $imageFile2): void
    {
        $this->imageFile2 = $imageFile2;
        if (null !== $imageFile2) {
            $this->updatedAt = new DateTimeImmutable;
        }
    }

    /**
     * @return int|null
     */
    public function getImageSize2(): ?int
    {
        return $this->imageSize2;
    }

    /**
     * @param int|null $imageSize2
     */
    public function setImageSize2(?int $imageSize2): void
    {
        $this->imageSize2 = $imageSize2;
    }

    /**
     * @return string|null
     */
    public function getImageName3(): ?string
    {
        return $this->imageName3;
    }

    /**
     * @param string|null $imageName3
     */
    public function setImageName3(?string $imageName3): void
    {
        $this->imageName3 = $imageName3;
    }

    /**
     * @return File|null
     */
    public function getImageFile3(): ?File
    {
        return $this->imageFile3;
    }

    /**
     * @param File|null $imageFile3
     */
    public function setImageFile3(?File $imageFile3): void
    {
        $this->imageFile3 = $imageFile3;
        if (null !== $imageFile3) {
            $this->updatedAt = new DateTimeImmutable;
        }
    }

    /**
     * @return int|null
     */
    public function getImageSize3(): ?int
    {
        return $this->imageSize3;
    }

    /**
     * @param int|null $imageSize3
     */
    public function setImageSize3(?int $imageSize3): void
    {
        $this->imageSize3 = $imageSize3;
    }

    /**
     * @return string|null
     */
    public function getImageName4(): ?string
    {
        return $this->imageName4;
    }

    /**
     * @param string|null $imageName4
     */
    public function setImageName4(?string $imageName4): void
    {
        $this->imageName4 = $imageName4;
    }

    /**
     * @return File|null
     */
    public function getImageFile4(): ?File
    {
        return $this->imageFile4;
    }

    /**
     * @param File|null $imageFile4
     */
    public function setImageFile4(?File $imageFile4): void
    {
        $this->imageFile4 = $imageFile4;
        if (null !== $imageFile4) {
            $this->updatedAt = new DateTimeImmutable;
        }
    }

    /**
     * @return int|null
     */
    public function getImageSize4(): ?int
    {
        return $this->imageSize4;
    }

    /**
     * @param int|null $imageSize4
     */
    public function setImageSize4(?int $imageSize4): void
    {
        $this->imageSize4 = $imageSize4;
    }

    public function isIsNewlyAdded(): ?bool
    {
        return $this->isNewlyAdded;
    }

    public function setIsNewlyAdded(bool $isNewlyAdded): self
    {
        $this->isNewlyAdded = $isNewlyAdded;

        return $this;
    }

    public function isIsMailSent(): ?bool
    {
        return $this->isMailSent;
    }

    public function setIsMailSent(bool $isMailSent): self
    {
        $this->isMailSent = $isMailSent;

        return $this;
    }

    public function getClaimStatus(): ?ClaimStatus
    {
        return $this->claimStatus;
    }

    public function setClaimStatus(?ClaimStatus $claimStatus): self
    {
        $this->claimStatus = $claimStatus;

        return $this;
    }

    public function getClaimStatistic(): ?ClaimStatistic
    {
        return $this->claimStatistic;
    }

    public function setClaimStatistic(?ClaimStatistic $claimStatistic): self
    {
        $this->claimStatistic = $claimStatistic;

        return $this;
    }
}
