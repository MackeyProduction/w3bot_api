<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UPRepository")
 */
class UP
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $uId;

    /**
     * @ORM\Column(type="integer")
     */
    private $pId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUId(): ?int
    {
        return $this->uId;
    }

    public function setUId(int $uId): self
    {
        $this->uId = $uId;

        return $this;
    }

    public function getPId(): ?int
    {
        return $this->pId;
    }

    public function setPId(int $pId): self
    {
        $this->pId = $pId;

        return $this;
    }
}
