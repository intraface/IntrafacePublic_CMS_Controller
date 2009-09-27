<?php
require_once 'config.local.php';

set_include_path($GLOBALS['path_include']);

require_once 'k.php';
require_once 'Ilib/ClassLoader.php';

$application = new Root();

$application->registry->registerConstructor('cms', create_function(
  '$className, $args, $registry',
  '$credentials["private_key"] = $GLOBALS["intraface_private_key"];
   $credentials["session_id"] = md5($registry->session->getSessionId());
   $client = new IntrafacePublic_CMS($registry->get("cms:client"), $registry->get("cache"));
   return $client;
  '
));

$application->registry->registerConstructor('cms:client', create_function(
  '$className, $args, $registry',
  '$credentials["private_key"] = $GLOBALS["intraface_private_key"];
   $credentials["session_id"] = md5($registry->session->getSessionId());
   $debug = false;
   $client = new IntrafacePublic_CMS_Client_XMLRPC($credentials, $GLOBALS["intraface_cms_site_id"], $debug);
   return $client;
  '
));

$application->registry->registerConstructor('cache', create_function(
  '$className, $args, $registry',
  '
   $options = array(
       "cacheDir" => $GLOBALS["path_cache"],
       "lifeTime" => 3600
   );
   return new Cache_Lite($options);'
));

try {
    $application->dispatch();
} catch (Exception $e) {
    // $errorhandler = new ErrorHandler;
    // $errorhandler->addObserver(new ErrorHandler_Observer_File($GLOBALS["error_log"]));
    // $errorhandler->handleException($e);

    echo $e;
}