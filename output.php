<?php

require_once ('classes/billing.php');

$billing = new billing (2);
$billing->calculateBillForUsers ();
$billing->showResult ();

?>