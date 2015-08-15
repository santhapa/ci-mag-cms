<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ORM\Mapping\Driver\AnnotationDriver,
    Doctrine\DBAL\Logging\EchoSQLLogger,
    Doctrine\Common\EventManager;

use Gedmo\Timestampable\TimestampableListener,
    Gedmo\Sluggable\SluggableListener;

class Doctrine {

    public $em = null;

    public function __construct()
    {
        // load database configuration from CodeIgniter
        require_once APPPATH.'config/database.php';


        //A Doctrine Autoloader is needed to load the models
        // first argument of classloader is namespace and second argument is path
        // setup models/entity namespace
        $entityLoader = new ClassLoader('models', APPPATH);
        $entityLoader->register();

        foreach (glob(APPPATH.'modules/*', GLOB_ONLYDIR) as $m) {
            $module = str_replace(APPPATH.'modules/', '', $m);
            $entityLoader = new ClassLoader($module, APPPATH.'modules');
            $entityLoader->register();
        }
        //Register proxies namespace
        $proxyLoader = new ClassLoader('Proxies', APPPATH.'Proxies');
        $proxyLoader->register();


        // Set up caches
        $config = new Configuration;
        $cache = new ArrayCache;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(array(APPPATH.'models'));
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);

        // Set up entity
        $reader = new AnnotationReader($cache);
        $models = array(APPPATH.'models');
        foreach (glob(APPPATH.'modules/*/models', GLOB_ONLYDIR) as $m)
            array_push($models, $m);
        $driver = new AnnotationDriver($reader, $models);
        $config->setMetadataDriverImpl($driver);

        // Setup Gedmo
        $cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
            $reader, // use reader
            $cache // and a cache driver
        );

        // create a driver chain for metadata reading
        $driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
        
        // load superclass metadata mapping only, into driver chain
        // also registers Gedmo annotations.NOTE: you can personalize it
        Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM(
            $driverChain, // our metadata driver chain, to hook into
            $cachedAnnotationReader // our cached annotation reader
        );

        $event = new EventManager;
        
        $timestampableListener = new TimestampableListener;
        $timestampableListener->setAnnotationReader($cachedAnnotationReader);
        $event->addEventSubscriber($timestampableListener);

        $slugListener = new SluggableListener;
        $slugListener->setAnnotationReader($cachedAnnotationReader);
        $event->addEventSubscriber($slugListener);


        // Proxy configuration
        $config->setProxyDir(APPPATH.'/proxies');
        $config->setProxyNamespace('Proxies');

        // Set up logger
        // $logger = new EchoSQLLogger;
        // $config->setSQLLogger($logger);

        $config->setAutoGenerateProxyClasses( TRUE );

        // Database connection information
        $connectionOptions = array(
            'driver' => 'pdo_mysql',
            'user' =>     $db['default']['username'],
            'password' => $db['default']['password'],
            'host' =>     $db['default']['hostname'],
            'dbname' =>   $db['default']['database']
        );

        // Create EntityManager
        $this->em = EntityManager::create($connectionOptions, $config, $event);
    }
}