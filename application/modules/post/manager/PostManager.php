<?php

namespace post\manager;

use Doctrine\ORM\EntityManager;
use post\models\Post;

use Doctrine\ORM\Tools\Pagination\Paginator;

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
               ->getRepository('\post\models\Post')
               ->createQueryBuilder('p')
               ->select('p')
               ->where('p.id = :post')
               ->setParameter('post', $id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}
		return $this->em->getRepository("post\models\Post")->findOneBy(array('id'=>$id));
	}

	public function getPosts($array = false)
	{
		if($array)
		{
			return $this->em
               ->getRepository('\post\models\Post')
               ->createQueryBuilder('p')
               ->select('p')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		}

		return $this->em->getRepository("post\models\Post")->findAll();
	}

	public function getPostBySlug($slug)
	{
		return $this->em->getRepository("\post\models\Post")->findOneBy(array('slug'=>$slug));
	}

	public function paginatePosts($offset = null, $perpage=null){
		$qb = $this->em->createQueryBuilder();
		$qb->select('p')
			->from('post\models\Post', 'p')
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