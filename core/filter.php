<?php


class Filter {

    private $_url = array('flag', 'params');

    private static $FLAG_BUDGET = 'budget';
    private static $FLAG_SURFACE = 'surface';
    private static $FLAG_PRICE = 'price';

    //Using params for flag
    private static $SENSE_LOW = 'low';
    private static $SENSE_HIGH = 'high';
    //Returns
    private static $FLAG;
    private static $PARAMS;

    public function __construct($url) {
        if($url[3] === 'filter' && !empty($url[4]) && !empty($url[5])){
            $this->_url = array_combine($this->_url, array($url[4], $url[5]));
        }else{
            include_once VIEWS. DS . 'error404.php';
            die();
        }
    }

    /**
     * @return string
     */
    public function getFlag(){
        if(!empty($this->_url['flag']) && in_array($this->_url['flag'], array(self::$FLAG_BUDGET, self::$FLAG_SURFACE, self::$FLAG_PRICE))){
            self::$FLAG = $this->_url['flag'];
        }
        return self::$FLAG;
    }


    /**
     * @return array|mixed
     */
    public function getFlagParams(){

        if(!empty($this->_url['params']) && in_array($this->_url['params'], array(self::$SENSE_LOW, self::$SENSE_HIGH))){
            self::$PARAMS = $this->_url['params'];
        };

        if(!empty($this->_url['params']) && strpos($this->_url['params'], '-') !== false){
            $interval = explode('-', $this->_url['params']);
            if (is_numeric($interval[0]) && is_numeric($interval[1])){
                self::$PARAMS = array_combine(array('min', 'max'), $interval);
            }
        }
        return self::$PARAMS;
    }
}