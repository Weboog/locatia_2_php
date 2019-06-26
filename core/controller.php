<?php


class Controller
{

    public function render($file_name, $data = array()) {
        if (isset($data)) extract($data);
        ob_start();
        require ROOT . DS . 'views' . DS . strtolower(get_class($this)) . DS . $file_name . '.php';
        $content = ob_get_clean();
        echo $content;
    }

    public function getModel() {
        $model = strtolower(get_class($this)) . 'Model';
        require_once MODELS . DS . $model . '.php';
        return new $model();
    }

}
