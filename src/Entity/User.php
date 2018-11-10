<?php

namespace App\Entity;

use App\Interfaces\IUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements IUser
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

    private $plainPassword;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registerDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rank", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rank;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Proxy", inversedBy="users")
     */
    private $up;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserAgent", inversedBy="users")
     */
    private $uua;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Token", mappedBy="user")
     */
    private $tokens;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LoginAttempts", mappedBy="user")
     */
    private $loginAttempts;

    public function __construct()
    {
        $this->up = new ArrayCollection();
        $this->uua = new ArrayCollection();
        $this->tokens = new ArrayCollection();
        $this->loginAttempts = new ArrayCollection();
    }

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

    public function getRegisterDate(): ?\DateTime
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTime $registerDate): self
    {
        $this->registerDate = $registerDate;

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

    public function getRank(): ?Rank
    {
        return $this->rank;
    }

    public function setRank(?Rank $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return Collection|Proxy[]
     */
    public function getUp(): Collection
    {
        return $this->up;
    }

    public function addUp(Proxy $up): self
    {
        if (!$this->up->contains($up)) {
            $this->up[] = $up;
        }

        return $this;
    }

    public function removeUp(Proxy $up): self
    {
        if ($this->up->contains($up)) {
            $this->up->removeElement($up);
        }

        return $this;
    }

    /**
     * @return Collection|UserAgent[]
     */
    public function getUua(): Collection
    {
        return $this->uua;
    }

    public function addUua(UserAgent $uua): self
    {
        if (!$this->uua->contains($uua)) {
            $this->uua[] = $uua;
        }

        return $this;
    }

    public function removeUua(UserAgent $uua): self
    {
        if ($this->uua->contains($uua)) {
            $this->uua->removeElement($uua);
        }

        return $this;
    }

    /**
     * @return Collection|Token[]
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function addToken(Token $token): self
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens[] = $token;
            $token->setUser($this);
        }

        return $this;
    }

    public function removeToken(Token $token): self
    {
        if ($this->tokens->contains($token)) {
            $this->tokens->removeElement($token);
            // set the owning side to null (unless already changed)
            if ($token->getUser() === $this) {
                $token->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LoginAttempts[]
     */
    public function getLoginAttempts(): Collection
    {
        return $this->loginAttempts;
    }

    public function addLoginAttempt(LoginAttempts $loginAttempt): self
    {
        if (!$this->loginAttempts->contains($loginAttempt)) {
            $this->loginAttempts[] = $loginAttempt;
            $loginAttempt->setUser($this);
        }

        return $this;
    }

    public function removeLoginAttempt(LoginAttempts $loginAttempt): self
    {
        if ($this->loginAttempts->contains($loginAttempt)) {
            $this->loginAttempts->removeElement($loginAttempt);
            // set the owning side to null (unless already changed)
            if ($loginAttempt->getUser() === $this) {
                $loginAttempt->setUser(null);
            }
        }

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
