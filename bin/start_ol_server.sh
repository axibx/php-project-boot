#!/bin/bash

php ../boot/daemon.php start
php -S 0.0.0.0:8080 -t ../public ../public/index.php