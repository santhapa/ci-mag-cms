<?php

namespace user\fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use user\models\Group;

class LoadGroupData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
    	$groups = array(
			array("name"=>"Super Admin", "slug"=>"super_admin"),
			array("name"=>"Admin", "slug"=>"admin"),
			array("name"=>"Editor", "slug"=>"editor"),
			array("name"=>"Author", "slug"=>"author"),
			array("name"=>"Subscriber", "slug"=>"subscriber"),
		);
		foreach ($groups as $grp) {
			$group = new Group();
	    	$group->setName($grp['name']);
	    	$group->setSlug($grp['slug']);
	    	$manager->persist($group);

	    	if($grp['slug'] == 'super_admin')
	    	{
				$this->addReference('super_group', $group);
	    	}
		}
		$manager->flush();
    }

    public function getOrder()
    {
        return 1; // number in which order to load fixtures
    }
}

?>