<?php
/* This file is part of Blondie | SSITU | (c) 2021 I-is-as-I-does */
namespace SSITU\Blondie;

class Blondie
{
    private $httponly;
    private $samesite;
    private $lifetime;
    private $path;

    public function __construct($httponly = true, $samesite = 'None', $lifetime = 0, $path = '/')
    {
        $this->httponly = $httponly;
        $this->samesite = $samesite;
        $this->lifetime = $lifetime;
        $this->path = $path;
    }

    public function getProtocol()
    {
       return \SSITU\Jack\Web::getProtocol(false,false);
    }

    public function setCookie($protocol = 'http')
    {
        $secure = false;
        $httponly = true;
        $samesite = 'None';
        $lifetime = 0;
        $path = '/';
        if ($protocol == 'https') {
            $secure = true; // @doc: aka require HTTPS to exchange cookies
        }
        if ($this->httponly === false) {
            $httponly = false;
        }
        if (in_array($this->samesite, ['Lax', 'Strict'])) {
            $samesite = $this->samesite;
        }
        if ($this->lifetime > 0) {
            $lifetime = $this->lifetime;
        }
        if ($this->path != '/') {
            $path = $this->path;
        }

        $cookieParam = [
            'lifetime' => $lifetime,
            'path' => $path,
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => $secure, 
            'httponly' => $httponly, // @doc: if true, prevent JavaScript to access session cookies
            'samesite' => $samesite,
        ];
        session_set_cookie_params($cookieParam);
    }

}
