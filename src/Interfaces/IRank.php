<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 21:46
 */

namespace App\Interfaces;

/**
 * Interface IRank
 * @package App\Interfaces
 */
interface IRank
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
