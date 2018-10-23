<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 23.10.2018
 * Time: 21:42
 */
namespace App\Interfaces;

use \Symfony\Component\Security\Core\User\UserInterface;

interface IUser extends UserInterface
{
    public function getId(): ?int;
    public function getUsername(): ?string;
    public function getPassword(): ?string;
    public function getEmail(): ?string;
    public function getRegisterDate(): ?\DateTimeInterface;
}