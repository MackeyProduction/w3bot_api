<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 22:32
 */

namespace App\Interfaces;

/**
 * Interface ISoftware
 * @package App\Interfaces
 */
interface ISoftware
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

    /**
     * @return null|string
     */
    public function getLeName(): ?string;

    /**
     * @return null|string
     */
    public function getLeVersion(): ?string;
}
