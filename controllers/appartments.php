<?php


class Appartments extends Controller
{

    private static $FLAG_PRICE = 'price';
    private static $FLAG_SURFACE = 'surface';
    private static $FLAG_PIECES = 'pieces';
    //Using params for flag
    private static $SENSE_LOW = 'low';
    private static $SENSE_HIGH = 'high';
    //Returns
    public static $FLAG;
    public static $PARAMS;
    public static $PAGE;
    //Request URI
    public static $REQ_URI;

    public function index()
    {
        $this->page(1);
    }

    public function page($num)
    {
        if (!is_numeric($num) || count($this->getModel()->getPage($num)) === 0) {
            include_once VIEWS . DS . 'error404.php';
        } else {
            $this->render('page', $this->getModel()->getPage($num));
        }
    }

    public function filter(){

        if (array_key_exists(0, func_get_args()) && array_key_exists(1, func_get_args()) && array_key_exists(2, func_get_args())){
            self::filterArgs(func_get_args());
            if (count($this->getModel()->getFiltered(self::$FLAG, self::$PARAMS, self::$PAGE)) === 0){
                include_once VIEWS . DS . 'error404.php';
            }else{
                $this->render('filter', $this->getModel()->getFiltered(self::$FLAG, self::$PARAMS, self::$PAGE));
            }
        }else{
            include_once VIEWS . DS . 'error404.php';
        }

    }

    public function details(){
        $id = array_key_exists(0, func_get_args()) ? func_get_arg(0) : '';
        $id = substr($id, 3);
        if (!is_numeric($id) || $this->getModel()->getDetails($id) === false) {
            include_once VIEWS . DS . 'error404.php';
        } else {
            $this->render('details', $this->getModel()->getDetails($id));
            $this->getModel()->incrementView($id);
            /*echo '<pre>';
            print_r($this->getModel()->getDetails($id));
            echo '</pre>';*/
        }
    }

    public function subscribe()
    {

        if(isset($_POST['email'])){

            $email = new Widget(Widget::$TYPE_EMAIL, $_POST['email']);

            if ($email->is_valid() !== false){

                if ($this->getModel()->registerSubscriber($email->getValue())){
                    //throw as json status 1
                    echo  json_encode(
                        array(
                            'status' => 1,
                            'message' => 'Inscription réussie.'
                        )
                    );
                }else{
                    //throw as json status 0
                    echo  json_encode(
                        array(
                            'status' => 0,
                            'message' => 'Vous êtes déjà inscrit, merci.'
                        )
                    );
                }

            }else{
                //throw as json status 2
                echo  json_encode(
                    array(
                        'status' => 2,
                        'message' => 'Adresse courriel au format invalide.'
                    )
                );
            }
        }
    }

    private static function filterArgs($arguments){

        //Array ( [0] => price [1] => low [2] => 3 )
        //Combine to create an associative array
            $args = array_combine(array('flag', 'params', 'page'), $arguments);

            if (isset($args['flag']) && isset($args['params'])) {
                //Params as keyword
                if (in_array($args['flag'], array(self::$FLAG_PRICE, self::$FLAG_SURFACE, self::$FLAG_PIECES))) {
                    self::$FLAG = $args['flag'];
                    if (in_array($args['params'], array(self::$SENSE_LOW, self::$SENSE_HIGH))) {
                        self::$PARAMS = $args['params'];
                    }
                    //Params as interval
                    if (strpos($args['params'], '-') !== false) {
                        $interval = explode('-', $args['params']);
                        if (is_numeric($interval[0]) && is_numeric($interval[1])) {
                            self::$PARAMS = array_combine(array('min', 'max'), $interval);
                        }
                    }
                    //Page assign
                    if (is_numeric($args['page']) && $args['page'] > 0){
                        self::$PAGE = $args['page'];
                    }
                }
            }
    }

}