<?php

namespace App\Entity;

use App\Interfaces\ISoftware;
use App\Interfaces\ISoftwareExtras;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SoftwareRepository")
 */
class Software implements ISoftware
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
    private $snId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\Column(type="integer")
     */
    private $leId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $le_version;

    /**
     * @ORM\Column(type="integer")
     */
    private $seId;

    /**
     * @ORM\ManyToOne(targetEntity="SoftwareName")
     * @ORM\JoinColumn(name="sn_id", referencedColumnName="id")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="LayoutEngine")
     * @ORM\JoinColumn(name="le_id", referencedColumnName="id")
     */
    private $le_name;

    /**
     * @ORM\ManyToOne(targetEntity="SoftwareExtras")
     * @ORM\JoinColumn(name="se_id", referencedColumnName="id")
     */
    private $extras;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?SoftwareName
    {
        return $this->name;
    }

    public function setName(?SoftwareName $name): self
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

    public function getLeName(): ?LayoutEngine
    {
        return $this->le_name;
    }

    public function setLeName(LayoutEngine $le_name): self
    {
        $this->le_name = $le_name;

        return $this;
    }

    public function getLeVersion(): ?string
    {
        return $this->le_version;
    }

    public function setLeVersion(string $le_version): self
    {
        $this->le_version = $le_version;

        return $this;
    }

    public function getSnId(): ?int
    {
        return $this->snId;
    }

    public function setSnId($snId): self
    {
        $this->snId = $snId;

        return $this;
    }

    public function getLeId(): ?int
    {
        return $this->leId;
    }

    public function setLeId($leId): self
    {
        $this->leId = $leId;

        return $this;
    }

    public function getSeId(): ?int
    {
        return $this->seId;
    }

    public function setSeId($seId): self
    {
        $this->seId = $seId;

        return $this;
    }

    /**
     * @return ISoftwareExtras
     */
    public function getExtras()
    {
        return $this->extras;
    }
}
