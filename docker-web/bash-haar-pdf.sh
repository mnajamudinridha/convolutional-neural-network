#!/bin/bash
cd /usr/share/nginx/html/
rm -rf files-tmp/*
#/usr/bin/convert files/*.pdf files-tmp/output-image-%d.jpg


for file in files/*.pdf
do
    var=$((var+1))
    echo $file
    /usr/bin/pdfimages -j "$file" "files-tmp/$var-output"
done

/usr/bin/python3 validate-haar-pdf.py  > validate-haar-pdf.txt &
