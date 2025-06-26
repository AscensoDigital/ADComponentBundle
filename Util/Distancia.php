<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 18-09-15
 * Time: 0:06
 */

namespace AscensoDigital\ComponentBundle\Util;


class Distancia {
    const KILOMETROS = 1;
    const METROS = 2;
    const MILLAS = 3;

    public static function calcGeodesica($lat1, $long1, $lat2, $long2, $unidad=self::METROS){

        if (!is_numeric($lat1) || !is_numeric($long1) || !is_numeric($lat2) || !is_numeric($long2)) {
            return null;
        }

        $degtorad = 0.01745329;
        $radtodeg = 57.29577951;

        $dlong = ($long1 - $long2);
        $dvalue = (sin($lat1 * $degtorad) * sin($lat2 * $degtorad))
            + (cos($lat1 * $degtorad) * cos($lat2 * $degtorad)
                * cos($dlong * $degtorad));

        $dd = acos($dvalue) * $radtodeg;
        $km = ($dd * 111.302);
        $miles = ($dd * 69.16);
        switch ($unidad){
            case self::KILOMETROS:
                return $km;
            case self::METROS:
                return round($km*1000,0);
            case self::MILLAS:
                return $miles;
        }
        return null;
    }
}
