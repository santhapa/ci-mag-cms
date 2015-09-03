<?php

namespace user\manager;

use Doctrine\ORM\EntityManager;
use user\models\User;

use Doctrine\ORM\Tools\Pagination\Paginator;

class UserManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createUser()
	{
		return new User();
	}

	public function updateUser(User $user, $flush=true)
	{
		$this->em->persist($user);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeUser(User $user)
	{
		$this->em->remove($user);
		$this->em->flush();

		return;
	}

	public function getUserById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\user\models\User')
               ->createQueryBuilder('u')
               ->select('u')
               ->where('u.id = :user')
               ->setParameter('user', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("\user\models\User")->findOneBy(array('id'=>$id));
	}

	public function getUsers($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\user\models\User')
               ->createQueryBuilder('u')
               ->select('u')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("user\models\User")->findAll();
	}

	public function getUserByUsername($username, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\user\models\User')
               ->createQueryBuilder('u')
               ->select('u')
               ->where('u.username = :user')
               ->setParameter('user', $username)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("\user\models\User")->findOneBy(array('username'=>$username));
	}

	public function getUserByEmail($email, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\user\models\User')
               ->createQueryBuilder('u')
               ->select('u')
               ->where('u.email = :user')
               ->setParameter('user', $email)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("\user\models\User")->findOneBy(array('email'=>$email));
	}

	public function paginateUsers($offset = null, $perpage=null){
		$qb = $this->em->createQueryBuilder();
		$qb->select('u, g')
			->from('user\models\User', 'u')
			->leftJoin('u.group', 'g')
			->where('1=1');

		if(!is_null($offset))
			$qb->setFirstResult($offset);

		if(!is_null($perpage))
			$qb->setMaxResults($perpage);
		$qb->orderBy('u.username','asc');

		$paginator = new Paginator($qb->getQuery(), $fetchJoin = true);
		return $paginator;
	}
}