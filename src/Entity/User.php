<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registerDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $gId;

    /**
     * @ORM\Column(type="integer")
     */
    private $sId;

    /**
     * @ORM\Column(type="integer")
     */
    private $pId;

    /**
     * @ORM\Column(type="integer")
     */
    private $uaId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTimeInterface $registerDate): self
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getGroupId(): ?int
    {
        return $this->gId;
    }

    public function setGroupId(int $gId): self
    {
        $this->gId = $gId;

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

    public function getPId(): ?int
    {
        return $this->pId;
    }

    public function setPId(int $pId): self
    {
        $this->pId = $pId;

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
}
