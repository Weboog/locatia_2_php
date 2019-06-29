<?php


class Cookie
{

    private static $NAME = '__fav__locatia__';  //Default name of cookie
    private static $EXPIRES = (90 * 24 * 60 * 60); // 90 Day
    private static $PATH = '/';
    
    //CONSTANTS
    const FORMAT_STR = 'string';
    const FORMAT_ARRAY = 'array';
    const COOKIE_NOT_FOUND = 'COOKIE_NOT_FOUND';
    const BAD_PARAM = 'BAD_PARAM';


    /**
     * 
     * @return void
     */
    public static function getAsString(): void{
        echo $_COOKIE[self::$NAME];
    }
    
    
    /**
     * 
     * @return array
     */
    public static function getAsArray(): array{
        return explode(',', $_COOKIE[self::$NAME]);
    }


    /**
     * 
     * @param type $value
     * @param type $override
     * @return void
     */
    public static function create($value, $override = false): void{
        
        if($override === false){
            if(isset($_COOKIE[self::$NAME])) self::JSON ('status', false);
            self::JSON('status', setcookie(self::$NAME, $value, time() + self::$EXPIRES, self::$PATH));
        }
        self::JSON('status', setcookie(self::$NAME, $value, time() + self::$EXPIRES, self::$PATH));
    }

    
    /**
     * 
     * @return void
     */
    public static function drop(): void{
        self::JSON('status', setcookie(self::$NAME, null, -1, self::$PATH));
    }

    //ADD TO COOKIE
    /**
     * 
     * @param type $value
     * @return void
     */
    public static function add($value): void {
        
        if (isset($_COOKIE[self::$NAME]) ){
            is_numeric($value) or self::JSON('status', self::BAD_PARAM);
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
    /**
     * 
     * @return void
     */
    public static function delete(): void {

        $id = func_get_arg(0);
        isset($_COOKIE[self::$NAME]) or self::JSON('status', self::COOKIE_NOT_FOUND);
        if (!is_null($id)) {
            is_numeric($id) or self::JSON('status', self::BAD_PARAM);
            $parts = self::getAsArray();
            $key = array_search($id, $parts);
            unset($parts[$key]);
            self::create(implode(',', $parts), true);
        } else {
            $parts= self::getAsArray();
            array_pop($parts);
            self::create(implode(',', $parts), true);
        }

    }
    
    /**
     * 
     * @param type $prop
     * @param type $value
     * @return void
     */
    private static function JSON($prop, $value): void{
        header('Content-Type: application/json');
        echo json_encode([$prop => $value]);
        exit();
    }

}