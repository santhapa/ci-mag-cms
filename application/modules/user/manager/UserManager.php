<?php

namespace user\manager;

use Doctrine\ORM\EntityManager;
use user\models\User;

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
}