<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:40
 */

namespace App\Interfaces;

/**
 * Interface ISoftwareName
 * @package App\Interfaces
 */
interface ISoftwareName
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