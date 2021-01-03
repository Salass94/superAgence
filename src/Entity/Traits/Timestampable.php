<?php

namespace App\Entity\Traits;


trait Timestampable
{

    /**
     *@ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"} )
     */
    private $createdAt;
    
    /**
     *@ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"} )
     */
    private $updatedAt;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->createdAt = $CreatedAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->updatedAt = $UpdatedAt;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
     public function updateTimeTamps()
     {
        if($this->getCreatedAt() === null)
        {
            $this->setCreatedAt(new \DateTimeImmutable);
        }

        $this->setUpdatedAt(new \DateTimeImmutable);
     }

}


?>