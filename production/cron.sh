#!/bin/bash

cd /root/eBayManagement/production
php orderFetch.php processOrders
php octoPrintControl.php production
