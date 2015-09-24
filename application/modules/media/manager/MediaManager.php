<?php

namespace media\manager;

use Doctrine\ORM\EntityManager;
use media\models\Media;

class MediaManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createMedia()
	{
		return new Media();
	}

	public function updateMedia(Media $media, $flush=true)
	{
		$this->em->persist($media);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeMedia(Media $media)
	{
		$this->em->remove($media);
		$this->em->flush();

		return;
	}

	public function getMediaById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('media\models\Media')
               ->createQueryBuilder('m')
               ->select('m')
               ->where('m.id = :media')
               ->setParameter('media', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("media\models\Media")->findOneBy(array('id'=>$id));
	}

	public function getMedias($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('media\models\Media')
               ->createQueryBuilder('m')
               ->select('m')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("media\models\Media")->findAll();
	}

	public function getMediaBySource($source)
	{
		return $this->em->getRepository("media\models\Media")->findOneBy(array('source'=>$source));
	}
}