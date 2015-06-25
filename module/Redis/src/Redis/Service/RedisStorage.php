<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/19/15
 * Time: 4:06 PM
 */

namespace Redis\Service;

use Zend\Cache\StorageFactory;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SaveHandler\Cache;
use Zend\Session\SessionManager;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;

class RedisStorage
{
    const ALIAS = 'Redis\Service\RedisStorage';

    private $config;

    private $manager;

    private $cache;

    public function __construct($config, $cache)
    {
        $this->config = $config;
        $this->cache  = $cache;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function changeTtl($ttl = 0)
    {
        $this->config['redis']['adapter']['options']['ttl'] = $ttl;

        $this->setSessionStorage();
    }

    public function setSessionStorage()
    {
        $cache = StorageFactory::factory($this->config['redis']);

        // If database is set in the config use it
        if (array_key_exists('database', $this->config['redis']['adapter']['options'])) {
            $cache->getOptions()->setDatabase($this->config['redis']['adapter']['options']['database']);
        }

        $saveHandler = new Cache($cache);

        $manager = new SessionManager();

        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($this->config['session']);

        $manager->setConfig($sessionConfig);
        $manager->setSaveHandler($saveHandler);

        // Validation to prevent session hijacking
        $manager->getValidatorChain()->attach('session.validate', array(new HttpUserAgent(), 'isValid'));
        $manager->getValidatorChain()->attach('session.validate', array(new RemoteAddr(), 'isValid'));
        $manager->start();

        Container::setDefaultManager($manager);

        $this->manager = $manager;
    }
}
