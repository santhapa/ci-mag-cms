<?php

namespace user\manager;

use Doctrine\ORM\EntityManager;
use user\models\Group;

class GroupManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createGroup()
	{
		return new Group();
	}

	public function updateGroup(Group $group, $flush=true)
	{
		$this->em->persist($group);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeGroup(Group $group)
	{
		$this->em->remove($group);
		$this->em->flush();

		return;
	}

	public function getGroupById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\user\models\Group')
               ->createQueryBuilder('g')
               ->select('g')
               ->where('g.id = :group')
               ->setParameter('group', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("\user\models\Group")->findOneBy(array('id'=>$id));
	}

	public function getGroups($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\user\models\Group')
               ->createQueryBuilder('g')
               ->select('g')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("user\models\Group")->findAll();
	}
}