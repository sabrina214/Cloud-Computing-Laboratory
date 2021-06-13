<h2>Task:  Install three servers using Xen / KVM hypervisor. Use two of them to install any application server (Apache etc) and any database server (MySQL etc).
Create an application (say a simple login) on the third using the other two servers. Access the application from your host OS and another system.<br><br>
Approach: Create a bridge network; install some database(like mariadb) and web server(like nginx) separately on two debian OSes; not necessarily having graphical interfaces and another VM having graphical interface.
