<?php

namespace App\Entity;

use App\Interfaces\IOperatingSystem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperatingSystemRepository")
 */
class OperatingSystem implements IOperatingSystem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $osnId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\ManyToOne(targetEntity="OperatingSystemName")
     * @ORM\JoinColumn(name="osn_id", referencedColumnName="id")
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?OperatingSystemName
    {
        return $this->name;
    }

    public function setName(OperatingSystemName $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getOsnId(): ?int
    {
        return $this->osnId;
    }

    public function setOsnId($osnId): self
    {
        $this->osnId = $osnId;

        return $this;
    }
}
