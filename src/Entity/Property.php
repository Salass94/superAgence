<?php

namespace App\Entity;

use App\Entity\Image;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 * @ORM\Table(name="properties")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Property
{
    use Timestampable;

    const TYPE = [
        '1' => 'Maison',
        '2' => 'Appartement'
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;


    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message =" Ce champs est ne peut pas etre vide");
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $area;

    /**
     * @ORM\Column(type="integer")
     */
    private $room;

    /**
     * @ORM\Column(type="integer")
     */
    private $bedroom;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $swimming_pool;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $garden;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $air_conditioner;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $terrace;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $garage;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="property",
     *  orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }
 

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(int $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getBedroom(): ?int
    {
        return $this->bedroom;
    }

    public function setBedroom(int $bedroom): self
    {
        $this->bedroom = $bedroom;

        return $this;
    }

    public function getType(): ?int
    {
        if(!$this->type === null){

            return $this::TYPE[$this->type];
        }
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSwimmingPool(): ?bool
    {
        return $this->swimming_pool;
    }

    public function setSwimmingPool(?bool $swimming_pool): self
    {
        $this->swimming_pool = $swimming_pool;

        return $this;
    }

    public function getGarden(): ?bool
    {
        return $this->garden;
    }

    public function setGarden(?bool $garden): self
    {
        $this->garden = $garden;

        return $this;
    }

    public function getAirConditioner(): ?bool
    {
        return $this->air_conditioner;
    }

    public function setAirConditioner(?bool $air_conditioner): self
    {
        $this->air_conditioner = $air_conditioner;

        return $this;
    }

    public function getTerrace(): ?bool
    {
        return $this->terrace;
    }

    public function setTerrace(?bool $terrace): self
    {
        $this->terrace = $terrace;

        return $this;
    }

    public function getGarage(): ?int
    {
        return $this->garage;
    }

    public function setGarage(?int $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProperty($this);
        }    
        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProperty() === $this) {
                $image->setProperty(null);
            }
        }

        return $this;
    }
}
