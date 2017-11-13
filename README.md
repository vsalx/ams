# ams
University project: Appointment reservation system for dentists


# How to run on Windows
1. Virtualization of the processor must be enabled. See point 4 of the following link: https://docs-old.fedoraproject.org/en-US/Fedora/13/html/Virtualization_Guide/sect-Virtualization-Troubleshooting-Enabling_Intel_VT_and_AMD_V_virtualization_hardware_extensions_in_BIOS.html
2. Enaple Hyper-V in Windows: https://blogs.technet.microsoft.com/canitpro/2015/09/08/step-by-step-enabling-hyper-v-for-use-on-windows-10/
3. Install and run docker - https://www.docker.com/docker-windows.
4. Checkout develop branch.
5. Run 'docker-compose build' in the cmd in the root folder of the branch. Wait a lot of minutes.
6. Run 'docker-compose up' and open localhost in the browser. Enjoy!

# Docs
1. Er Diagram - https://www.lucidchart.com/documents/edit/753600ab-f40e-499f-aa96-ebd6d5eb805f

# DB Maintenance

1. Migration
- open cmd and list docker containers with
'docker ps'
- get the id of the web server container and execute:
'docker exec -it {id} /bin/bash'
this will open the console inside the docker container
- now run to begin migration:
'php artisan migrate'
