<?php

require_once ('classes/billing.php');

$billing = new billing (1);
$billing->calculateBillForUsers ();
$billing->showResult ();

?>