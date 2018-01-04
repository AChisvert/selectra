<?php

require_once ('classes/billing.php');

$billing = new billing (3);
$billing->calculateBillForUsers ();
$billing->showResult ();

?>