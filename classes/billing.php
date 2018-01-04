<?php

class billing {

  private $contracts = array ();
  private $providers = array ();
  private $result;
  private $users = array ();

  function __construct ($level = 1) {
    $data = json_decode (file_get_contents ('part1/level' . $level . '/data.json'), true);
    $this->providers = $data['providers'];
    $this->users = $data['users'];
    if (!empty ($data['contracts'])) {
      $this->contracts = $data['contracts'];
    }
  }

  public function calculateBillForUsers () {
    $this->result['bills'] = array ();
    $counter = 1;
    foreach ($this->users as $user) {
      $price = $this->getProviderPrice ($user['provider_id']);
      $this->result['bills'][$counter]['id'] = $counter;
      $this->result['bills'][$counter]['price'] = $user['yearly_consumption'] * $price;
      $this->result['bills'][$counter]['user_id'] = $user['id'];
      $counter++;
    }
  }

  private function getProviderPrice ($providerId) {
    foreach ($this->providers as $provider) {
      if ($provider['id'] == $providerId) {
        return $provider['price_per_kwh'];
      }
    }

    return 0;
  }

  public function showResult () {
    echo json_encode ($this->result);
    return;
  }

}

?>