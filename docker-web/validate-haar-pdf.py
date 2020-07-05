import os
import glob
import cv2
#delete function
import shutil
#hilangkan warning
import warnings
warnings.filterwarnings("ignore")

#untuk process convert (diganti jadi pdfimages)
# import subprocess
# print ("start convert pdf to jpg")
# current_dir = os.getcwd()
# subprocess.call(["/usr/bin/convert", (current_dir+ "/files/*.pdf"), (current_dir +"/files-tmp/output-image-%d.png")])

extensions = ("*.png","*.jpg","*.jpeg")
searchedfile = []
for extension in extensions:
        searchedfile = searchedfile + glob.glob("./files-tmp/" + extension)

# searchedfile = glob.glob('./files-img/*.png')
# print(searchedfile)
#sorting image berdasarkan tanggal
searchedfile.sort(key=os.path.getmtime)
size = 1
classifier = cv2.CascadeClassifier('/usr/share/nginx/html/haarxml/haarcascade_frontalface_alt.xml')
nomor = 0

# Delete Folder
current_dir = os.getcwd()
image_dir_delete = os.path.join(current_dir, 'images/')
shutil.rmtree(image_dir_delete)
os.mkdir(image_dir_delete)
print("refresh hasil sebelumnya, generate ulang face detection")

for filename in searchedfile:
    im = cv2.imread(filename)
    mini = cv2.resize(im, (int(im.shape[1] / size), int(im.shape[0] / size)))
    # detect MultiScale / faces 
    #faces = classifier.detectMultiScale(mini)
    
    #convert the test image to gray image as opencv face detector expects gray images
    #let's detect multiscale (some images may be closer to camera than others) images
    #faces = classifier.detectMultiScale(mini)
    faces = classifier.detectMultiScale(mini, scaleFactor=1.1, minNeighbors=5)

    # Draw rectangles around each face
    for f in faces:
        (x, y, w, h) = [v * size for v in f] #Scale the shapesize backup
        # garis kotak
        # cv2.rectangle(mini, (x, y), (x + w, y + h),(0,255,0),thickness=4)
        # Save just the rectangle faces in SubRecFaces
        # sub_face = mini[max(0, y-int(h/2)):y+h+(h*2), max(0,x-int(w/2)):x+w+int(w/2)]
        # sub_face = im[y:y+h, x:x+w]
        nomor = nomor + 1
        sub_face = mini[max(0, y-int(h/2)):y+h+(h*2), max(0,x-int(w/2)):x+w+int(w/2)]
        FaceFileName = "./images/face_" + ("%08g" % (nomor)) +".jpg"
        print("ditemukan wajah baru di : "+FaceFileName)
        cv2.imwrite(FaceFileName, sub_face)


print("PROSES SELESAI !!!")