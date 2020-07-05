"""Script to finetune AlexNet using Tensorflow.

With this script you can finetune AlexNet as provided in the alexnet.py
class on any given dataset. Specify the configuration settings at the
beginning according to your problem.
This script was written for TensorFlow >= version 1.2rc0 and comes with a blog
post, which you can find here:

https://kratzert.github.io/2017/02/24/finetuning-alexnet-with-tensorflow.html

Author: Frederik Kratzert
contact: f.kratzert(at)gmail.com
"""

import os
import sys
import configparser

model = sys.argv[1]
tensor = sys.argv[2]
print("Model       : "+model)
print("Tensorboard : "+tensor)


# set config
config = configparser.ConfigParser()
config.read("setting-model.txt")
config.set("config-model", "model", model)
config.set("config-model", "tensorboard", tensor)
with open('setting-model.txt', 'w') as configfile:
    config.write(configfile)