<?php

class billing {

  private $contracts = array ();
  private $discounts = array (10, 20, 25);
  private $level = 0;
  private $providerPrice = 0;
  private $providers = array ();
  private $result;
  private $users = array ();

  function __construct ($level = 1) {
    $this->level = $level;
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
      $contract = $this->getContract ($user['id']);
      $price = $this->getProviderPrice ($contract['provider_id']);
      $discount = $this->getDiscount ($contract['contract_length']);
      $total = $user['yearly_consumption'] * $price;
      $this->result['bills'][$counter]['id'] = $counter;
      $this->result['bills'][$counter]['price'] = ($total - ($total * $discount) / 100);
      $this->result['bills'][$counter]['user_id'] = $user['id'];
      $counter++;
    }
  }

  private function getContract ($userId) {
    foreach ($this->contracts as $contract) {
      if ($contract['user_id'] == $userId) {
        return $contract;
      }
    }
  }

  private function getDiscount ($length) {
    if ($length <= 1) {
      return $this->discounts[0];
    } elseif ($length <= 3) {
      return $this->discounts[1];
    } elseif ($length > 3) {
      return $this->discounts[2];
    }

    return 0;
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