<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 22:32
 */

namespace App\Interfaces;

use App\Entity\LayoutEngine;
use App\Entity\SoftwareName;

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
     * @return null|SoftwareName
     */
    public function getName(): ?SoftwareName;

    /**
     * @return null|string
     */
    public function getVersion(): ?string;

    /**
     * @return null|LayoutEngine
     */
    public function getLeName(): ?LayoutEngine;

    /**
     * @return null|string
     */
    public function getLeVersion(): ?string;
}
