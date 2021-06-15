<h3>Downloading...</h3>

1. Begin by downloading the latest stable hadoop release from <a href=https://mirrors.estointernet.in/apache/hadoop/common/hadoop-3.3.0/>here</a>. You might also visit <a href=https://www.apache.org/dyn/closer.cgi/hadoop/common/>here</a>. As of this writing, hadoop-3.3.0 is the latest stable release.
2. Extract the tar and move it to some location. I decided to place it in `/usr/lib/`. Not a bad place to start with. Also create a symlink to the hadoop-3.3.0 folder so that later working with different hadoop versions will only require this symlink to be updated without touching any config files and doing things nastily.
 
 ```
 tar xf hadoop-3.3.0.tar.gz
 sudo mv hadoop-3.3.0 /usr/lib
 sudo ln -s /usr/lib/hadoop-3.3.0 /usr/lib/hadoop
 ```
<h3>Prerequisites...</h3>

1. Java runtime environment: `sudo apt-get install openjdk-11-jre`
2. ssh because sshd must be running to use the Hadoop scripts that manage remote Hadoop daemons: `sudo apt-get install openssh-server`

Before you can run Hadoop, you need to tell it where Java is located on your system. If you have the JAVA_HOME environment variable set to point to a suitable Java installation, that will be used, and you don’t have to configure anything further. (It is often set in a shell startup file, such as ~/.bashrc or ~/zshrc.) Otherwise, you can set the Java installation that Hadoop uses by editing conf/hadoop-env.sh and specifying the JAVA_HOME variable.

<h3>Creating Hadoop group and adding hadoop user...</h3>
Although this is optional, but you may also want to create a hadoop group and add specifically add hadoop users to it. DO NOT forget to provide the ownership of the hadoop installation to the hadoop user. If you have already created the symlink than you can use that to refer hadoop folder instead.

```
sudo groupadd hadoop
sudo useradd -m deadpool -g hadoop
sudo chown -R deadpool:hadoop hadoop-3.3.0
```
