<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('X-Powered-By: spritosoft.com');
header('X-XSS-Protection: 1');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Vary: Accept-Encoding');

if (isset($header))
{
    echo $header;
} 
if (isset($header_main))
{
    echo $header_main;
} 
if (isset($main_sidebar))
{
    echo $main_sidebar;
}
if (isset($main_area))
{
    echo $main_area;
} 
if (isset($footer))
{
    echo $footer;
}
