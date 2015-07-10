<?php
namespace user\models;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

use user\models\Permission;

/**
 * @ORM\Entity
 * @ORM\Table(name="mag_user_groups")
 */
class Group
{
	/**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

   	/**
   	* @ORM\Column(type="string")
   	*/
   	protected $name;

   	/**
    * @Gedmo\Slug(fields={"name"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $slug;

    /**
	* @ORM\OneToMany(targetEntity="user\models\User", mappedBy="group")
	**/
    private $users;

	/**
	* @ORM\ManyToMany(targetEntity="user\models\Permission", cascade={"persist"})
	* @ORM\JoinTable(name="mag_user_group_permission")
	*/
    private $permissions;

    public function __construct() {
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
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
    
    public function setSlug($slug)
    {
    	$this->slug = $slug;
    }

    public function getSlug()
    {
    	return $this->slug;
    }

    public function getUsers()
    {
    	return $this->users;
    }

    public function getPermissions(){
		return $this->permissions;
	}
	
	public function clonePermissions(){
		$permissions = $this->permissions;
		$this->permissions = new ArrayCollection();
		
		foreach($permissions as $p){
			$this->permissions->add($p);
		}
	}
	
	public function addPermission(Permission $permission){
		$this->permissions[] = $permission;
	}
	
	public function removePermission(Permission $permission){
		$this->permissions->removeElement($permission);
	}
	
	public function resetPermissions(){
		$this->permissions = new ArrayCollection();
	}


}