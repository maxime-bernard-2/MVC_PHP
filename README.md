# HotHotHot !

GroupMaker est une application web conçue en PHP qui a pour but de faire des groupes de personnes aléatoirement.
Le site est en ligne et est disponible à cette adresse: https://groupmaker.maximebernard-etu.fr

## Installation

J'ai mis en place des images Docker pour faciliter l'installation sur de nouvelles machines sans plus de configurations.
Cela inclut une base de données MYSQL avec PhpMyAdmin et un serveur composé de PHP 8.0 et Apache.

### Docker

Installer [Docker Desktop](https://www.docker.com/products/docker-desktop) et ne pas oublier de le lancer une fois l'installation terminée.

> Si vous n'êtes pas familier avec Docker, je vous conseille ces vidéos:
>1. Bases de Docker: https://www.youtube.com/watch?v=SXB6KJ4u5vg
>2. Créer une image Docker: https://www.youtube.com/watch?v=cWkmqZPWwiw
>3. Utiliser Docker compose: https://www.youtube.com/watch?v=dWcoIxRfs8Y

### Lancer l'application

> :warning: **Attention**: fermez WAMP ou tout autres logiciel utilisant le port 80, 8080 ou 3306!

Pour lancer l'application, il vous faudra taper ces commandes dans le répertoire où se trouve 'docker-compose.yml':
```
docker-compose build
```
```
docker-compose up
```

### Utilisation

L'application se trouve sur [le port 80](http://localhost:80).
Pour accéder directement à la base de données, cela se passe sur [le port 3306](http://localhost:3306).
Pour accéder à la base de données avec PhpMyAdmin, il faut vous rendre sur [le port 8080](http://localhost:8080).

L'appplication ne marche qu'avec un type de fichier qui est le XLSX. Pour que tout marche, 
veuillez utiliser ce [template](https://drive.google.com/file/d/1yrEBeDg6ypIsj1i8ccbXeVn_YEbebCZF/view?usp=sharing)

>Il se trouve aussi à la racine du projet sous le nom de list.xlsx
 
test