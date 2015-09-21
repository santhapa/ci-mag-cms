<?php
namespace comment\models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Entity
* @ORM\Table(name="mag_comments")
*/
class Comment
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	*@ORM\Column(type="text", name="`content`", nullable=false)
	**/
	protected $content;

	/**
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="commented_at", type="datetime")
    */
    protected $commentedAt;

    /**
    * @Gedmo\Timestampable(on="update")
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    */
    protected $updatedAt;

/*====================================================================================*/
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $parent;
/*======================================================================================*/

	/**
	*@ORM\ManyToOne(targetEntity="post\models\Post", inversedBy="comments")
	*@ORM\JoinColumn(nullable=true, onDelete="CASCADE")
	**/
	protected $post;

	/**
	*@ORM\ManyToOne(targetEntity="user\models\User", inversedBy="comments")
	*@ORM\JoinColumn(nullable=true, onDelete="SET NULL")
	**/
	protected $user;

	public function __construct() {
        $this->children = new ArrayCollection();
    }

	public function getId()
	{
		return $this->id;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setCommentedAt($date)
    {
       $this->commentedAt = $date;
    }

    public function getCommentedAt()
    {
        return $this->commentedAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setParent(Comment $cmt)
    {
    	$this->parent = $cmt;
    }

    public function getParent()
    {
    	return $this->parent;
    }

    public function setChildren(Comment $id)
    {
    	$this->children = $id;
    }

    public function getChildren()
    {
    	return $this->children;
    }

	public function setUser(\user\models\User $user)
    {
        // $user->addComment($this);
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setPost(\post\models\Post $post)
    {
        // $post->addComment($this);
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }		

}

?>