<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Tyre Shop
 *
 * @author     Kevin Jaouën <contact@kevinjaouen.eu>
 * @copyright  2014-2016 Peri Visual System
 * @license    All Rights Reserved
 * @link       http://potts.pvs-sys.be/kevin/Tyre_Shop
 *
 * This unpublished material is proprietary to Peri Visual System SPRL <http://pvsnet.be>.
 * All rights reserved. The methods and techniques described herein are considered trade secrets and/or confidential.
 * Reproduction or distribution, in whole or in part, is forbidden except by express written permission of Peri Visual System SPRL <http://pvsnet.be>.
 */

/**
 * Class used to add specific behavior to CodeIgniter Controller, such as a login system.
 *
 * @class Controller
 * @framework CodeIgniter
 * @parent CodeIgniter Controller
 * @group Core
 */

/**
 * @description Completion in controllers
 ***************** CORE COMPONENTS *****************
 * @property CI_Benchmark        $benchmark            This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
 * @property CI_Config           $config               This class contains functions that enable config files to be managed
 * @property CI_Controller       $controller           This class object is the super class that every library in CodeIgniter will be assigned to.
 * @property CI_Exceptions       $exceptions           Exceptions Class
 * @property CI_Hooks            $hooks                Provides a mechanism to extend the base system without hacking.
 * @property CI_Input            $input                Pre-processes global input data for security
 * @property CI_Lang             $lang                 Language Class
 * @property CI_Loader           $load                 Loads framework components.
 * @property CI_Log              $log                  Logging Class
 * @property FM_Model            $model                Model Class
 * @property CI_Output           $output               Responsible for sending final output to the browser.
 * @property CI_Router           $router               Parses URIs and determines routing
 * @property CI_Security         $security             Security Class
 * @property CI_URI              $uri                  Parses URIs and determines routing
 * @property CI_Utf8             $utf8                 Provides support for UTF-8 environments
 ***************** DATABASE COMPONENTS *****************
 * @property CI_DB_forge         $dbforge              Database Forge Class
 * @property CI_DB_query_builder $db                   This is the platform-independent base Query Builder implementation class.
 * @property CI_DB_utility       $dbutil               Database Utility Class
 ***************** CORE LIBRARIES *****************
 * @property CI_Cache            $cache                CodeIgniter Caching Class
 * @property CI_Session          $session              CodeIgniter Session Class
 * @property CI_Calendar         $calendar             This class enables the creation of calendars
 * @property CI_Cart             $cart                 Shopping Cart Class
 * @property CI_Driver_Library   $driver               This class enables you to create "Driver" libraries that add runtime ability to extend the capabilities of a class via additional driver objects
 * @property CI_Email            $email                Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encryption       $encryption           Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions.
 * @property CI_Form_validation  $form_validation      Form Validation Class
 * @property CI_FTP              $ftp                  FTP Class
 * @property CI_Image_lib        $image_lib            Image Manipulation class
 * @property CI_Migration        $migration            All migrations should implement this, forces up() and down() and gives access to the CI super-global.
 * @property CI_Pagination       $pagination           Pagination Class
 * @property CI_Parser           $parser               Parser Class
 * @property CI_Profiler         $profiler             This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
 * @property CI_Table            $table                Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback        $trackback            Trackback Sending/Receiving Class
 * @property CI_Typography       $typography           Typography Class
 * @property CI_Unit_test        $unit                 Simple testing class
 * @property CI_Upload           $upload               File Uploading Class
 * @property CI_User_agent       $agent                Identifies the platform, browser, robot, or mobile device of the browsing agent
 * @property CI_Xmlrpc           $xmlrpc               XML-RPC request handler class
 * @property CI_Xmlrpcs          $xmlrpcs              XML-RPC server class
 * @property CI_Zip              $zip                  Zip Compression Class
 ***************** DEPRECATED LIBRARIES *****************
 * @property CI_Jquery           $jquery               Jquery Class
 * @property CI_Encrypt          $encrypt              Provides two-way keyed encoding using Mcrypt
 * @property CI_Javascript       $javascript           Javascript Class
 ***************** YOUR LIBRARIES *****************
 * @property Layout              $layout               Layout Class
 ***************** YOUR MODELS *****************
 * @property user_model          $user_model           ,$user
 * @property data_model          $data_model
 * @property products_model      $products_model
 * @property movie_model         $movie_model
 */
class FM_Controller extends CI_Controller {
}

