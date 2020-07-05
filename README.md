# convolutional-neural-network
repositori ini adalah repositori project deteksi wanita berhijab atau tidak dengan deep learning convolutional neural network, untuk memudahkan project ini dibuat dengan dockerized

## Required
install docker => version 19 keatas
install docker-compose  => version  1.20 keatas

## Installation
- git clone https://github.com/najcardboyz/convolutional-neural-network.git
- cd convolutional-neural-network
- docker-compose build (running pertama kali)
- setelah selesai => ctrl + c
- docker-compose up -d (running service)
- docker-compose down (stop service)

## Port Mapping
- localhost:8080 => project utama
- localhost:8082 => database
- localhost:8084 => jupyter notebook

## Trained Model
- model 2500 data perkategori     => https://drive.google.com/drive/folders/1BTAvsBCpPT7awYNySvTvtc5gREWJk1dt?usp=sharing
- model 5000 data perkategori     => https://drive.google.com/drive/folders/1KhHPfadwppBtXRsSWgOR3ExU7ls2abdL?usp=sharing
- model 2500 data perkategori acak  => https://drive.google.com/drive/folders/183k0VLYnIZcZwrldULc5YrNMmEhpq6Pz?usp=sharing
- model 5000 data perkategori acak => https://drive.google.com/drive/folders/1izWwe3ra1cHV_fMTds3Wj35HwgkfrYLW?usp=sharing
- copy file download ke `docker-web/model`
