<?php

namespace page\manager;

use Doctrine\ORM\EntityManager;
use page\models\Page;

class PageManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createPage()
	{
		return new Page();
	}

	public function updatePage(Page $page, $flush=true)
	{
		$this->em->persist($page);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removePage(Page $page)
	{
		$this->em->remove($page);
		$this->em->flush();

		return;
	}

	public function getPageById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\page\models\Page')
               ->createQueryBuilder('p')
               ->select('p')
               ->where('p.id = :page')
               ->setParameter('page', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("page\models\Page")->findOneBy(array('id'=>$id));
	}

	public function getPages($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\page\models\Page')
               ->createQueryBuilder('p')
               ->select('p')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("page\models\Page")->findAll();
	}

	public function getPageBySlug($slug)
	{
		return $this->em->getRepository("\page\models\Page")->findOneBy(array('slug'=>$slug));
	}
}