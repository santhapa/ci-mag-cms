<?php

namespace post\manager;

use Doctrine\ORM\EntityManager;
use post\models\Comment;

class CommentManager{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createComment()
	{
		return new Comment();
	}

	public function updateComment(Comment $cmt, $flush=true)
	{
		$this->em->persist($cmt);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeComment(Comment $cmt)
	{
		$this->em->remove($cmt);
		$this->em->flush();

		return;
	}

	public function getCommentById($id, $array=false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\post\models\Comment')
               ->createQueryBuilder('c')
               ->select('c')
               ->where('c.id = :cmt')
               ->setParameter('cmt', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("post\models\Comment")->findOneBy(array('id'=>$id));
	}
}