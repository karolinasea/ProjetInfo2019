<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"producer"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProducerRepository")
 */
class Producer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("producer")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups("producer")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @Groups("producer")
     * @ORM\OneToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @Groups("producer")
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $latitude;

    /**
     * @Groups("producer")
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $longitude;

    /**
     * @Groups("producer")
     * @ORM\OneToMany(targetEntity="App\Entity\Beverage", mappedBy="producer")
     */
    private $beverages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wine", mappedBy="producer")
     */
    private $wines;

    /**
     * @Groups("producer")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    public function __construct()
    {
        $this->beverages = new ArrayCollection();
        $this->wines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

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
     * @return Collection|Beverage[]
     */
    public function getBeverages(): Collection
    {
        return $this->beverages;
    }

    public function addBeverage(Beverage $beverage): self
    {
        if (!$this->beverages->contains($beverage)) {
            $this->beverages[] = $beverage;
            $beverage->setProducer($this);
        }

        return $this;
    }

    public function removeBeverage(Beverage $beverage): self
    {
        if ($this->beverages->contains($beverage)) {
            $this->beverages->removeElement($beverage);
            // set the owning side to null (unless already changed)
            if ($beverage->getProducer() === $this) {
                $beverage->setProducer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Wine[]
     */
    public function getWines(): Collection
    {
        return $this->wines;
    }

    public function addWine(Wine $wine): self
    {
        if (!$this->wines->contains($wine)) {
            $this->wines[] = $wine;
            $wine->setProducer($this);
        }

        return $this;
    }

    public function removeWine(Wine $wine): self
    {
        if ($this->wines->contains($wine)) {
            $this->wines->removeElement($wine);
            // set the owning side to null (unless already changed)
            if ($wine->getProducer() === $this) {
                $wine->setProducer(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->name;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }
}
