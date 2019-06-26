<?php


class callbackModel extends Database
{

    public function save($post){
        $pdo = $this->getInstance();
        $sql = 'insert into callbacks (appart, email, name, phone) values (:appart, :email, :name, :phone)';
        $stm = $pdo->prepare($sql);
        $stm->bindParam(':appart', $post['appart'], PDO::PARAM_STR);
        $stm->bindParam(':email', $post['email'], PDO::PARAM_STR);
        $stm->bindParam(':name', $post['name'], PDO::PARAM_STR);
        $stm->bindParam(':phone', $post['phone'], PDO::PARAM_STR);
        $res = $stm->execute();
        return $res;
    }

}