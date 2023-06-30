<?php namespace ProcessWire;

/**
 * ProcessWire Configuration File
 *
 * Site-specific configuration for ProcessWire
 *
 * Please see the file /wire/config.php which contains all configuration options you may
 * specify here. Simply copy any of the configuration options from that file and paste
 * them into this file in order to modify them.
 * 
 * SECURITY NOTICE
 * In non-dedicated environments, you should lock down the permissions of this file so
 * that it cannot be seen by other users on the system. For more information, please
 * see the config.php section at: https://processwire.com/docs/security/file-permissions/
 * 
 * This file is licensed under the MIT license
 * https://processwire.com/about/license/mit/
 *
 * ProcessWire 3.x, Copyright 2022 by Ryan Cramer
 * https://processwire.com
 *
 */

if(!defined("PROCESSWIRE")) die();

/** @var Config $config */

/*** SITE CONFIG *************************************************************************/

// Let core API vars also be functions? So you can use $page or page(), for example.
$config->useFunctionsAPI = true;

// Use custom Page classes in /site/classes/ ? (i.e. template "home" => HomePage.php)
$config->usePageClasses = true;

// Use Markup Regions? (https://processwire.com/docs/front-end/output/markup-regions/)
$config->useMarkupRegions = true;

// Prepend this file in /site/templates/ to any rendered template files
$config->prependTemplateFile = '_init.php';

// Append this file in /site/templates/ to any rendered template files
$config->appendTemplateFile = '_main.php';

// Allow template files to be compiled for backwards compatibility?
$config->templateCompile = false;

/*** INSTALLER CONFIG ********************************************************************/


/**
 * Installer: Database Configuration
 * 
 */

$config->dbPort = '3306';
$config->dbCharset = 'utf8mb4';
$config->dbEngine = 'InnoDB';


/**
 * Installer: User Authentication Salt 
 * 
 * This value was randomly generated for your system on 2021/12/06.
 * This should be kept as private as a password and never stored in the database.
 * Must be retained if you migrate your site from one server to another.
 * Do not change this value, or user passwords will no longer work.
 * 
 */
$config->userAuthSalt = '67a67124f6558b0c21cd3f300904df5787806825'; 


/**
 * Installer: Table Salt (General Purpose) 
 * 
 * Use this rather than userAuthSalt when a hashing salt is needed for non user 
 * authentication purposes. Like with userAuthSalt, you should never change 
 * this value or it may break internal system comparisons that use it. 
 * 
 */
$config->tableSalt = '172364f655c792b9bc8c3585b087c9fc5aa9e386'; 


/**
 * Installer: File Permission Configuration
 * 
 */
$config->chmodDir = '0750'; // permission for directories created by ProcessWire
$config->chmodFile = '0640'; // permission for files created by ProcessWire 


/**
 * Installer: Time zone setting
 * 
 */
$config->timezone = 'UTC';

/**
 * Installer: Admin theme
 * 
 */
$config->defaultAdminTheme = 'AdminThemeUikit';

/**
 * Installer: Unix timestamp of date/time installed
 * 
 * This is used to detect which when certain behaviors must be backwards compatible.
 * Please leave this value as-is.
 * 
 */
$config->installed = 1638810896;


switch ($_SERVER['SERVER_NAME']):
// These are the only items that vary by server
	case "anduin.marquette.edu":  		// Aragorn
		$config->server = "Aragorn";
		$config->dbName = 'nmvhbwvdrm';
		$config->dbUser = 'nmvhbwvdrm';
		$config->dbPass = 'Kp88zvz89g';
		$config->dbHost = '127.0.0.1';
		$config->httpHosts = array('anduin.marquette.edu');
		$config->debug = false;
		$config->developmentFlg = false;
		break;
	case "dev-anduin.marquette.edu":	// Celeborn
		$config->server = "Celeborn";
		$config->dbName = 'nmvhbwvdrm';
		$config->dbUser = 'nmvhbwvdrm';
		$config->dbPass = 'Kp88zvz89g';
		$config->dbHost = '127.0.0.1';
		$config->httpHosts = array('dev-anduin.marquette.edu');
		$config->debug = true;
		$config->developmentFlg = true;
		break;
	case "anduin.ddev.site":							// Martens
		$config->server = "Martens";
		$config->dbName = 'db';
		$config->dbUser = 'db';
		$config->dbPass = 'db';
		$config->dbHost = 'db';
		$config->httpHosts = array('anduin.ddev.site');
		$config->debug = true;
		$config->developmentFlg = true;
		break;
endswitch;

/** --------------
 *  Customizations
    -------------- */

if (isset($_SERVER['HTTP_HOST'])):
    $config->htmxRequest = true;
endif;

include_once 'AnduinVersion.php';
setlocale(LC_ALL, 'en_US.UTF-8');
ini_set('session.gc_probability', 1);
$config->AdminThemeUikit('style', 'rock');
$config->sessionFingerprint = false;
$config->pageNameCharset = 'UTF8';
$config->pageNameWhitelist = '-.aàåäáâæbcçčćdđðeèéëêěfghiìíïîjklĺłmnñńňoöõòóôøœpqrŕřsšśtuùúûůüvwxyýzžżź0123456789αβγδεζηθικλμνξοπρστυφχψω';
$config->urls->set('includes', 'site/templates/includes/');
$config->urls->set('scripts', 'site/templates/scripts/');
$config->urls->set('styles', 'site/templates/styles/');
$config->urls->set('assets', 'site/assets/');
$config->pane1Priorities = "1|2|3|4";
$config->pane2Priorities = "4|3|2|1";
$config->navPlusPanel = 1;
$config->searchPanel = 2;
$config->listingsPanel = 3;
$config->imagePanel = 4;
