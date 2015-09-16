<?php

namespace post\models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Table(name="mag_post_type")
* @ORM\Entity
*/
class PostType
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
    * slug of the name field for retaining
    * @Gedmo\Slug(fields={"name"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $slug;

    /**
    *@ORM\OneToMany(targetEntity="Post", mappedBy="postType")
    */
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
    	$this->name = strtolower($name);
    }

    public function getName()
    {
    	return $this->name;
    }
    
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
    	return $this->slug;
    }

    public function getPosts()
    {
        return $this->posts;
    }
}