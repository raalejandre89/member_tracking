## Installation

Follow the following steps to install the necessary components to run the application

- Install Docker Desktop. https://www.docker.com/products/docker-desktop/ 
- Install and enable Windows Subsystem for Linux 2 (WSL2).
  - How to do this: https://learn.microsoft.com/en-us/windows/wsl/install
- After installing and enabling WSL2, you should ensure that Docker Desktop is configured to use the WSL2 backend.
  - How to do this: https://docs.docker.com/desktop/wsl/
- Open Docker Desktop.
- Open a command terminal in your computer and connect to your WSL2 subsystem.
- While in your WSL2 subsystem navigate to the folder where you clone the code.
- Run ```./vendor/bin/sail up```
- The previous command should set up a redis cluster, a mysql cluster and the application.
- Now you can access the application through the browser.
