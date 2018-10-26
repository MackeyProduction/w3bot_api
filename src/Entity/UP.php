<?php

namespace App\Entity;

use App\Interfaces\IProxy;
use App\Interfaces\IUProxy;
use App\Interfaces\IUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UPRepository")
 */
class UP implements IUProxy
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

    /**
     * @ORM\ManyToOne(targetEntity="Proxy")
     * @ORM\JoinColumn(name="p_id", referencedColumnName="id")
     */
    private $proxy;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="u_id", referencedColumnName="id")
     */
    private $user;

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

    /**
     * @return IProxy
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @return IUser
     */
    public function getUser()
    {
        return $this->user;
    }
}
