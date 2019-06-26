<?php


class Callback extends Controller
{

    public function add(){

        if (isset($_POST)){

            $name = new Widget(Widget::$TYPE_NAME, $_POST['name']);
            $email = new Widget(Widget::$TYPE_EMAIL, $_POST['email']);
            $phone = new Widget(Widget::$TYPE_PHONE, $_POST['phone']);

            if ($name->is_valid() === false){
                echo json_encode(
                    array(
                        'status' => 2,
                        'message' => 'Votre nom est au format invalide.'
                    )
                );
                return;
            }

            if ($email->is_valid() === false){
                echo json_encode(
                    array(
                        'status' => 2,
                        'message' => 'Adresse mail invalide.'
                    )
                );
                return;
            }

            if ($phone->is_valid() === false){
                echo json_encode(
                    array(
                        'status' => 2,
                        'message' => 'Numéro de téléphone au format invalide.'
                    )
                );
                return;
            }

            //Tests passed
            if ($this->getModel()->save($_POST)){
                echo  json_encode(
                    array(
                        'status' => 1,
                        'message' => 'Demande envoyée.'
                    )
                );
            }else{
                echo  json_encode(
                    array(
                        'status' => 0,
                        'message' => 'Impossible d\'envoyer la demande.'
                    )
                );
            }
        }
    }

}