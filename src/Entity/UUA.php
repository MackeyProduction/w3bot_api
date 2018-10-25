<?php

namespace App\Entity;

use App\Interfaces\IUUserAgent;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UUARepository")
 */
class UUA implements IUUserAgent
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
    private $uaId;

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

    public function getUaId(): ?int
    {
        return $this->uaId;
    }

    public function setUaId(int $uaId): self
    {
        $this->uaId = $uaId;

        return $this;
    }
}
