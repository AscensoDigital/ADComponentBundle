<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 02-11-15
 * Time: 5:54
 */

namespace AscensoDigital\ComponentBundle\Util;


class DateTimeUtil
{
    public static function generateDateTime($datetime){
        $date=$datetime['date'];
        $time=isset($datetime['time']) ? $datetime['time'] : array('hour' => 0, 'minute' => 0, 'second' => 0);
        $y=$date['year'];
        $m=($date['month']<10 ? '0' : '').$date['month'];
        $d=($date['day']<10 ? '0' : '').$date['day'];
        $h=($time['hour']<10 ? '0' : '').$time['hour'];
        $i=($time['minute']<10 ? '0' : '').$time['minute'];
        $s=isset($time['second']) ? (($time['second']<10 ? '0' : '').$time['second']) : '00';
        return new \DateTime(implode(' ',array(implode('-',array($y,$m,$d)), implode(':',array($h,$i,$s)))));
    }
}
