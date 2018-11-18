<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 20:20
 */

namespace App\Interfaces;

/**
 * Interface IUserAgent
 * @package App\Interfaces
 */
interface IUserAgent
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return IOperatingSystem
     */
    public function getOperatingSystem();

    /**
     * @return ISoftware
     */
    public function getSoftware();

    /**
     * @return null|string
     */
    public function getAgent(): ?string;
}
