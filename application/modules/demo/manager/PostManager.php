<?php

namespace blog\manager;

use Doctrine\ORM\EntityManager;
use blog\models\Post;

class PostManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createPost()
	{
		return new Post();
	}

	public function updatePost(Post $post, $flush=true)
	{
		$this->em->persist($post);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removePost(Post $post)
	{
		$this->em->remove($post);
		$this->em->flush();

		return;
	}

	public function getPostById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\blog\models\Post')
               ->createQueryBuilder('p')
               ->select('p')
               ->where('p.id = :post')
               ->setParameter('post', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("\blog\models\Post")->findOneBy(array('id'=>$id));
	}

	public function getPosts($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\blog\models\Post')
               ->createQueryBuilder('p')
               ->select('p')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("\blog\models\Post")->findAll();
	}
}