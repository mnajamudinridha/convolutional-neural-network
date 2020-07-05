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
import cv2
import math
import numpy as np
from PIL import Image
import matplotlib.pyplot as plt
from sklearn.model_selection import train_test_split

import logging
logging.disable(logging.WARNING) 
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "3"

from tensorflow import keras
from keras.models import Sequential
from keras.layers import Conv2D,MaxPooling2D,Dense,Flatten,Dropout
from keras.layers.normalization import BatchNormalization
from keras.models import model_from_json

print("Loaded all libraries")

# fungsi untuk load image & label
def load_images_and_labels(categories, fpath):
    img_lst=[]
    labels=[]
    for index, category in enumerate(categories):
        for image_name in os.listdir(fpath+"/"+category):
            img = cv2.imread(fpath+"/"+category+"/"+image_name)
            img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
            img_array = Image.fromarray(img, 'RGB')
            #resize image to 227 x 227 because the input image resolution for AlexNet is 227 x 227
            resized_img = img_array.resize((227, 227))
            img_lst.append(np.array(resized_img))
            labels.append(index)
    return img_lst, labels
print("Loaded function load images and label")


import sys
learning = sys.argv[1]
num_epochs = sys.argv[2]
batchsize = sys.argv[3]
dropout_rate = sys.argv[4]
print("Learning Rate    : "+learning)
print("Number of Epochs : "+num_epochs)
print("Batch Size       : "+batchsize)
print("Dropout Rate     : "+dropout_rate)

import warnings
warnings.filterwarnings("ignore")

def alexnet_model():
    model=Sequential()

    #1 conv layer
    model.add(Conv2D(filters=96,kernel_size=(11,11),strides=(4,4),padding="valid",activation="relu",
                     input_shape=(227,227,3)))

    #1 max pool layer
    model.add(MaxPooling2D(pool_size=(3,3),strides=(2,2)))

    #2 conv layer
    model.add(Conv2D(filters=256,kernel_size=(5,5),strides=(1,1),padding="valid",activation="relu"))

    #2 max pool layer
    model.add(MaxPooling2D(pool_size=(3,3),strides=(2,2)))

    #3 conv layer
    model.add(Conv2D(filters=384,kernel_size=(3,3),strides=(1,1),padding="valid",activation="relu"))

    #4 conv layer
    model.add(Conv2D(filters=384,kernel_size=(3,3),strides=(1,1),padding="valid",activation="relu"))

    #5 conv layer
    model.add(Conv2D(filters=256,kernel_size=(3,3),strides=(1,1),padding="valid",activation="relu"))

    #3 max pool layer
    model.add(MaxPooling2D(pool_size=(3,3),strides=(2,2)))
    model.add(Flatten())

    #1 dense layer
    model.add(Dense(4096,input_shape=(227,227,3),activation="relu"))
    model.add(Dropout(float(dropout_rate)))

    #2 dense layer
    model.add(Dense(4096,activation="relu"))
    model.add(Dropout(float(dropout_rate)))

    #3 dense layer
    model.add(Dense(1000,activation="relu"))
    model.add(Dropout(float(dropout_rate)))

    #output layer
    model.add(Dense(2,activation="softmax"))
    
    # learning_rate: float >= 0. Learning rate.
    # beta_1: float, 0 < beta < 1. Generally close to 1.
    # beta_2: float, 0 < beta < 1. Generally close to 1.
    # amsgrad: boolean. Whether to apply the AMSGrad variant of this algorithm from the paper "On the Convergence of Adam and Beyond".
    keras.optimizers.Adam(learning_rate=float(learning), beta_1=0.9, beta_2=0.999, amsgrad=False)
    model.compile(optimizer="adam", loss="sparse_categorical_crossentropy", metrics=["accuracy"])
    #model.compile(Adam(lr=0.001), loss = "categorical_crossentropy", metrics = ["accuracy"])
    
    return model

# # Learning params
# learning_rate = 0.0001
# num_epochs = 20
# batch_size = 64

model = alexnet_model()
# perintah dataset 2500 train
fpath            = "dataset/train"
categories       = os.listdir(fpath)
categories       = categories[:20]

fpath_val        = "dataset/val"
categories_val   = os.listdir(fpath_val)
categories_val   = categories_val[:20]

images, labels          = load_images_and_labels(categories, fpath)
images_val, labels_val  = load_images_and_labels(categories_val, fpath_val)

images = np.array(images)
labels = np.array(labels)

images_val = np.array(images_val)
labels_val = np.array(labels_val)

images = images.astype(np.float32)
labels = labels.astype(np.int32)
images = images/255

images_val = images_val.astype(np.float32)
labels_val = labels_val.astype(np.int32)
images_val = images_val/255


tbCallBack = keras.callbacks.TensorBoard(log_dir='./model/tensorboard-save/tensorboard-default', histogram_freq=0, write_graph=True, write_images=True)
h = model.fit(images, labels, epochs=int(num_epochs), validation_data = (images_val, labels_val), 
              batch_size=int(batchsize), verbose=1, shuffle=1, callbacks=[tbCallBack])

model_json = model.to_json()
with open("model/model-save/model-default.json", "w") as json_file:
    json_file.write(model_json)
# serialize weights to HDF5
model.save_weights("model/model-save/model-default.h5")
print("Saved model to disk")


# # Network params
# dropout_rate = 0.5
# num_classes = 2
# # train_layers = ['fc8', 'fc7', 'fc6']
# train_layers = ['fc8','fc7','fc6','conv5','conv4','conv3','conv2','conv1']

# # How often we want to write the tf.summary data to disk
# display_step = 1

# # Path for tf.summary.FileWriter and to store model checkpoints
# filewriter_path = "./tensorboard"
# checkpoint_path = "./checkpoints"

# """
# Main Part of the finetuning Script.
# """

# # Create parent path if it doesn't exist
# if not os.path.isdir(checkpoint_path):
#     os.mkdir(checkpoint_path)

# # Place data loading and preprocessing on the cpu
# with tf.device('/cpu:0'):
#     tr_data = ImageDataGenerator(train_file,
#                                  mode='training',
#                                  batch_size=batch_size,
#                                  num_classes=num_classes,
#                                  shuffle=True)
#     val_data = ImageDataGenerator(val_file,
#                                   mode='inference',
#                                   batch_size=batch_size,
#                                   num_classes=num_classes,
#                                   shuffle=False)

#     # create an reinitializable iterator given the dataset structure
#     iterator = Iterator.from_structure(tr_data.data.output_types,
#                                        tr_data.data.output_shapes)
#     next_batch = iterator.get_next()

# # Ops for initializing the two different iterators
# training_init_op = iterator.make_initializer(tr_data.data)
# validation_init_op = iterator.make_initializer(val_data.data)

# # TF placeholder for graph input and output
# x = tf.placeholder(tf.float32, [batch_size, 227, 227, 3])
# y = tf.placeholder(tf.float32, [batch_size, num_classes])
# keep_prob = tf.placeholder(tf.float32)

# # Initialize model
# model = AlexNet(x, keep_prob, num_classes, train_layers)

# # Link variable to model output
# score = model.fc8

# # List of trainable variables of the layers we want to train
# var_list = [v for v in tf.trainable_variables() if v.name.split('/')[0] in train_layers]

# # Op for calculating the loss
# with tf.name_scope("cross_ent"):
#     loss = tf.reduce_mean(tf.nn.softmax_cross_entropy_with_logits_v2(logits=score,
#                                                                      labels=y))

# # Train op
# with tf.name_scope("train"):
#     # Get gradients of all trainable variables
#     gradients = tf.gradients(loss, var_list)
#     gradients = list(zip(gradients, var_list))

#     # Create optimizer and apply gradient descent to the trainable variables
#     optimizer = tf.train.GradientDescentOptimizer(learning_rate)
#     train_op = optimizer.apply_gradients(grads_and_vars=gradients)

# # Add gradients to summary
# for gradient, var in gradients:
#     tf.summary.histogram(var.name + '/gradient', gradient)

# # Add the variables we train to the summary
# for var in var_list:
#     tf.summary.histogram(var.name, var)

# # Add the loss to summary
# tf.summary.scalar('cross_entropy', loss)


# # Evaluation op: Accuracy of the model
# with tf.name_scope("accuracy"):
#     correct_pred = tf.equal(tf.argmax(score, 1), tf.argmax(y, 1))
#     accuracy = tf.reduce_mean(tf.cast(correct_pred, tf.float32))

# # Add the accuracy to the summary
# tf.summary.scalar('accuracy', accuracy)

# # Merge all summaries together
# merged_summary = tf.summary.merge_all()

# # Initialize the FileWriter
# writer = tf.summary.FileWriter(filewriter_path)

# # Initialize an saver for store model checkpoints
# saver = tf.train.Saver()

# # Get the number of training/validation steps per epoch
# train_batches_per_epoch = int(np.floor(tr_data.data_size/batch_size))
# val_batches_per_epoch = int(np.floor(val_data.data_size/batch_size))

# # Start Tensorflow session
# with tf.Session() as sess:

#     # Initialize all variables
#     sess.run(tf.global_variables_initializer())

#     # Add the model graph to TensorBoard
#     writer.add_graph(sess.graph)

#     # Load the pretrained weights into the non-trainable layer
#     # model.load_initial_weights(sess)

#     print("{} Start training...".format(datetime.now()))
#     print("{} Open Tensorboard at --logdir {}".format(datetime.now(),
#                                                       filewriter_path))

#     # Loop over number of epochs
#     for epoch in range(num_epochs):

#         print("{} Epoch number: {}".format(datetime.now(), epoch+1))

#         # Initialize iterator with the training dataset
#         sess.run(training_init_op)

#         for step in range(train_batches_per_epoch):

#             # get next batch of data
#             img_batch, label_batch = sess.run(next_batch)

#             # And run the training op
#             sess.run(train_op, feed_dict={x: img_batch,
#                                           y: label_batch,
#                                           keep_prob: dropout_rate})

#             # Generate summary with the current batch of data and write to file
#             if step % display_step == 0:
#                 s = sess.run(merged_summary, feed_dict={x: img_batch,
#                                                         y: label_batch,
#                                                         keep_prob: 1.})

#                 writer.add_summary(s, epoch*train_batches_per_epoch + step)

#         # Validate the model on the entire validation set
#         print("{} Start validation".format(datetime.now()))
#         sess.run(validation_init_op)
#         test_acc = 0.
#         test_count = 0
#         for _ in range(val_batches_per_epoch):

#             img_batch, label_batch = sess.run(next_batch)
#             acc = sess.run(accuracy, feed_dict={x: img_batch,
#                                                 y: label_batch,
#                                                 keep_prob: 1.})
#             test_acc += acc
#             test_count += 1
#         if test_acc != 0:
#             test_acc /= test_count
#         else:
#             test_acc = 0
#         print("{} Validation Accuracy = {:.4f}".format(datetime.now(),
#                                                        test_acc))
#         print("{} Saving checkpoint of model...".format(datetime.now()))

#         # save checkpoint of the model
#         checkpoint_name = os.path.join(checkpoint_path,
#                                        'model_epoch'+str(epoch+1)+'.ckpt')
#         save_path = saver.save(sess, checkpoint_name)

#         print("{} Model checkpoint saved at {}".format(datetime.now(),
#                                                        checkpoint_name))




def alexnet_model_normalization():
    model=Sequential()
    #1 conv layer
    model.add(Conv2D(filters=96,kernel_size=(11,11),strides=(4,4),padding="valid",activation="relu",input_shape=(227,227,3)))

    #1 max pool layer
    model.add(MaxPooling2D(pool_size=(3,3),strides=(2,2)))

    model.add(BatchNormalization())
    #2 conv layer
    model.add(Conv2D(filters=256,kernel_size=(5,5),strides=(1,1),padding="valid",activation="relu"))

    #2 max pool layer
    model.add(MaxPooling2D(pool_size=(3,3),strides=(2,2)))

    model.add(BatchNormalization())

    #3 conv layer
    model.add(Conv2D(filters=384,kernel_size=(3,3),strides=(1,1),padding="valid",activation="relu"))

    #4 conv layer
    model.add(Conv2D(filters=384,kernel_size=(3,3),strides=(1,1),padding="valid",activation="relu"))

    #5 conv layer
    model.add(Conv2D(filters=256,kernel_size=(3,3),strides=(1,1),padding="valid",activation="relu"))

    #3 max pool layer
    model.add(MaxPooling2D(pool_size=(3,3),strides=(2,2)))

    model.add(BatchNormalization())

    model.add(Flatten())

    #1 dense layer
    model.add(Dense(4096,input_shape=(227,227,3),activation="relu"))

    model.add(Dropout(0.4))

    model.add(BatchNormalization())

    #2 dense layer
    model.add(Dense(4096,activation="relu"))

    model.add(Dropout(0.4))

    model.add(BatchNormalization())

    #3 dense layer
    model.add(Dense(1000,activation="relu"))

    model.add(Dropout(0.4))

    model.add(BatchNormalization())

    #output layer
    model.add(Dense(20,activation="softmax"))

    # learning_rate: float >= 0. Learning rate.
    # beta_1: float, 0 < beta < 1. Generally close to 1.
    # beta_2: float, 0 < beta < 1. Generally close to 1.
    # amsgrad: boolean. Whether to apply the AMSGrad variant of this algorithm from the paper "On the Convergence of Adam and Beyond".
    keras.optimizers.Adam(learning_rate=0.0001, beta_1=0.9, beta_2=0.999, amsgrad=False)
    model.compile(optimizer="adam", loss="sparse_categorical_crossentropy", metrics=["accuracy"])
    #model.compile(Adam(lr=0.001), loss = "categorical_crossentropy", metrics = ["accuracy"])
    return model
