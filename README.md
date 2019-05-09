# Survey creator

This app will allow you to create the dynamic forms and do the submissions of them - just like google survey! : ) 

## Assumptions & Restrictions
Authentication is not being available in Backend API. However, the plan is to JWT Auth to handle the authentication and safeguard the APIs. 

## Getting Started

So this project is broken down into Backend and Frontend. Backend is written in laravel and solely to serve as API for the Frontend which is written Vue JS. Pleaes follow the instructions below to setup backend API and also the Frontend UI. 

### Prerequisites
* Mac OSX. 
* Sequel Pro installed.
* Composer is installed and available globally 
* npm is installed and available globally 

## Installing & Setting up

### Setting up Database 
* I recommend to use **Sequel Pro* 
* On the application, create a new connection and we will use **ssh** option to connect to the homestead database server. 
* Name - any name of your choce 
* MySQL Host: 192.168.10.10
* Username : homestead
* password : secret
* port : 3306
* SSH Host: 192.168.10.10
* SSH User: vagrant
* SSH password: vagrant

* Once you get into the database, create a new database named **elmozaw** 

### Backend API 
* Clone this repository into your local machine of path : ~/Projects
```
~/Projects/elmozaw
```

* Then in your home folder or anywhere you like, git clone https://github.com/laravel/homestead.git ~/Homestead

* cd ~/Homestead , in that folder, there will be **Homestead.yaml** file which we will be using to configure to setup the APIs

* Open **Homestead.yaml** with your choice of editor. 

* In **folders** section is where vagrant box is mapping the projects in our machine - that is why this repo was asked to be cloned into ~/Projects
```
folders:
    - map: ~/Projects
      to: /home/vagrant/code
```

* In **sites** section is where the domain we set will be pointed to the code base on vagrant VM. 
```
 - map: api.elmozaw-survey.test
      to: /home/vagrant/code/elmozaw/backend/public
```

* Leave the rest of the configurations in the file as it is. 

* Then, next step is edit the hosts file. where you are on terminal, just *cd* 

* then **cd /etc** , and edit the host file by doing **sudo vim hosts** and add this line to the file **192.168.10.10 api.elmozaw-survey.test*
```
 192.168.10.10 api.elmozaw-survey.test
```

* After all the setup above, you can now go back again into Homestead folder that we cloned above and get into vagrant box by doing **vagrant up** and when it is up and running do **vagrant ssh** to get inside the VM. 

* Once you are in you will be able to cd to **cd code/elmozaw/backend** 

* Once you get in, you will need to run **composer install** to install the dependencies of the project. 

* Since we have the database setup already above, now you can run the migrations to build all the required tables **php artisan migrate** 



## Setting up Frontend Interface

* Once the above steps are done , your API is up and running. 

* Now go to frontend folder of the repository project that we have cloned **cd ~/Projects/elmozaw/frontend** 

* Once you got into frontend folder, we will install dependencies and required packages by doing **npm install**

* Once it is done, we can run **npm run dev** and it will serve the application at available host on your local machine. 


**so after all the setps above your frontend will start talking to BE API, and you can start using the app. Enjoy!**
