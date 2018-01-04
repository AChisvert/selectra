<?php

require_once ('classes/billing.php');

$billing = new billing (4);
$billing->calculateBillForUsers ();
$billing->showResult ();

?>