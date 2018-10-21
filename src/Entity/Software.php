<?php

namespace App\Entity;

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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $le_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $le_version;

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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getLeName(): ?string
    {
        return $this->le_name;
    }

    public function setLeName(string $le_name): self
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
}
