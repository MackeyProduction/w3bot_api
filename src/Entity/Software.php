<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SoftwareRepository")
 */
class Software
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
    private $version;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SoftwareExtras", inversedBy="softwares")
     */
    private $softwareExtras;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SoftwareName", inversedBy="softwares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $softwareName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LayoutEngine", inversedBy="softwares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $layoutEngine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LeVersion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAgent", mappedBy="software")
     */
    private $userAgents;

    public function __construct()
    {
        $this->userAgents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSoftwareExtras(): ?SoftwareExtras
    {
        return $this->softwareExtras;
    }

    public function setSoftwareExtras(?SoftwareExtras $softwareExtras): self
    {
        $this->softwareExtras = $softwareExtras;

        return $this;
    }

    public function getSoftwareName(): ?SoftwareName
    {
        return $this->softwareName;
    }

    public function setSoftwareName(?SoftwareName $softwareName): self
    {
        $this->softwareName = $softwareName;

        return $this;
    }

    public function getLayoutEngine(): ?LayoutEngine
    {
        return $this->layoutEngine;
    }

    public function setLayoutEngine(?LayoutEngine $layoutEngine): self
    {
        $this->layoutEngine = $layoutEngine;

        return $this;
    }

    public function getLeVersion(): ?string
    {
        return $this->LeVersion;
    }

    public function setLeVersion(string $LeVersion): self
    {
        $this->LeVersion = $LeVersion;

        return $this;
    }

    /**
     * @return Collection|UserAgent[]
     */
    public function getUserAgents(): Collection
    {
        return $this->userAgents;
    }

    public function addUserAgent(UserAgent $userAgent): self
    {
        if (!$this->userAgents->contains($userAgent)) {
            $this->userAgents[] = $userAgent;
            $userAgent->setSoftware($this);
        }

        return $this;
    }

    public function removeUserAgent(UserAgent $userAgent): self
    {
        if ($this->userAgents->contains($userAgent)) {
            $this->userAgents->removeElement($userAgent);
            // set the owning side to null (unless already changed)
            if ($userAgent->getSoftware() === $this) {
                $userAgent->setSoftware(null);
            }
        }

        return $this;
    }
}
