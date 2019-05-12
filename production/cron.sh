#!/bin/bash

cd /root/eBayManagement/production
php orderFetch.php
php octoPrintControl.php
