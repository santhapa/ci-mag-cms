<?php

namespace models\Common;

use Doctrine\ORM\Mapping as ORM; 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @ORM\Entity
 * @ORM\Table(name="mag_sessions", 
 * 		indexes={@ORM\Index(name="timestamp", columns={"timestamp"})}
 * )
 */
class Sessions{
    
    /**
     * @ORM\Id 
     * @ORM\Column(type="string", length=40, nullable=false, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, nullable=false)
     */
    private $ip_address;

    /**
     * @ORM\Column(type="integer", length=10, nullable=false, options={"unsigned": true, "default": 0})
     */
    private $timestamp;

    /**
     * @ORM\Column(type="blob", nullable=false)
     */
    private $data;   
}