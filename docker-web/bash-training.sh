#!/bin/bash
cd /usr/share/nginx/html/
learning_rate=$1
num_epochs=$2
batch_size=$3
dropout_rate=$4
patience=$5
/usr/bin/python3 datatraining.py $learning_rate $num_epochs $batch_size $dropout_rate $patience > validate-training.txt &
