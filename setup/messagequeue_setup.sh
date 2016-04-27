#!/usr/bin/env bash

sudo apt-get update
sudo apt-get upgrade -y


wget --progress=bar:force http://www.rabbitmq.com/releases/rabbitmq-server/v3.5.7/rabbitmq-server_3.5.7-1_all.deb	#--progress=bar:force added so the output would be clean: http://stackoverflow.com/questions/31086548/cleaner-output-when-downloading-files-in-a-vagrant-provisioning-script
sudo dpkg -i rabbitmq-server_3.5.7-1_all.deb

# rabbtimq server has unmet dependencies
#sudo apt-get update
sudo apt-get upgrade -yf

sudo service rabbitmq-server stop
sudo rabbitmq-plugins enable rabbitmq_management
sudo service rabbitmq-server start

# create users
sudo rabbitmqctl add_user admin admin
sudo rabbitmqctl set_user_tags admin administrator
sudo rabbitmqctl set_permissions -p / admin ".*" ".*" ".*"

sudo rabbitmqctl add_user example example

# create vhosts
sudo rabbitmqctl add_vhost /example/
sudo rabbitmqctl set_permissions -p /example/ admin ".*" ".*" ".*"
sudo rabbitmqctl set_permissions -p /example/ photoprocessing ".*" ".*" ".*"