<?php

namespace user\security;

use Doctrine\ORM\EntityManager;

class ACL{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
}
?>