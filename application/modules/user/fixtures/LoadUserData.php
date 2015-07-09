<?php

namespace user\fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use user\models\User;

class LoadUserData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
		$user = new User();
		$user->setUsername('superadmin');
		$user->setPassword(password_hash('123456', PASSWORD_BCRYPT));
		$user->setEmail('superadmin@gmail.com');
		$user->setCreatedAt(new \DateTime());
		$user->setStatus(true);
		$user->setGroup($this->getReference('super_group'));

		$manager->persist($user);
		$manager->flush();
    }

    public function getOrder()
    {
        return 2; // number in which order to load fixtures
    }
}

?>