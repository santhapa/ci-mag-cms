<?php

namespace page\manager;

use Doctrine\ORM\EntityManager;
use page\models\Page;

use Doctrine\ORM\Tools\Pagination\Paginator;

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

	public function paginatePages($offset = null, $perpage=null){
		$qb = $this->em->createQueryBuilder();
		$qb->select('p')
			->from('page\models\Page', 'p')
			->where('1=1');

		if(!is_null($offset))
			$qb->setFirstResult($offset);

		if(!is_null($perpage))
			$qb->setMaxResults($perpage);
		$qb->orderBy('p.createdAt','desc');

		$paginator = new Paginator($qb->getQuery(), $fetchJoin = true);
		return $paginator;
	}
}