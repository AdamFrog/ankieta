<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MFPArr
 *
 * @author Rafal
 */
class MFPArr {
    
    /**
     * Zwraca argumenty z tablicy jeżeli istnieje. Jeżeli nie to zwraca default.
     * @param array $array
     * @param string $key
     * @param type $default
     * @return type
     */
    public static function get($array, $key, $default = null)
    {
        
        return isset($array[$key]) ? $array[$key] : $default;
    }
}
