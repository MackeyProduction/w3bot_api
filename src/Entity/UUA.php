<?php

namespace App\Entity;

use App\Interfaces\IUser;
use App\Interfaces\IUserAgent;
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

    /**
     * @ORM\ManyToOne(targetEntity="UserAgent")
     * @ORM\JoinColumn(name="ua_id", referencedColumnName="id")
     */
    private $userAgent;

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

    public function getUaId(): ?int
    {
        return $this->uaId;
    }

    public function setUaId(int $uaId): self
    {
        $this->uaId = $uaId;

        return $this;
    }

    /**
     * @return IUserAgent
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return IUser
     */
    public function getUser()
    {
        return $this->user;
    }
}
