<?php

namespace App\Entity;

use App\Interfaces\IOperatingSystem;
use App\Interfaces\ISoftware;
use App\Interfaces\IUser;
use App\Interfaces\IUserAgent;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAgentRepository")
 */
class UserAgent implements IUserAgent
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
    private $osId;

    /**
     * @ORM\Column(type="integer")
     */
    private $sId;

    /**
     * @ORM\ManyToOne(targetEntity="OperatingSystem")
     * @ORM\JoinColumn(name="os_id", referencedColumnName="id")
     */
    private $operatingSystem;

    /**
     * @ORM\ManyToOne(targetEntity="Software")
     * @ORM\JoinColumn(name="s_id", referencedColumnName="id")
     */
    private $software;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return IOperatingSystem
     */
    public function getOperatingSystem()
    {
        return $this->operatingSystem;
    }

    /**
     * @return ISoftware
     */
    public function getSoftware()
    {
        return $this->software;
    }
}
