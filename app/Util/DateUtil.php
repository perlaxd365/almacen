<?php

use Carbon\Carbon;

class DateUtil
{
    public static function getFechaCompleta($fecha)
    {
        $fecha = new Carbon($fecha);
        $fecha->setLocale('es');
        return $fecha->isoFormat('dddd D \d\e MMMM \d\e\l Y H:mm A');
    }

    public static function getFecha($fecha)
    {
        $fecha = new Carbon($fecha);
        $fecha->setLocale('es');
        return $fecha->isoFormat('dddd D \d\e MMMM \d\e\l Y');
    }
    
    public static function getHora($fecha)
    {
        $fecha = new Carbon($fecha);
        $fecha->setLocale('es');
        return $fecha->isoFormat('HH:mm A');
    }
    
    public static function getFechaHora($fecha)
    {
        $fecha = new Carbon($fecha);
        $fecha->setLocale('es');
        return $fecha->isoFormat('DD/MM/YYYY H:mm A');
    }
    public static function getFechaSimple($fecha)
    {
        $fecha = new Carbon($fecha);
        $fecha->setLocale('es');
        return $fecha->isoFormat('DD/MM/YYYY');
    }
    
}
 