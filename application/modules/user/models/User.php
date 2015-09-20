<?php
namespace user\models;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

use user\models\Group;

/**
 * @ORM\Entity
 * @ORM\Table(name="mag_users")
 */
class User
{
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_BLOCK = 3;
    const STATUS_TRASH = 4;

    public static $status_types = array(
        self::STATUS_PENDING => 'Pending',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_BLOCK =>'Block',
        self::STATUS_TRASH =>'Trash',
    );

	/**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    // required information - login details

    /**
    * @ORM\Column(type="string", unique=true, nullable=false)
    */
    protected $username;

    /**
    * @ORM\Column(type="string", nullable=false)
    */
    protected $password;

    /**
    * @ORM\Column(type="string", unique=true, nullable=false)
    */
    protected $email;

    /**
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="created_at", type="datetime")
    */
    protected $createdAt;

    /**
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $status=1;

    //personal informations

    /**
    * @ORM\Column(name="firstname", type="string", length=100, nullable=false)
    */
    protected $firstname;

    /**
    * @ORM\Column(name="lastname", type="string", length=100, nullable=false)
    */
    protected $lastname;

    /**
    * @ORM\Column(name="date_of_birth", type="date", nullable=true)
    */
    protected $dateOfBirth;

    /**
    * @ORM\Column(name="gender", type="string", nullable=true)
    */
    protected $gender;

    /**
    * @ORM\Column(name="phone_number", type="string", nullable=true)
    */
    protected $phoneNumber;

    /**
    * @ORM\Column(name="mobile_number", type="string", nullable=true)
    */
    protected $mobileNumber;

    /**
    * @ORM\Column(name="address", type="string", length=255, nullable=true)
    */
    protected $address;

    /**
    * @ORM\Column(name="biography", type="text", length=255, nullable=true)
    */
    protected $biography;

    /**
    * @ORM\Column(name="website", type="string", length=100, nullable=true)
    */
    protected $website;

    //social informations
    /**
    * @ORM\Column(name="facebook_id", type="string",length=100, nullable=true)
    */
    protected $facebookId;

    /**
    * @ORM\Column(name="gplus_id", type="string",length=100, nullable=true)
    */
    protected $gplusId;

    /**
    * @ORM\Column(name="twitter_id", type="string",length=100, nullable=true)
    */
    protected $twitterId;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    protected $image;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    protected $token;

    /**
     * @ORM\ManyToOne(targetEntity="user\models\Group", inversedBy="users")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")
    **/
    protected $group;

    /**
    * @ORM\OneToMany(targetEntity="post\models\Post", mappedBy="author", cascade={"persist"})
    */
    protected $posts;

    /**
    *@ORM\OneToMany(targetEntity="post\models\Comment", mappedBy="user")
    */
    protected $comments;

    public function __construct()
    {
        parent::__construct();
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setCreatedAt($datetime)
    {
        $this->createdAt = $datetime;    
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setStatus($stat)
    {
        $this->status = $stat;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function trash()
    {
        $this->status = self::STATUS_TRASH;
    }

    public function deactivate()
    {
        $this->status = self::STATUS_BLOCK;
    }

    public function isActive()
    {
        return ($this->status == self::STATUS_ACTIVE)? TRUE : FALSE;
    }

    public function isTrashed()
    {
        return ($this->status == self::STATUS_TRASH)? TRUE : FALSE;
    }

    public function setFirstname($fname)
    {
        $this->firstname = ucfirst($fname);
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = ucfirst($lastname);
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getName()
    {
        if($this->firstname || $this->lastname)
        {
            return trim($this->firstname." ".$this->lastname);
        }
        return null;
    }

    public function setDateOfBirth($dob)
    {
        $this->dateOfBirth= $dob;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setPhoneNumber($pnum)
    {
        $this->phoneNumber = $pnum;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setMobileNumber($mnum)
    {
        $this->mobileNumber = $mnum;
    }

    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    public function setAddress($addr)
    {
        $this->address = $addr;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setBiography($bio)
    {
        $this->biography = $bio;
    }

    public function getBiography()
    {
        return $this->biography;
    }
    
    public function setWebsite($webs)
    {
        $this->website = $webs;
    }

    public function getWebsite()
    {
        return $this->website;
    }
    
    public function setFacebookId($fid)
    {
        $this->facebookId = $fid;
    }

    public function getFacebookId()
    {
        return $this->facebookId;
    }
    
    public function setGplusId($gid)
    {
        $this->gplusId = $gid;
    }

    public function getGplusId()
    {
        return $this->gplusId;
    }
    
    public function setTwitterId($tid)
    {
        $this->twitterId = $tid;        
    }

    public function getTwitterId()
    {
        return $this->twitterId;
    }

    public function setImage($img)
    {
        $this->image = $img;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setGroup(Group $group)
    {
        $this->group = $group;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function addPost($post)
    {
        $this->posts[] = $post;
    }

    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }
}