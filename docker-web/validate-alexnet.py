# #some basic imports and setups
# import os
# import cv2
# import numpy as np
# import tensorflow as tf
# import matplotlib.pyplot as plt
# #delete function
# import shutil

# #mean of imagenet dataset in BGR
# imagenet_mean = np.array([104., 117., 124.], dtype=np.float32)

# current_dir = os.getcwd()
# image_dir = os.path.join(current_dir, 'images')

# #get list of all images
# img_files = [os.path.join(image_dir, f) for f in os.listdir(image_dir) if f.endswith('.jpg')]

# #load all images
# imgs = []
# for f in img_files:
#     imgs.append(cv2.imread(f))

# # Delete image on output
# image_dir_delete1 = os.path.join(current_dir, 'output/hijab/')
# image_dir_delete2 = os.path.join(current_dir, 'output/non hijab/')
# shutil.rmtree(image_dir_delete1)
# shutil.rmtree(image_dir_delete2)
# os.mkdir(image_dir_delete1)
# os.mkdir(image_dir_delete2)

# from alexnet import AlexNet
# from caffe_classes import class_names

# #placeholder for input and dropout rate
# x = tf.placeholder(tf.float32, [1, 227, 227, 3])
# keep_prob = tf.placeholder(tf.float32)

# #create model with default config ( == no skip_layer and 1000 units in the last layer)
# #num class ganti jadi dua
# model = AlexNet(x, keep_prob, 2, [])

# #define activation of last layer as score
# score = model.fc8

# #create op to calculate softmax 
# softmax = tf.nn.softmax(score)

# saver = tf.train.Saver()

# with tf.Session() as sess:
    
#     # Initialize all variables
#     sess.run(tf.global_variables_initializer())
    
#     # Load the pretrained weights into the model
#     #model.load_initial_weights(sess)
#     ckpt = tf.train.get_checkpoint_state("./checkpoints/checkpoints")
#     saver.restore(sess, "./checkpoints/model_epoch20.ckpt")

#     # Loop over all images
#     nomor = 0
#     for i, image in enumerate(imgs):
        
#         # Convert image to float32 and resize to (227x227)
#         img = cv2.resize(image.astype(np.float32), (227,227))
        
#         # Subtract the ImageNet mean
#         img -= imagenet_mean
        
#         # Reshape as needed to feed into model
#         img = img.reshape((1,227,227,3))
        
#         # Run the session and calculate the class probability
#         probs = sess.run(softmax, feed_dict={x: img, keep_prob: 1})
#         # Get the class name of the class with the highest probability
#         class_name = class_names[np.argmax(probs)]
#         # Plot image with class name and prob in the title
#         nomor = nomor + 1
#         imgname = "./output/" + class_name + "/img-" + ("%04g" % (nomor)) + "-"+("%04g" % (probs[0,np.argmax(probs)])) + ".jpg"
#         print(imgname)
#         cv2.imwrite(imgname, image)

# print("PROSES SELESAI !!!")





import os
import cv2
import math
import numpy as np
import configparser
import shutil

from PIL import Image
import matplotlib.pyplot as plt
from sklearn.model_selection import train_test_split

from tensorflow import keras
from keras.models import Sequential
from keras.layers import Conv2D,MaxPooling2D,Dense,Flatten,Dropout
from keras.layers.normalization import BatchNormalization
from keras.models import model_from_json
from keras.models import Model
print("Loaded all libraries")

import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '2'

# get config
config = configparser.ConfigParser()
config.read("setting-model.txt")
var_a = config.get("config-model", "model")
# var_b = config.get("config-model", "tensorboard")
print("Loaded all config")

#load model
json_file = open('model/model-save/'+var_a+'.json', 'r')
loaded_model_json = json_file.read()
json_file.close()
loaded_model = model_from_json(loaded_model_json)
loaded_model.load_weights('model/model-save/'+var_a+".h5")
loaded_model.compile(optimizer="adam", loss="sparse_categorical_crossentropy", metrics=["accuracy"])
print("Loaded model from disk")

# # set config
# config.set("config-model", "model", "New-VAlue sss")
# config.set("config-model", "tensorboard", "New-dadad dadsss")
# with open('setting-model.txt', 'w') as configfile:
#     config.write(configfile)

# list all images
current_dir = os.getcwd()
image_dir = os.path.join(current_dir, 'images')
img_files = [os.path.join(image_dir, f) for f in os.listdir(image_dir) if f.endswith('.jpg')]

# Delete image on output
image_dir_delete1 = os.path.join(current_dir, 'output/hijab/')
image_dir_delete2 = os.path.join(current_dir, 'output/non hijab/')
shutil.rmtree(image_dir_delete1)
shutil.rmtree(image_dir_delete2)
os.mkdir(image_dir_delete1)
os.mkdir(image_dir_delete2)


def load_images_and_labels_prediction_test(prediction):
    img_lst=[]
    labels=[]
    img_out=[]
    for index, filename in enumerate(prediction):
        img = cv2.imread(filename)
        img_out = img
        img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        img_array = Image.fromarray(img, 'RGB')
        #resize image to 227 x 227 because the input image resolution for AlexNet is 227 x 227
        resized_img = img_array.resize((227, 227))
        img_lst.append(np.array(resized_img))
        labels.append(os.path.basename(filename))
    return img_lst, labels, img_out

nomor = 0
for face in img_files:
    x_img, y_img, img_out = load_images_and_labels_prediction_test([face])
    x_img = np.array(x_img)
    x_img = x_img.astype(np.float32)
    x_img = x_img/255
    image = x_img
    classes = loaded_model.predict_classes(x_img)
    probabi = loaded_model.predict_proba(x_img)
    nomor = nomor + 1
    class_name = ""
    if classes[0] == 1:
        class_name = "hijab"
    elif classes[0] == 0:
        class_name = "non hijab"
    imgname = "./output/" + class_name + "/img" + ("%04g" % (nomor)) + "-"+("%04g" % float(max(probabi[0]))) + ".jpg"
    print(imgname)
    cv2.imwrite(imgname, img_out)

print("PROSES SELESAI !!!")
