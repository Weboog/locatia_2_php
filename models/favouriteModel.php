<?php

class FavouriteModel extends Database
{
    public function getFavourite($arr_fav){

        if (is_null($arr_fav) || $arr_fav === false) return false;

        $pdo = $this->getInstance();
        $sql = 'SELECT a.id, a.serial, a.pieces, a.surface, a.rooms, a.zone, a.price, a.views, a.gallery, p.type, c.city, d.district
                FROM appartments AS a
                   LEFT JOIN products p ON a.type = p.id
                   LEFT JOIN cities c ON a.city = c.id
                   LEFT JOIN districts d ON a.zone = d.id
                where a.id = '.$arr_fav[0];
        unset($arr_fav[0]);
        foreach ($arr_fav as $id){
            $sql .= ' or a.id = '. $id;
        }
        return $pdo->query($sql)->fetchAll();
    }
}