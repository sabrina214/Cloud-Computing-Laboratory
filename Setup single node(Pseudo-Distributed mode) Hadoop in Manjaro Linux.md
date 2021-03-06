<h3>Downloading...</h3>

1. Begin by downloading the latest stable hadoop release from <a href=https://mirrors.estointernet.in/apache/hadoop/common/hadoop-3.3.0/>here</a>. You might also visit <a href=https://www.apache.org/dyn/closer.cgi/hadoop/common/>here</a>. As of this writing, hadoop-3.3.0 is the latest stable release.
2. Extract the tar and move it to some location. I decided to place it in `/usr/lib/`. Not a bad place to start with. Also create a symlink to the hadoop-3.3.0 folder so that later working with different hadoop versions will only require this symlink to be updated without touching any config files and doing things nastily.
 
 ```
 tar xf hadoop-3.3.0.tar.gz
 sudo mv hadoop-3.3.0 /usr/lib
 sudo ln -s /usr/lib/hadoop-3.3.0 /usr/lib/hadoop
 ```
 
<h3>Creating Hadoop group and adding hadoop user...</h3>
Although this is optional, but you may also want to create a hadoop group and add specifically add hadoop users to it. DO NOT forget to provide the ownership of the hadoop installation to the hadoop user. If you have already created the symlink than you can use that to refer hadoop folder instead.

```
sudo groupadd hadoop
sudo useradd -m deadpool -g hadoop
sudo chown -R deadpool:hadoop hadoop-3.3.0
```
Although you can provide password by passing the -p flag while creating the user but that will be visible a better way is to set password by: `sudo passwd deadpool`. After that start a login shell for user *deadpool*: `su - deadpool`

<h3>Prerequisites...</h3>

1. Java runtime environment: `sudo apt-get install openjdk-11-jre`

 Before you can run Hadoop, you need to tell it where Java is located on your system. If you have the JAVA_HOME environment variable set to point to a suitable Java installation, that will be used, and you don’t have to configure anything further. (It is often set in a shell startup file, such as ~/.bashrc or ~/zshrc.) Otherwise, you can set the Java installation that Hadoop uses by editing conf/hadoop-env.sh and specifying the JAVA_HOME variable.

 Add the path to the java installation to the end of the shell startup file.

 `export JAVA_HOME=/usr/lib/jvm/java-11-openjdk-amd64`
 While you are still in the shell startup file might also add HADOOP_HOME environment variable set to point to your hadoop installation and the append PATH environment variable to include path to hadoop executables: <br>
 ```
 export HADOOP_HOME=/usr/lib/hadoop
 export PATH=$PATH:$HADOOP_HOME/bin:$HADOOP_HOME/sbin
 ```

 To reload the startup file: `source ~/.bashrc`
 - Verify the javac version: `javac -version`
 - Simply correctly setting the JAVA_HOME environment variable is enough for working in **standalone mode** of Hadoop. To verify this:
```
cd $HADOOP_HOME
bin/hadoop version
```
or, simply
```
hadoop version
```
if you have updated `PATH`.<br>

You should see something like this 👇

![Screenshot_20210615_220441](https://user-images.githubusercontent.com/75603064/122090757-c1795c00-ce25-11eb-9fcf-173fcc866957.png)


2. ssh because sshd must be running to use the Hadoop scripts that manage remote Hadoop daemons: `sudo apt-get install openssh-server`. You need to be able to do passwordless login, generate a new SSH key with an empty passphrase:

```
ssh-keygen -t rsa -P '' -f ~/.ssh/hadoop
cat ~/.ssh/hadoop.pub >> ~/.ssh/authorized_keys
```
*Note: You will have to add your private key with the ssh-agent for which ssh-agent should be running*

Quick workaround: `eval $(ssh-agent -s)`<br>
But this needs to be done with every login session for this user.<br>
Better way: Add following lines to the shell startup file:
```
SSH_ENV="$HOME/.ssh/agent-environment"

function start_agent {
    /usr/bin/ssh-agent | sed 's/^echo/#echo/' > "${SSH_ENV}"
    chmod 600 "${SSH_ENV}"
    . "${SSH_ENV}" > /dev/null
    /usr/bin/ssh-add;
}

# Source SSH settings, if applicable

if [ -f "${SSH_ENV}" ]; then
    . "${SSH_ENV}" > /dev/null
    ps -ef | grep ${SSH_AGENT_PID} | grep ssh-agent$ > /dev/null || {
        start_agent;
    }
else
    start_agent;
fi
```
<a href=http://mah.everybody.org/docs/ssh#run-ssh-agent>Refer this for better explanation</a>

Once ssh-agent has started, then add your private key with ssh-add: `ssh-add ~/.ssh/hadoop`. Now you should be able to do ssh login without requiring to type password.

<h3>Configuring Pseudo-Distributed mode...</h3>

Set JAVA_HOME and HADOOP_HOME in $HADOOP_HOME/etc/hadoop/hadoop-env.sh as well.

**core-site.xml**
```
<?xml version="1.0"?>
<configuration>
  <property>
    <name>fs.defaultFS</name>
    <value>hdfs://localhost/</value>
  </property>
</configuration>
```

**hdfs-site.xml**
```
<?xml version="1.0"?>
<configuration>
  <property>
    <name>dfs.replication</name>
    <value>1</value>
  </property>
</configuration>
```

If you also want to **Mapreduce** to use **YARN** then update following files too.<br>
**mapred-site.xml**
```
<?xml version="1.0"?>
<configuration>
  <property>
    <name>mapreduce.framework.name</name>
    <value>yarn</value>
  </property>
</configuration>
```

**yarn-site.xml**
```
<?xml version="1.0"?>
<configuration>
  <property>
    <name>yarn.resourcemanager.hostname</name>
    <value>localhost</value>
  </property>
  
  <property>
    <name>yarn.nodemanager.aux-services</name>
    <value>mapreduce_shuffle</value>
  </property>
</configuration>
```

<h3>Formatting HDFS filesystem...</h3>
Before HDFS can be used for the first time, the filesystem must be formatted.<br>

```
hdfs namenode -format
```
<h4>Starting daemons...</h4>

```
start-dfs.sh
```
will start namenode, datanode, secondary namenode daemons. And if you configured mapreduce to use yarn, then:<br>
```
start-yarn.sh
```
will start resource manager and node manager daemons. 
```
mapred historyserver --daemon start
```
will start what it's told to 😉. To verify that these daemons are successfully running:
- Check hadoop logs, or
- Check if the web interfaces are up: <br>
 - <a href=http://localhost:9870>http://localhost:9870</a> for the namenode
 - <a href=http://localhost:8088>http://localhost:8088</a> for the resource manager
 - <a href=http://localhost:19888>http://localhost:19888</a> for the job history server
- or, using the `jps` command if you haven't installed only the headless jre
For stopping the daemons replace *start* with *stop* in all commands.
