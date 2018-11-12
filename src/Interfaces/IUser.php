<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 23.10.2018
 * Time: 21:42
 */
namespace App\Interfaces;

use App\Entity\Proxy;
use App\Entity\Rank;
use App\Entity\UserAgent;
use Doctrine\Common\Collections\Collection;
use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface IUser
 * @package App\Interfaces
 */
interface IUser
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return null|string
     */
    public function getUsername(): ?string;

    /**
     * @return null|string
     */
    public function getPassword(): ?string;

    /**
     * @return null|string
     */
    public function getPlainPassword(): ?string;

    /**
     * @return null|string
     */
    public function getEmail(): ?string;

    /**
     * @return null|\DateTime
     */
    public function getRegisterDate(): ?\DateTime;

    /**
     * @return Rank|null
     */
    public function getRank(): ?Rank;

    /**
     * @return Collection|UserAgent[]
     */
    public function getUua(): Collection;

    /**
     * @return Collection|Proxy[]
     */
    public function getUp(): Collection;
}
