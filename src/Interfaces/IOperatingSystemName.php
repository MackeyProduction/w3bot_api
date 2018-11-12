<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:15
 */

namespace App\Interfaces;

/**
 * Interface IOperatingSystemName
 * @package App\Interfaces
 */
interface IOperatingSystemName
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return null|string
     */
    public function getName(): ?string;
}