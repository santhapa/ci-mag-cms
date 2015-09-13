<?php
namespace demo\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="demo_post")
 */
class Post
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
     */
    private $id;

	 /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    public function getId(){
    	return $this->id;
    }

    public function setTitle($t){
    	$this->title = $t;
    }

    public function getTitle()
    {
    	return $this->title;
    }
}