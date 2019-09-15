<?php

include 'orderFetch.php';

$devManagement = new Management();
$devManagement->reprintLabelsDaysAgo($argv[1]);

?>
