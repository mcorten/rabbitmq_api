# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
	config.vm.box = "ubuntu/trusty64"

	config.vm.define "web" do |web|
		web.vm.network "private_network", ip: "192.168.33.10"
		web.vm.network "forwarded_port", guest: 80, host: 8080
		web.vm.provision :shell, path: "setup/bootstrap_webserver.sh"

		web.vm.provider "virtualbox" do |vbox|
			vbox.memory = 1024
			vbox.cpus = 2
		end
	end

	config.vm.define "messagequeue" do |messagequeue|
		messagequeue.vm.network "private_network", ip: "192.168.33.11"
		messagequeue.vm.provision :shell, :path => "setup/messagequeue_setup.sh", privileged: false

		messagequeue.vm.provider "virtualbox" do |vbox|
			vbox.memory = 1024
			vbox.cpus = 2
		end
	end
end
