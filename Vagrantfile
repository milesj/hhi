Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
  end

  config.vm.provision "shell", inline: <<-SHELL
    sudo add-apt-repository ppa:ondrej/php5-5.6
    sudo apt-get update
    sudo apt-get upgrade
    sudo apt-get install -y php5 php5-curl php5-intl php5-redis php-apc php5-memcached
  SHELL
end
