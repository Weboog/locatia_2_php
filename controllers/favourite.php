<?php

class Favourite extends Controller
{

    public function index()
    {
        $this->render('index', $this->getModel()->getFavourite(Cookie::get(Cookie::FORMAT_ARRAY)));
    }

    public function add($appart)
    {
        Cookie::add($appart);
    }

    //simple cookie listing for content
    public function show()
    {
        echo Cookie::get(Cookie::FORMAT_STR);
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