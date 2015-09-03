<?php

namespace prayer\manager;

use Doctrine\ORM\EntityManager;
use prayer\models\Prayer;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PrayerManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createPrayer()
	{
		return new Prayer();
	}

	public function updatePrayer(Prayer $prayer, $flush=true)
	{
		$this->em->persist($prayer);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removePrayer(Prayer $prayer)
	{
		$this->em->remove($prayer);
		$this->em->flush();

		return;
	}

	public function getPrayerById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\prayer\models\Prayer')
               ->createQueryBuilder('p')
               ->select('p')
               ->where('p.id = :prayer')
               ->setParameter('prayer', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("\prayer\models\Prayer")->find($id);
	}

	public function getPrayers($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\prayer\models\Prayer')
               ->createQueryBuilder('p')
               ->select('p')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("prayer\models\Prayer")->findAll();
	}

	public function getPrayerByDate($date, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\prayer\models\Prayer')
               ->createQueryBuilder('p')
               ->select('p')
               ->where('p.date = :prayer')
               ->setParameter('prayer', $date)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("\prayer\models\Prayer")->findOneBy(array('date'=> new \DateTime($date)));
	}

	public function paginatePrayers($offset = null, $perpage=null){
		$qb = $this->em->createQueryBuilder();
		$qb->select('p')
			->from('prayer\models\Prayer', 'p')
			->where('1=1');

		if(!is_null($offset))
			$qb->setFirstResult($offset);

		if(!is_null($perpage))
			$qb->setMaxResults($perpage);
		$qb->orderBy('p.date','desc');

		$paginator = new Paginator($qb->getQuery(), $fetchJoin = true);
		return $paginator;
	}
}