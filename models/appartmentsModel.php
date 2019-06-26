<?php

class AppartmentsModel extends Database {

    private static $LIMIT = 3;
    private static $SENSES = array('low' => 'ASC', 'high' => 'DESC');

    public function index(){

        echo 'this method was charged from Model Appartments';
    }

    public function getAll(){

        $pdo = $this->getInstance();
        $sql = 'SELECT * FROM appartments ORDER BY appartments.id DESC';
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param integer $num
     * @return array
     */

    public function getPage(){

        $num = func_get_arg(0);
        if(array_key_exists(1, func_get_args())) $flag = func_get_arg(1);
        if(array_key_exists(2, func_get_args())) $params = func_get_arg(2);

        $pdo = $this->getInstance();
        $base_sql = 'SELECT a.id, a.serial, p.type, c.city, d.district, a.borough, a.address, a.pieces, a.rooms, a.surface, a.price, a.views, a.gallery FROM appartments as a 
                      LEFT JOIN products p ON a.type = p.id
                      LEFT JOIN cities c ON a.city = c.id
                      LEFT JOIN districts d ON a.zone = d.id';

        $sql = $base_sql . ' LIMIT :s,:c';
        $stm = $pdo->prepare($sql);
        $offset = self::$LIMIT * ($num-1);
        $stm->bindParam(':s', $offset, PDO::PARAM_INT);
        $stm->bindParam(':c', self::$LIMIT, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFiltered($flag, $params, $num = 1){

        $pdo = $this->getInstance();
        $base_sql = 'SELECT a.id, a.serial, p.type, c.city, d.district, a.borough, a.address, a.pieces, a.rooms, a.surface, a.price, a.views,a.gallery FROM appartments as a 
                      LEFT JOIN products p ON a.type = p.id
                      LEFT JOIN cities c ON a.city = c.id
                      LEFT JOIN districts d ON a.zone = d.id';

        if(is_array($params)){
            $interval = array_combine(array('min', 'max'), $params);
            $sql = $base_sql . ' WHERE '.$flag.' BETWEEN :min AND :max ORDER BY '. $flag .' ASC LIMIT :s,:c';
            $offset = self::$LIMIT * ($num-1);
            $stm = $pdo->prepare($sql);
            $stm->bindParam(':min', $interval['min'], PDO::PARAM_INT);
            $stm->bindParam(':max', $interval['max'], PDO::PARAM_INT);
            $stm->bindParam(':s', $offset, PDO::PARAM_INT);
            $stm->bindParam(':c', self::$LIMIT, PDO::PARAM_INT);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }elseif (is_string($params)){
            $sql = $base_sql . ' ORDER BY '. $flag .' '.self::$SENSES[$params].' LIMIT :s,:c';
            $offset = self::$LIMIT * ($num-1);
            $stm = $pdo->prepare($sql);
            $stm->bindParam(':s', $offset, PDO::PARAM_INT);
            $stm->bindParam(':c', self::$LIMIT, PDO::PARAM_INT);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    /**
     *
     * @return boolean if not found
     * @return array
     */

    public function getDetails(){
        $id = array_key_exists(0, func_get_args()) ? func_get_arg(0) : '';
        $pdo = $this->getInstance();
        $sql = 'SELECT *,a.id, p.type, c.city, d.district FROM appartments AS a
                LEFT JOIN products p ON a.type = p.id
                LEFT JOIN cities c ON a.city = c.id
                LEFT JOIN districts d ON a.zone = d.id
                WHERE a.id=  :id';
        $stm = $pdo->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function registerSubscriber($email){
        $pdo = $this->getInstance();
        $sql = 'INSERT INTO subscribers (email) VALUES (:email)';
        $stm = $pdo->prepare($sql);
        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $res = $stm->execute();
        return $res;
    }

    public function incrementView($id){

        $pdo = $this->getInstance();
        $sql = '
                UPDATE appartments a
                SET a.views = a.views+1
                WHERE a.id = :id '
        ;
        $stm = $pdo->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

}