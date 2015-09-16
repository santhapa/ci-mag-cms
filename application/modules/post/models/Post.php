<?php
namespace post\models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Entity
* @ORM\Table(name="mag_posts")
*/
class Post
{
    const STATUS_DRAFT = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_TRASH = 3;
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	* @ORM\Column(type="string", name="`title`", nullable=false)
	*/
    protected $title;

    /**
	* @ORM\Column(type="text", name="`content`", nullable=false)
	*/
    protected $content;
    
    /**
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="created_at", type="datetime", nullable=true)
    */
    protected $createdAt;

    /**
    * @Gedmo\Timestampable(on="update")
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    */
    protected $updatedAt;

    /**
    * @ORM\ManyToOne(targetEntity="PostType", inversedBy="posts", cascade={"persist"})
    * @ORM\JoinColumn(name="post_type_id", referencedColumnName="id", onDelete="SET NULL")
    */
    protected $postType;

    /**
    * @ORM\Column(type="integer", name="`status`", nullable=false)
    **/
    protected $status = 2;

    /**
    * slug of the name field for retaining
    * @Gedmo\Slug(fields={"title"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $slug;

    // *
    // * @ORM\Column(type="string", length=255, name="featured_image")
    
    // protected $featuredImage;

    /**
    *@ORM\ManyToOne(targetEntity="user\models\User", inversedBy="posts")
    *@ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    protected $author;

    /**
    *@ORM\OneToMany(targetEntity="Comment", mappedBy="post")
    */
    protected $comments;

    /**
    * @ORM\ManyToMany(targetEntity="Category", inversedBy="posts")
    * @ORM\JoinTable(name="mag_post_category")
    **/
    protected $categories;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return  $this->content;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function saveToDraft()
    {
        $this->status = self::STATUS_DRAFT;
    }

    public function trash()
    {
        $this->status = self::STATUS_TRASH;
    }

    public function activate()
    {
        $this->status = STATUS_ACTIVE;
    }

    public function isActive()
    {
        return ($this->status == self::STATUS_ACTIVE) ? true : false;
    }

    public function isTrashed()
    {
        return ($this->status == self::STATUS_TRASH) ? true : false;
    }

    public function isDraft()
    {
        return ($this->status == self::STATUS_DRAFT) ? true : false;
    }

    public function setPostType($pt)
    {
        $this->postType = $pt;
    }

    public function getPostType()
    {
        return $this->postType;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setAuthor($author)
    {
        $author->addPost($this);
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function addComment($comment)
    {
        $comment->addPost($this);
        $this->comments[] = $comment;
    }

    public function getComments()
    {
        return $this->comments;
    }        

    public function addCategory(Category $cat)
    {
        $cat->addPost($this);
        $this->categories[] = $cat;
    }

    public function getCategory()
    {
        return $this->categories;
    }

    // public function getFeaturedImage()
    // {
    //     return $this->featuredImage;
    // }
    // public function setFeaturedImage($path)
    // {
    //     $this->featuredImage = $path;
    // }
}
