<?php

class subscriptionsModel extends Database
{

    public function registerSubscriber(string $email) :bool {
        $pdo = $this->getInstance();
        $sql = 'INSERT INTO subscribers (email) VALUES (:email)';
        $stm = $pdo->prepare($sql);
        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $res = $stm->execute();
        return $res;
    }

}