<?php

include 'octoPrintControl.php';

$OctoPrint = new OctoPrint();
echo $OctoPrint->isPrinterAvailable();
echo $OctoPrint->listFiles();

?>
