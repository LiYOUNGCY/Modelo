#!/bin/bash

currentPath=`pwd`
touch cron
echo "* * * * * php $currentPath/artisan schedule:run >> /dev/null 2>&1" > cron
crontab < cron
