<?php

use App\Countdown;
use Lib\AnimatedGif;

require 'vendor/autoload.php';

header('Content-type: image/gif');
header('Content-Disposition: filename="timer.gif"');
	
$countdown = new Countdown($_GET['time']);

$gif = new AnimatedGif($countdown->getFrames(), $countdown->getDelays(), $countdown->getLoops());
$gif->display();
		
header( 'Expires: Sat, 26 Jul 2037 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );