<?php

namespace user\manager;

use Doctrine\ORM\EntityManager;
use user\models\Permission;

class PermissionManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createPermission()
	{
		return new Permission();
	}

	public function updatePermission(Permission $permission, $flush=true)
	{
		$this->em->persist($permission);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removePermission(Permission $permission)
	{
		$this->em->remove($permission);
		$this->em->flush();

		return;
	}

	public function getPermissionById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\user\models\Permission')
               ->createQueryBuilder('p')
               ->select('p')
               ->where('p.id = :perm')
               ->setParameter('perm', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("\user\models\Permission")->findOneBy(array('id'=>$id));
	}

	public function getPermissions($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\user\models\Permission')
               ->createQueryBuilder('p')
               ->select('p')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("user\models\Permission")->findAll();
	}
}