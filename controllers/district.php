<?php

class District extends Controller {

  public function all($city) {
    $result = $this->getModel()->getZones($city);
    echo json_encode(array('zones' => $result));
  }
}
