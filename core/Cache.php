<?php
namespace Core;
use Memcached;

class Cache
{
    private $memcached;

    public function __construct()
    {
        $config = require_once(APP_PATH . 'config/cache.php');
        $memcachedConfig = $config['memcached'];

        // To Do
        // // Add servers to the pool
        // foreach ($servers as $server => $port) {
        //     $memcached->addServer($server, $port);
        // }
        // // Calculate hash to determine which server should handle the key
        // $serverIndex = crc32($key) % count($servers);
        // $targetServer = array_keys($servers)[$serverIndex];

        // // Set data on the target server
        // $memcached->setByKey($targetServer, $key, $data, 3600);

        // // Retrieve data from the same target server
        // $cachedData = $memcached->getByKey($targetServer, $key);

        $this->memcached = new Memcached();
        $this->memcached->addServer($memcachedConfig['host'], $memcachedConfig['port']);
    }

    public function get($key)
    {
        $value = $this->memcached->get($key);
        return $value !== false ? $value : null;
    }

    public function put($key, $value, $expiration)
    {
        $this->memcached->set($key, $value, $expiration);
    }

    public function clear($key)
    {
        $this->memcached->delete($key);
    }
}
