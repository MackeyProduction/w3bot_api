<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperatingSystemRepository")
 */
class OperatingSystem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OperatingSystemName", inversedBy="operatingSystems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operatingSystemName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAgent", mappedBy="operatingSystem")
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

    public function getOperatingSystemName(): ?OperatingSystemName
    {
        return $this->operatingSystemName;
    }

    public function setOperatingSystemName(?OperatingSystemName $operatingSystemName): self
    {
        $this->operatingSystemName = $operatingSystemName;

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
            $userAgent->setOperatingSystem($this);
        }

        return $this;
    }

    public function removeUserAgent(UserAgent $userAgent): self
    {
        if ($this->userAgents->contains($userAgent)) {
            $this->userAgents->removeElement($userAgent);
            // set the owning side to null (unless already changed)
            if ($userAgent->getOperatingSystem() === $this) {
                $userAgent->setOperatingSystem(null);
            }
        }

        return $this;
    }
}
