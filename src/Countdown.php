<?php 

namespace App;

class Countdown
{
    private $backgroundImage =  __DIR__ . '/../assets/countdown-blank.png';

    private $frames;
    private $delays;
    private $loops; 

    private $animatedGif;
    private $urlDatetime;
    private $countdownDatetime;     

    public function __construct(string $urlDatetime)
    {
        $this->urlDatetime = $urlDatetime;
        $this->countdownDatetime = \DateTime::createFromFormat(
            'Y-m-d-H-i-s',
            $this->urlDatetime,
            new \DateTimeZone('UTC')
        );
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
        $now = time();
        $now = new \DateTime(date('r', $now));
        $frames = [];	
        $delays = [];
        $image = imagecreatefrompng($this->backgroundImage);
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
		
            $interval = date_diff($this->countdownDatetime, $now);
            
            if($this->countdownDatetime < $now){
                $image = imagecreatefrompng($this->backgroundImage);
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
                $image = imagecreatefrompng($this->backgroundImage);
                ;
                $text = $interval->format(' d:%a h:%H m:%I s:%S');
                imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
                ob_start();
                imagegif($image);
                $frames[]=ob_get_contents();
                $delays[]=$delay;
                $loops = 0;
                ob_end_clean();
            }
    
            $now->modify('+1 second');
        }

        $this->frames = $frames;
        $this->delays = $delays;
        $this->loops = $loops;   
    }
}