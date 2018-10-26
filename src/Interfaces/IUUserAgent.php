<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 25.10.2018
 * Time: 22:24
 */

namespace App\Interfaces;

/**
 * Interface IUUserAgent
 * @package App\Interfaces
 */
interface IUUserAgent
{
    /**
     * @return IUser
     */
    public function getUser();

    /**
     * @return IUserAgent
     */
    public function getUserAgent();
}
