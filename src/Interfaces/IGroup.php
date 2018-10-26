<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 21:46
 */

namespace App\Interfaces;

/**
 * Interface IGroup
 * @package App\Interfaces
 */
interface IGroup
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
