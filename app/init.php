<?php

session_start();

require_once 'config/config.php';
require_once 'helpers/urlHelper.php';
require_once 'helpers/sessionHelper.php';
require_once 'helpers/Global.php';
// Charger la librairie

// Autoload



spl_autoload_register(function($className)
	{if(file_exists('../app/librairies/' . $className . '.php')){
		require_once 'librairies/' . $className . '.php';
		}
	});