<?php

namespace App\Entity;

use App\Interfaces\IUserAgent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=255)
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Software", inversedBy="userAgents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $software;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OperatingSystem", inversedBy="userAgents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operatingSystem;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="uua")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgent(): ?string
    {
        return $this->agent;
    }

    public function setAgent(string $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getSoftware(): ?Software
    {
        return $this->software;
    }

    public function setSoftware(?Software $software): self
    {
        $this->software = $software;

        return $this;
    }

    public function getOperatingSystem(): ?OperatingSystem
    {
        return $this->operatingSystem;
    }

    public function setOperatingSystem(?OperatingSystem $operatingSystem): self
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addUua($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeUua($this);
        }

        return $this;
    }
}
