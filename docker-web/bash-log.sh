#!/bin/bash
cd /usr/share/nginx/html/model/tensorboard-save
tensor=$1
# /usr/local/bin/tensorboard --logdir=$tensor/ &
/usr/local/bin/tensorboard --logdir=$tensor/ --bind_all &