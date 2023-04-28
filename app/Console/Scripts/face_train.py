import cv2
import numpy as np
from PIL import Image
import os
import re
import json
import sys

path = sys.argv[1]
scriptPath = sys.argv[2]
idfolder = sys.argv[3]
recognizer = cv2.face.LBPHFaceRecognizer_create()
detector = cv2.CascadeClassifier(scriptPath + '/haarcascade_frontalface_default.xml')


def getImagesAndLabels(path):
    imagePaths = [os.path.join(path, f) for f in os.listdir(path)]
    faceSamples = []
    ids = []

    for imagePath in imagePaths:
        PIL_img = Image.open(imagePath).convert('L')  # convert it to grayscale
        img_numpy = np.array(PIL_img, 'uint8')
        id = int(idfolder)
        faces = detector.detectMultiScale(img_numpy)
        for (x, y, w, h) in faces:
            faceSamples.append(img_numpy[y:y+h, x:x+w])
            ids.append(id)

    return faceSamples, ids


faces, ids = getImagesAndLabels(path)
if (faces):
    recognizer.train(faces, np.array(ids))

    pathnew = scriptPath + '/' + idfolder
    isExist = os.path.exists(pathnew)
    if not isExist:
        os.makedirs(pathnew)

    recognizer.write(pathnew + '/trainer.yml')
    response = {'status': 'success'}
    print(json.JSONEncoder().encode(response))
else:
    response = {'status': 'error'}
    print(json.JSONEncoder().encode(response))
