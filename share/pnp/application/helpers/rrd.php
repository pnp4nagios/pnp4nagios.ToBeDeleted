<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
*
* RRDTool Helper Class 
*/
class rrd_Core {
    /*
    * 
    */
    public static function color($num=0 , $alpha='FF'){
        $r = array('99','66','ff','CC','00','33');
        $colors = array();
        $num   = intval($num);
        foreach($r as $ri){
            foreach($r as $gi){
                foreach($r as $bi){
                    $colors[] = sprintf("#%s%s%s%s",$ri,$gi,$bi,$alpha);
                }
            }
        }

        if(array_key_exists($num, $colors)){
            return $colors[$num];
        }else{
            return $colors[0];
        }
    }

    public static function gradient($vname=FALSE, $start_color='#0000a0', $end_color='#f0f0f0', $steps=10){
        if($vname === FALSE){
            throw new Kohana_exception("First Paramter 'vname' is missing");   
        }
        if(preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/i',$start_color,$matches)){
            $r1=hexdec($matches[1]);
            $g1=hexdec($matches[2]);
            $b1=hexdec($matches[3]);
        }else{
            throw new Kohana_exception("Wrong Color Format: '".$start_color."'");   
        }            

        if(preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/i',$end_color,$matches)){
            $r2=hexdec($matches[1]);
            $g2=hexdec($matches[2]);
            $b2=hexdec($matches[3]);
        }else{
            throw new Kohana_exception("Wrong Color Format: '".$end_color."'");   
        }            

        $diff_r=$r2-$r1;
        $diff_g=$g2-$g1;
        $diff_b=$b2-$b1;
        $spline =  "";
        $spline_vname = "var".substr(sha1(rand()),1,4);
        
        for ($i=$steps; $i>0; $i--){
            $spline .=  sprintf("CDEF:%s%d=%s,100,/,%d,* ",$spline_vname,$i,$vname,round((100 / $steps) * $i) );
        }    
        for ($i=$steps; $i>0; $i--){
            $factor=$i / $steps;
            $r=round($r1 + $diff_r * $factor);
            $g=round($g1 + $diff_g * $factor);
            $b=round($b1 + $diff_b * $factor);
            $spline .=  sprintf("AREA:%s%d#%02X%02X%02X ", $spline_vname,$i,$r,$g,$b);
        }
        return $spline;
    }


    public static function cut($string, $length=10, $align='left'){
        if($align == 'left'){
            $format = "%-".$length."s";
        }else{
            $format = "%".$length."s";
        }
        $s = sprintf($format,$string);
        return $s;
    }
    
    public static function line1($vname=FALSE, $color=FALSE, $text=FALSE, $cf=FALSE){
        $line1 = "";
        if($vname === FALSE){
            throw new Kohana_exception("First Paramter 'vname' is missing");   
        }else{
            $line1 .= "LINE1:".$vname;
        }
        if($color === FALSE){
            throw new Kohana_exception("Second Paramter 'color' is missing");   
        }else{
            $line1 .= $color;
        }
        if($text != FALSE){
            $line1 .= ":\"$text\"";
        }
        if($cf != FALSE){
            $line1 .= ":".$cf;
        }
        $line1 .= " ";
        return $line1;
    }
} 