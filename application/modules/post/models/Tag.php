<?php

namespace post\models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Table(name="mag_tags")
* @ORM\Entity
*/
class Tag
{
    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $name;

    /**
    * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags", cascade={"persist"})
    **/
    protected $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }
  
    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }

    public function getPosts()
    {
        return $this->posts;
    }
}
