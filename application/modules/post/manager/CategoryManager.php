<?php

namespace post\manager;

use Doctrine\ORM\EntityManager;
use post\models\Category;

class CategoryManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createCategory()
	{
		return new Category();
	}

	public function updateCategory(Category $cat, $flush=true)
	{
		$this->em->persist($cat);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeCategory(Category $cat)
	{
		$this->em->remove($cat);
		$this->em->flush();

		return;
	}

	public function getCategoryById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\post\models\Category')
               ->createQueryBuilder('c')
               ->select('c')
               ->where('c.id = :cat')
               ->setParameter('cat', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("post\models\Category")->findOneBy(array('id'=>$id));
	}

	public function getCategorys($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\post\models\Category')
               ->createQueryBuilder('c')
               ->select('c')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("post\models\Category")->findAll();
	}

	public function getCategoryBySlug($slug)
	{
		return $this->em->getRepository("\post\models\Category")->findOneBy(array('slug'=>$slug));
	}

	public function getCategoryByName($name)
	{
		return $this->em->getRepository("\post\models\Category")->findOneBy(array('name'=>$name));
	}
}