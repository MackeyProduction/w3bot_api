<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAgentRepository")
 */
class UserAgent
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
    private $osId;

    /**
     * @ORM\Column(type="integer")
     */
    private $sId;

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

    public function getOsId(): ?int
    {
        return $this->osId;
    }

    public function setOsId(int $osId): self
    {
        $this->osId = $osId;

        return $this;
    }

    public function getSId(): ?int
    {
        return $this->sId;
    }

    public function setSId(int $sId): self
    {
        $this->sId = $sId;

        return $this;
    }
}
