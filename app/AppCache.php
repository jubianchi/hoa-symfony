<?php

require_once __DIR__.'/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

class AppCache extends HttpCache
{
    // http://symfony.com/doc/2.3/book/http_cache.html
}
