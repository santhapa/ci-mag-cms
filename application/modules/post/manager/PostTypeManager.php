<?php

namespace post\manager;

use Doctrine\ORM\EntityManager;
use post\models\PostType;

class PostTypeManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createPostType()
	{
		return new PostType();
	}

	public function updatePostType(PostType $ptype, $flush=true)
	{
		$this->em->persist($ptype);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removePostType(PostType $ptype)
	{
		$this->em->remove($ptype);
		$this->em->flush();

		return;
	}

	public function getPostTypeById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\post\models\PostType')
               ->createQueryBuilder('pt')
               ->select('pt')
               ->where('pt.id = :ptype')
               ->setParameter('ptype', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("post\models\PostType")->findOneBy(array('id'=>$id));
	}

	public function getPostTypes($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\post\models\PostType')
               ->createQueryBuilder('pt')
               ->select('pt')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("post\models\PostType")->findAll();
	}

	public function getPostTypeBySlug($slug)
	{
		return $this->em->getRepository("\post\models\PostType")->findOneBy(array('slug'=>$slug));
	}

	public function getPostTypeByName($name)
	{
		return $this->em->getRepository("\post\models\PostType")->findOneBy(array('name'=>$name));
	}
}