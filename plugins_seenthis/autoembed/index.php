<?php


//header('Content-Type: text/xml');

define(_DIR_CACHE, 'cache/');
require_once 'autoembed.php';

$url = $_GET["url"];
embed_url($url);


