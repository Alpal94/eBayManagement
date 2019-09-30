#!/bin/bash

cd /home/pi/eBayManagement/production
php orderFetch.php processOrders
php octoPrintControl.php production
