# AMS (Appointment Management System)
University project: Appointment reservation system for dentists

# Docs
1. Er Diagram - https://www.lucidchart.com/documents/edit/753600ab-f40e-499f-aa96-ebd6d5eb805f

# Environtment setup Without docker (Windows)
1. Install chocolatey - https://chocolatey.org/
2. Run the following command, but exclude tools that you already have
```
choco install php git nodejs mysql composer -y
```
3. Install Mysql Workbench or use the command line and create db schema ams, and a user ams, with password ams123. Give the user full priveleges to ams schema.
4. Checkout develop branch from git
5. Open cmd in the directory of the project and run
```
composer install
```
6. Find php.ini file, if installed with choco it should be in C:\tools\phpXX(XX is the php version) and ensure that 
```;extension=pdo_mysql``` is not commented out, by removing the ';' in front.
7. Open \ams\config\database.php and find mysql settings, set the host to be localhost. Should look like this:
```
        'mysql' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'ams',
            'username' => 'ams',
            'password' => 'ams123',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]
```
8. Open cmd in the directory of the project and run ```php artisan migrate``` to create the tables in the schema.
9. In the same cmd window and directory run ```php artisan serve``` and open localhost:8000 to verify the project is up.

# CSS compile
We are using SASS so we need to translate sass files to css first.
In the project's folder run the following command to translate your changes to css:
```
npm run dev
```
If you don't have npm, install it, and then run in the project's folder
```
npm install
```

# How to run on Windows with Docker (first time only)
1. Virtualization of the processor must be enabled. See point 4 of the following link: https://docs-old.fedoraproject.org/en-US/Fedora/13/html/Virtualization_Guide/sect-Virtualization-Troubleshooting-Enabling_Intel_VT_and_AMD_V_virtualization_hardware_extensions_in_BIOS.html
2. Enaple Hyper-V in Windows: https://blogs.technet.microsoft.com/canitpro/2015/09/08/step-by-step-enabling-hyper-v-for-use-on-windows-10/
3. Install and run docker - https://www.docker.com/docker-windows.
4. Checkout develop branch.
5. Open \ams\config\database.php and check if they look like this:
```
        'mysql' => [
            'driver' => 'mysql',
            'host' => 'ams_db_1',
            'port' => 3306,
            'database' => 'ams',
            'username' => 'ams',
            'password' => 'ams123',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
```
6. Run 'docker-compose build' in the cmd in the root folder of the branch. Wait a lot of minutes.
7. Run 'docker-compose up' and open localhost in the browser. Enjoy!

# DB Maintenance with Docker

1. Migration
- open cmd and list docker containers with
```
docker ps
```
- get the id of the web server container and execute:
```
docker exec -it {id} /bin/bash
```
this will open the console inside the docker container
- now run to begin migration:
```
php artisan migrate
```
