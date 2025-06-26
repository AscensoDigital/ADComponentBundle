<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 03-03-16
 * Time: 13:56
 */

namespace AscensoDigital\ComponentBundle\Util;


class StrUtil
{
    public static function destacarTerm($destacar,$cadena){
        $terms=explode(" ",$destacar);
        $cadenaDestacada=$cadena;
        if(count($terms)) {
            foreach ($terms as $term) {
                $cadenaDestacada = str_replace($term, '<strong>' . self::ucwords($term) . '</strong>', $cadenaDestacada);
                $term_sano=self::sanearString($term);
                if($term!=$term_sano) {
                    $cadenaDestacada = str_replace($term_sano, '<strong>' . self::ucwords($term_sano) . '</strong>', $cadenaDestacada);
                }
            }
        }
        else {
            $cadenaDestacada = str_replace($destacar, '<strong>' . self::ucwords($destacar) . '</strong>', $cadenaDestacada);
            $destacar_sano=self::sanearString($destacar);
            if($destacar!=$destacar_sano) {
                $cadenaDestacada = str_replace($destacar_sano, '<strong>' . self::ucwords($destacar_sano) . '</strong>', $cadenaDestacada);
            }
        }
        return $cadenaDestacada;
    }

    public static function firstWord($str) {
        $tmp=explode(' ',$str);
        return isset($tmp[0]) ? $tmp[0] : $str;
    }

    public static function formatReport($contenido) {
        return str_replace('&quot;','"',utf8_decode(str_replace('À',';',$contenido)));
    }

    /**
     * Reemplaza todos los acentos por sus equivalentes sin ellos
     * @param $string
     *  string la cadena a sanear
     * @return mixed|$string
     *  string saneada
     */
    public static function sanearString($string, $sanear_guion = true) {
        $string = trim($string);
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "~",
                "#", "@", "|", "!", "\"",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "`", "]",
                "+", "}", "{", "¨", "´",
                ">", "< ", ";", ",", ":",
                ".", "*"),
            '',
            $string
        );

        if($sanear_guion) {
            $string = str_replace(array("-","_"), '', $string);
        }

        return $string;
    }

    public static function strtolower($str){
        $string=strtolower($str);
        $string = str_replace(
            array('Á', 'À', 'Ä', 'Â'),
            array('á', 'à', 'ä', 'â'),
            $string
        );
        $string = str_replace(
            array('É', 'È', 'Ë', 'Ê'),
            array('é', 'è', 'ë', 'ê', ),
            $string
        );
        $string = str_replace(
            array('Í', 'Ì', 'Ï', 'Î'),
            array('í', 'ì', 'ï', 'î'),
            $string
        );
        $string = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô'),
            array('ó', 'ò', 'ö', 'ô'),
            $string
        );
        $string = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü'),
            array('ú', 'ù', 'û', 'ü'),
            $string
        );
        return str_replace(
            array('Ñ'),
            array('ñ') ,
            $string
        );
    }

    public static function strtoupper($str){
        $string=strtoupper($str);
        $string = str_replace(
            array('á', 'à', 'ä', 'â'),
            array('Á', 'À', 'Ä', 'Â'),
            $string
        );
        $string = str_replace(
            array('é', 'è', 'ë', 'ê'),
            array('É', 'È', 'Ë', 'Ê'),
            $string
        );
        $string = str_replace(
            array('í', 'ì', 'ï', 'î'),
            array('Í', 'Ì', 'Ï', 'Î'),
            $string
        );
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô'),
            array('Ó', 'Ò', 'Ö', 'Ô'),
            $string
        );
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û'),
            array('Ú', 'Ù', 'Ü', 'Û'),
            $string
        );
        return str_replace(
            array('ñ'),
            array('Ñ'),
            $string
        );
    }

    public static function ucwords($str){
        $str=ucwords($str);
        $words_array=explode(" ",$str);
        $ret=array();
        foreach ($words_array as $word) {
            $first=$word[0];
            $firstUpper=str_replace(
                array('ñ','á','é','í','ó','ú'),
                array('Ñ','Á','É','Í','Ó','Ú'),
                $first
            );
            $word[0]=$firstUpper;
            $ret[]=$word;
        }
        return trim(implode(' ',$ret));
    }
}
