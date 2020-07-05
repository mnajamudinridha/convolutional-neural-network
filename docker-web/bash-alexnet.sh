#!/bin/bash
cd /usr/share/nginx/html/
/usr/bin/python3 validate-alexnet.py  > validate-alexnet.txt &
