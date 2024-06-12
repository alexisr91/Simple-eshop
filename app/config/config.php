<?php

// definition des constantes




// racine de l'appli

define('APPROOT', dirname(dirname(__FILE__)));
define('VENDORROOT','../vendor/');
define('APISTRIPE','sk_test_51LEtjyKGeU3X6nsn1eUTcxr8gPkov1JkhqM3xXqqPqdKXpkOFMT9NfjGNAnTs1JetfIT1FY0bFSewyoCMWSeGXtQ00J3pMWVHe');

// Clé privé à ne pas montrer 

$upimg = dirname(dirname(dirname(__FILE__))).'\public\images\upload\\';
define('UPIMG',$upimg);



// racine des URLS

define('URLROOT', 'http://localhost:8888/eshop/');


// titre du site 

define('SITENAME', 'Ecommerce');


// base de données 

define('DB_HOST','localhost');
define('DB_NAME','eshop');
define('DB_USER','root');
define('DB_PASSWORD','root'); // MDP DE MAMP EST ROOT PAR DEFAUT