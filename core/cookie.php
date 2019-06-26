<?php


class Cookie
{

    private static $NAME = '__fav__locatia__';  //Default name of cookie
    private static $EXPIRES = (90 * 24 * 60 * 60); // 90 Day
    private static $PATH = '/';
    //FORMAT ot return values of the cookie
    public static $FORMAT_STR = 'string';
    public static $FORMAT_ARRAY = 'array';
    
    //CONSTANTS
    const FORMAT_STR = 'string';
    const FORMAT_ARRAY = 'array';

    //GET COOKIE VALUES AS STRING OR ARRAY
    /**
     * @param $format
     * @return array|bool|string
     */
    public static function get($format)
    {

        if (!isset($_COOKIE[self::$NAME])) return false;

        switch ($format) {
            case self::$FORMAT_STR :
                return $_COOKIE[self::$NAME];
                break;
            case self::$FORMAT_ARRAY:
                return explode(',', $_COOKIE[self::$NAME]);
                break;
        }
    }

    //CREATE NEW COOKIE IF NOT OR OVERRIDE EXISTING ONE
    /**
     * @param $value
     * @param bool $override
     * @return bool
     */
    public static function create($value, $override = false)
    {
        if ($override === true) {
            return setcookie(self::$NAME, $value, time() + self::$EXPIRES, self::$PATH);
        } else {
            (!isset($_COOKIE[self::$NAME])) or exit('Can\t override the existing cookie.');
            return setcookie(self::$NAME, $value, time() + self::$EXPIRES, self::$PATH);
        }
    }

    public static function drop(){
        isset($_COOKIE[self::$NAME]) or exit('There is no cookie found to drop');
        setcookie(self::$NAME, null, -1, self::$PATH);
    }

    //ADD TO COOKIE
    /**
     * @param $value
     */
    public static function add($value)
    {
        if (isset($_COOKIE[self::$NAME]) ){
            is_numeric($value) or exit('Value to add must be numeric.');
            //Retrieve data contained in old cookie
            $parts = self::get(self::$FORMAT_ARRAY);
            if (!in_array($value, $parts)){
                array_push($parts, $value);
                self::create(implode(',', $parts), true);
            }
        }else{
            self::create($value);
        }
    }

    //DELETE VALUE FROM COOKIE
    public static function delete()
    {

        $appart = func_get_arg(0);
        isset($_COOKIE[self::$NAME]) or exit('There is no cookie found.');
        if (!is_null($appart)) {
            is_numeric($appart) or exit('Value to delete must be numeric.');
            $parts = self::get(self::$FORMAT_ARRAY);
            $key = array_search($appart, $parts);
            unset($parts[$key]);
            self::create(implode(',', $parts), true);
        } else {
            $parts = self::get(self::$FORMAT_ARRAY);
            array_pop($parts);
            self::create(implode(',', $parts), true);
        }

    }

}