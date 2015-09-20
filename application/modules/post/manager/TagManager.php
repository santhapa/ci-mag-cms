<?php

namespace post\manager;

use Doctrine\ORM\EntityManager;
use post\models\Tag;

class TagManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createTag()
	{
		return new Tag();
	}

	public function updateTag(Tag $tag, $flush=true)
	{
		$this->em->persist($tag);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeTag(Tag $tag)
	{
		$this->em->remove($tag);
		$this->em->flush();

		return;
	}

	public function getTagById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\post\models\Tag')
               ->createQueryBuilder('t')
               ->select('t')
               ->where('t.id = :tag')
               ->setParameter('tag', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("post\models\Tag")->findOneBy(array('id'=>$id));
	}

	public function getTags($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\post\models\Tag')
               ->createQueryBuilder('t')
               ->select('t')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("post\models\Tag")->findAll();
	}

	public function getTagByName($name)
	{
		return $this->em->getRepository("\post\models\Tag")->findOneBy(array('name'=>$name));
	}
}