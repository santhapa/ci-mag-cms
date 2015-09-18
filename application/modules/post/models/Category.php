<?php

namespace post\models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Table(name="mag_categories")
* @ORM\Entity
*/
class Category
{
    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=255, name="`name`", nullable=false)
    */
    protected $name;

    /**
    * slug of the name field for retaining
    * @Gedmo\Slug(fields={"name"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $slug;

    /**
    * @ORM\ManyToMany(targetEntity="Post", mappedBy="categories", cascade={"persist"})
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
    	$this->name = ucfirst(strtolower($name));
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

    public function addPost(Post $post)
    {
        // $post->addCategory($this);
        $this->posts[] = $post;
    }

    public function getPosts()
    {
        return $this->posts;
    }
}
