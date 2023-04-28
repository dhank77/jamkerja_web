import cv2
import face_recognition
import sys
import json

image1 = sys.argv[1]
imageCv1 = face_recognition.load_image_file(image1)
# imageEn1 = cv2.cvtColor(imageCv1, cv2.COLOR_BGR2GRAY)
l1 = face_recognition.face_locations(imageCv1)[0]
encode1 = face_recognition.face_encodings(imageCv1)[0]

image2 = sys.argv[2]
imageCv2 = face_recognition.load_image_file(image2)
# image2 = cv2.cvtColor(imageCv2, cv2.COLOR_BGR2GRAY)
encode2 = face_recognition.face_encodings(imageCv2)[0]

hasil = face_recognition.compare_faces([encode1], encode2)
persamaan = face_recognition.face_distance([encode1], encode2)

# print(hasil[0], persamaan[0])

if (hasil[0]):
    response={'mirip': 'true','persamaan': persamaan[0] }
    print(json.JSONEncoder().encode(response))
else:
    response={'mirip': 'false','persamaan':'no_face'}
    print(json.JSONEncoder().encode(response))

