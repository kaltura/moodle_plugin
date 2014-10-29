#!/bin/bash

BRANCH=`git branch | grep '*' |awk -F _ '{print $2}'`
VER=`cat local/kaltura/version.php |grep '>version' | awk '{print $3}' | awk -F ";" '{print $1}'`
zip -r Kaltura_Video_Package_moodle$BRANCH_$VER.zip lib filter mod local
