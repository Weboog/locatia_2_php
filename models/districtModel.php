<?php

class districtModel extends Database {

  public function getZones($city) {

        $pdo = $this->getInstance();
        $sql = 'SELECT districts.district FROM districts WHERE districts.city = :city';
        $stm = $pdo->prepare($sql);
        $stm->bindParam(':city', $city, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $result;

  }

}
