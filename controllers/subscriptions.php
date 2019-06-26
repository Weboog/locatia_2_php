<?php

class subscriptions extends Controller
{

    public function add() :void
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
                echo json_encode(
                    array(
                        'status' => 2,
                        'message' => 'Adresse courriel au format invalide.'
                    )
                );
            }
        }
    }
}