# MenuFinder
Backend et API REST permettant aux restaurateurs de proposer leur menu du jour.<br>
Projet Laravel du [cours développement web](https://github.com/HE-Arc/slides-devweb) INF3dlm. HE-Arc, 2018-2019.

## Prise en main
1. Clonez le projet et installez les dépendances PHP et frontend
```bash
$ composer install
$ npm install
```
2. Copiez le fichier ```.env.example```sous le nom ```.env```et éditez le contenu de ce dernier selon votre configuration locale (pas nécessaire si Homestead est utilisé).
### Homestead (optionnel)
Afin d'avoir un environnement de développement uniforme, nous avons décidé d'utiliser [Homestead](https://laravel.com/docs/5.7/homestead) qui est la [Vagrant](https://www.vagrantup.com/intro/index.html) box officiel de Laravel.<br>

1. [Téléchargez](https://www.vagrantup.com/downloads.html) et installez Vagrant.
2. Installez un *[provider](https://www.vagrantup.com/docs/providers/)* Vagrant tel que [VirtualBox](https://www.virtualbox.org/wiki/Downloads).
3. Installez la Vagrant *box* ```laravel/homestead```
	```bash
    $ vagrant box add laravel/homestead
    ```
4. Générez le fichier ```Homestead.yaml```
	```bash
    $ php vendor/bin/homestead make # Linux/Mac
    $ vendor\\bin\\homestead make 	# Windows
    ```
5. Editez le contenu du fichier ```Homestead.yaml``` si nécessaire (vous pouvez notamment changer le nom de domaine par défaut ```homestead.test``` par un autre nom de votre choix).
6. Modifiez ```/etc/hosts```(ou ```C:\Windows\System32\drivers\etc\hosts``` sur Windows) selon la configuration du fichier ```Homestead.yaml``` (IP de la *box* Vagrant et nom de domaine). 
7. Lancez la machine virtuelle avec la commande ```vagrant up``` et arrêtez-la avec ```vagrant halt```. Pour un accès shell sur la VM, utilisez la commande ```vagrant ssh```.

## Auteurs
* **[Kevin Bütikofer](https://github.com/kevinbutikofer)**
* **[Jordy Crescoli](https://github.com/joecrescoll)**
* **[Jules Perrelet](https://github.com/kulisse)**

