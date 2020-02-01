<?php

use App\Countdown;
use Lib\AnimatedGif;

require 'vendor/autoload.php';

header('Content-type: image/gif');
header('Content-Disposition: filename="timer.gif"');

if ($_GET['time']) {
    $time = \DateTime::createFromFormat(
        'Y-m-d-H-i-s',
        $_GET['time'],
        new \DateTimeZone('UTC')
    );
} else {
    $time = new DateTime(date('r',strtotime("+1 hours")));
    $time->setTimezone(new \DateTimeZone('UTC'));
}

$countdown = new Countdown($time);

$gif = new AnimatedGif($countdown->getFrames(), $countdown->getDelays(), $countdown->getLoops());
$gif->display();
		
header( 'Expires: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );