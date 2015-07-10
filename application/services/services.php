<?php
use Symfony\Component\DependencyInjection\Reference;

$CI =& get_instance();
$em = $CI->doctrine->em;

$container->setParameter('entityManager', $em);
$container->setParameter('ciInstance', $CI);

$container
	->register('mailer_manager', 'Mailer\Mailer')
	->addArgument('%ciInstance%');

// $container
// 	->register('model_manager', 'ModelManager')
// 	->addArgument('%entityManager%');

?>