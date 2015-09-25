<?php
namespace page\models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Entity
* @ORM\Table(name="mag_pages")
*/
class Page
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISH = 2;
    const STATUS_TRASH = 3;

    public static $statusTypes = array(
        self::STATUS_DRAFT => 'On Draft',
        self::STATUS_PUBLISH => 'Published',
        self::STATUS_TRASH => 'Trashed'
    );
    
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
    * @ORM\Column(type="boolean", name="`show_comments`", nullable=false)
    */
    protected $showComments;
    
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
    * @ORM\Column(type="integer", name="`status`", nullable=false)
    **/
    protected $status = 2;

    /**
    * slug of the name field for retaining
    * @Gedmo\Slug(fields={"title"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $slug;

    /**
    * @ORM\ManyToOne(targetEntity="media\models\Media")
    */
    protected $featuredImage;

    /**
    *@ORM\ManyToOne(targetEntity="user\models\User", inversedBy="pages")
    *@ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    protected $author;

    /**
    *@ORM\OneToMany(targetEntity="comment\models\Comment", mappedBy="page")
    */
    protected $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
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

    public function setShowComments($bool){
        if($bool)
        {
            $this->showComments = true;
        }else{
             $this->showComments = false;
        }
        
    }

    public function getShowComments()
    {
        return $this->showComments;
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

    public function publish()
    {
        $this->status = self::STATUS_PUBLISH;
    }

    public function isPublished()
    {
        return ($this->status == self::STATUS_PUBLISH) ? true : false;
    }

    public function isTrashed()
    {
        return ($this->status == self::STATUS_TRASH) ? true : false;
    }

    public function isDraft()
    {
        return ($this->status == self::STATUS_DRAFT) ? true : false;
    }

    public function setFeaturedImage(\media\models\Media $media)
    {
        $this->featuredImage = $media;
    }

    public function getFeaturedImage()
    {
        return $this->featuredImage ? $this->featuredImage->getSource() : '';
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setAuthor(\user\models\User $author)
    {
        $author->addPage($this);
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function addComment(\comment\models\Comment $comment)
    {
        // $comment->setPage($this);
        $this->comments[] = $comment;
    }

    public function getComments()
    {
        return $this->comments;
    }
}
