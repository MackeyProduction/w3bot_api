<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:43
 */

namespace App\Interfaces;

/**
 * Interface ILayoutEngine
 * @package App\Interfaces
 */
interface ILayoutEngine
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
