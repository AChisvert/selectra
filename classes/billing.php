<?php

class billing {

  // In €
  const GREEN_FEE = 0.05;
  // In €
  const INSURANCE_FEE = 0.05;
  // In %
  const SELECTRA_FEE = 12.5;

  private $contracts = array ();
  private $discounts = array (0.9, 0.8, 0.75);
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
      $greenFee = 0;
      if ($contract['green']) {
        $greenFee = $this->getGreenFee ($user['yearly_consumption']);
      }
      $price = $this->getProviderPrice ($contract['provider_id']);
      $discount = $this->getDiscount ($contract['contract_length']);
      $price *= $discount;
      $total = ($user['yearly_consumption'] * $price) - $greenFee;

      $insurance_fee = round ($this->getInsuranceFee ($contract['contract_length']), 2);
      $provider_fee = round ($total - $insurance_fee, 2);
      $selectra_fee = round (($provider_fee * self::SELECTRA_FEE) / 100, 2);

      $this->result['bills'][$counter]['commission'] = array (
        'insurance_fee' => $insurance_fee,
        'provider_fee' => $provider_fee,
        'selectra_fee' => $selectra_fee
        );

      $this->result['bills'][$counter]['id'] = $counter;
      $this->result['bills'][$counter]['price'] = $total;
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

  private function getGreenFee ($length) {
    return $length * self::GREEN_FEE;
  }

  private function getInsuranceFee ($length) {
    return ($length * 365 * self::INSURANCE_FEE);
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