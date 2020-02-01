<?php 

namespace App;

use DateTime;

class Countdown
{
    private $frames;
    private $delays;
    private $loops; 

    private $now;
    private $countdownDatetime;     

    public function __construct(DateTime $urlDatetime)
    {
        $this->now = time();
        $this->now = new \DateTime(date('r', $this->now));
        $this->countdownDatetime = $urlDatetime;      
        $this->renderFrames($this->countdownDatetime);
    }

    public function getFrames() :array
    {
        return $this->frames;
    }

    public function getDelays() :array
    {
        return $this->delays;
    }

    public function getLoops()
    {
        return $this->loops;
    }

    private function renderFrames() :void
    {
        $interval = date_diff($this->countdownDatetime, $this->now);
        $text = $interval->format('%aD');
        $width = $this->getWidth($text);
        $img = imagecreatetruecolor($width, 50);
        $bg = imagecolorallocate ($img, 255, 255, 255 );
        imagefilledrectangle($img,0,0,$width,50,$bg);
        imagepng($img,"temp.png",9);
        $frames = [];	
        $delays = [];
        $image = imagecreatefrompng(__DIR__ ."/../temp.png");
        $delay = 100;
        $font = [
            'size' => 12,
            'angle' => 0,
            'x-offset' => 2,
            'y-offset' => 30,
            'file' => __DIR__ . '/../assets/Futura.ttc',
            'color' => imagecolorallocate($image, 55, 160, 130)
        ];

        for($i = 0; $i <= 60; $i++){
		
            $interval = date_diff($this->countdownDatetime, $this->now);
            
            if($this->countdownDatetime < $this->now){
                $image = imagecreatefrompng(__DIR__ ."/../temp.png");
                ;
                $text = $interval->format('00:00:00:00');
                imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
                ob_start();
                imagegif($image);
                $frames[]=ob_get_contents();
                $delays[]=$delay;
                $loops = 1;
                ob_end_clean();
                break;
            } else {
                $image = imagecreatefrompng(__DIR__ ."/../temp.png");
                ;
                $text = $interval->format('   %aD %Hh %Im %Ss');
                imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
                ob_start();
                imagegif($image);
                $frames[]=ob_get_contents();
                $delays[]=$delay;
                $loops = 0;
                ob_end_clean();
            }
    
            $this->now->modify('+1 second');
        }

        $this->frames = $frames;
        $this->delays = $delays;
        $this->loops = $loops;   
    }

    private function getWidth($text)
    {
        switch (strlen($text)) {
            case 7:
            case 6:
            case 5:
                $width = 195;
                break;
            case 4:
                $width = 180;
                break;
            case 3:
                $width = 175;
                break;
            case 2:
            default:
                $width = 165;
                break;
        }
        return $width;
    }
}