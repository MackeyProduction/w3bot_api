<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 26.10.2018
 * Time: 21:26
 */

namespace App\Interfaces;

/**
 * Interface IUProxy
 * @package App\Interfaces
 */
interface IUProxy
{
    /**
     * @return IProxy
     */
    public function getProxy();

    /**
     * @return IUser
     */
    public function getUser();
}
