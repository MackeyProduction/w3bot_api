<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 22:46
 */

namespace App\Interfaces;

/**
 * Interface ISoftwareExtras
 * @package App\Interfaces
 */
interface ISoftwareExtras
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return null|string
     */
    public function getInfo(): ?string;
}
