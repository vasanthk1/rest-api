<?php

class App
{
    public function __construct()
    {
        $url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        $url = ltrim($url, '/');
        Router::route($url);
    }
}
