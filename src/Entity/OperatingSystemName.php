<?php

namespace App\Entity;

use App\Interfaces\IOperatingSystemName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperatingSystemNameRepository")
 */
class OperatingSystemName implements IOperatingSystemName
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OperatingSystem", mappedBy="operatingSystemName")
     */
    private $operatingSystems;

    public function __construct()
    {
        $this->operatingSystems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|OperatingSystem[]
     */
    public function getOperatingSystems(): Collection
    {
        return $this->operatingSystems;
    }

    public function addOperatingSystem(OperatingSystem $operatingSystem): self
    {
        if (!$this->operatingSystems->contains($operatingSystem)) {
            $this->operatingSystems[] = $operatingSystem;
            $operatingSystem->setOperatingSystemName($this);
        }

        return $this;
    }

    public function removeOperatingSystem(OperatingSystem $operatingSystem): self
    {
        if ($this->operatingSystems->contains($operatingSystem)) {
            $this->operatingSystems->removeElement($operatingSystem);
            // set the owning side to null (unless already changed)
            if ($operatingSystem->getOperatingSystemName() === $this) {
                $operatingSystem->setOperatingSystemName(null);
            }
        }

        return $this;
    }
}
