<?php


require_once CORE . DS . 'cookie.php';

class Favourite extends Controller
{

    public function index()
    {
        $this->render('index', $this->getModel()->getFavourite(Cookie::getAsArray()));
    }

    public function add($id)
    {
        Cookie::add($id);
    }

    public function show()
    {   
        Cookie::getAsString();
    }

    public function delete($id = null)
    {
        Cookie::delete($id);
    }

    public function drop()
    {
        Cookie::drop();
    }
}