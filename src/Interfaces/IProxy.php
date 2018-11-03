<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 21:01
 */

namespace App\Interfaces;

/**
 * Interface IProxy
 * @package App\Interfaces
 */
interface IProxy
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIP();

    /**
     * @return int
     */
    public function getPort();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getPassword();
}
