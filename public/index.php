<?php
//die( 'jaden' . rand( 0, 98789 ) );
if ( PHP_SAPI == 'cli-server' ) {
	// To help the built-in PHP dev server, check if the request was actually for
	// something which should probably be served as a static file
	$url  = parse_url( $_SERVER['REQUEST_URI'] );
	$file = __DIR__ . $url['path'];
	if ( is_file( $file ) ) {
		return false;
	}
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

require __DIR__ . '/../dotenv.php';
/**
 * SENTRY SET UP
 */
$client        = new Raven_Client( getenv( 'SENTRY_DSN' ) );
$error_handler = new Raven_ErrorHandler( $client );
$error_handler->registerExceptionHandler();
$error_handler->registerErrorHandler();
$error_handler->registerShutdownFunction();
try {
	throw new \Exception( 'oops' );
} catch ( \Exception $e ) {
	echo '<br />Capture = ';
	echo $client->captureException( $e );
	echo '<br />';

}

/**
 * Instantiate the app
 */
$settings = require __DIR__ . '/../src/settings.php';

$app        = new \Slim\App( $settings );
$start      = round( microtime( true ), 4 );
$timeMarker = $start;
$t          = function ( $tag = 'Tag' ) use ( $start, &$timeMarker ) {
	$result     = ( round( microtime( true ) - $timeMarker, 4 ) );
	$timeMarker = round( microtime( true ), 4 );
	echo $tag . ' TIME ' . $result . ' <br />';
};
/**
 * Set up dependencies
 */
require __DIR__ . '/../src/dependencies.php';
$t( 'Dependancy' );

/**
 * Register middleware
 */
require __DIR__ . '/../src/middleware.php';
$t( 'Middle' );
/**
 * Register routes
 */
require __DIR__ . '/../src/routes.php';
$t( 'Routes' );
/**
 * Run app
 */
$app->run();
$t( 'Run' );
