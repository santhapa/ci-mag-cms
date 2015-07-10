<?php
namespace user\models;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use user\models\Group;

/**
 * @ORM\Entity
 * @ORM\Table(name="mag_users")
 */
class User
{
	/**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    // required information - login details

    /**
    * @ORM\Column(type="string", unique=true)
    */
    protected $username;

    /**
    * @ORM\Column(type="string")
    */
    protected $password;

    /**
    * @ORM\Column(type="string", unique=true)
    */
    protected $email;

    /**
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="created_at", type="datetime")
    */
    protected $createdAt;

    /**
    * @ORM\Column(type="boolean")
    */
    protected $status;

    //personal informations

    /**
    * @ORM\Column(name="firstname", type="string", length=100, nullable=true)
    */
    protected $firstname;

    /**
    * @ORM\Column(name="lastname", type="string", length=100, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="user\models\Group", inversedBy="users")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
    **/
    protected $group;

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
        return $this->firstname." ".$this->lastname;
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

    public function setGroup(Group $group)
    {
        $this->group = $group;
    }

    public function getGroup()
    {
        return $this->group;
    }
}