<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 23.10.2018
 * Time: 21:42
 */
namespace App\Interfaces;

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
}
