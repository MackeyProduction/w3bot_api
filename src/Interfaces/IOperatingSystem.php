<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 22:31
 */

namespace App\Interfaces;

/**
 * Interface IOperatingSystem
 * @package App\Interfaces
 */
interface IOperatingSystem
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @return null|string
     */
    public function getVersion(): ?string;
}
