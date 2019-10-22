<?php


namespace App\Config;


use App\Config\Loaders\ArrayLoader;

class Config
{
    protected $config = [];

    protected $cache = [];

    public function load(array $loaders)
    {

        foreach ($loaders as $loader) {
            if (!$loader instanceof ArrayLoader) {
                continue;
            }

            $this->config = array_merge($this->config, $loader->parse());
        }

        return $this;
    }

    public function get($key, $default = NULL)
    {
        if ($this->existsInCache($key)) {
            $this->returnFromCache($key);
        }
        return $this->addToCache(
            $key,
            $this->extractFromConfig($key) ?? $default);
    }

    protected function extractFromConfig($key)
    {
        $filtered = $this->config;

        foreach (explode('.', $key) as $segment) {
            if ($this->exists($filtered, $segment)) {
                $filtered = $filtered[$segment];
                continue;
            }

            return;
        }

        return $filtered;
    }

    protected function addToCache($key, $value)
    {
        $this->cache[$key] = $value;

        return $value;
    }

    protected function existsInCache($key)
    {
        return isset($this->cache[$key]);
    }
    protected function returnFromCache($key)
    {
        return $this->cache[$key];
    }

    protected function exists(array $config, $key)
    {
        return array_key_exists($key, $config);
    }
}