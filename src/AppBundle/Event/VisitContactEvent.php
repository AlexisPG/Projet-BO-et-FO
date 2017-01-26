<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 26/01/17
 * Time: 09:47
 */

namespace AppBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class VisitContactEvent extends Event
{
    // On stock l'ip
    private $ip;

    /**
     * VisitContactEvent constructor.
     * @param $ip
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

}