#!/bin/bash
cd /usr/share/nginx/html/
model=$1
tensor=$2
/usr/bin/python3 datasetting.py $model $tensor &
