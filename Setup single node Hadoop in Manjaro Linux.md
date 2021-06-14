<h3>Downloading...</h3>

1. Begin by downloading the latest stable hadoop release from <a href=https://mirrors.estointernet.in/apache/hadoop/common/hadoop-3.3.0/>here</a>. You might also visit <a href=https://www.apache.org/dyn/closer.cgi/hadoop/common/>here</a>
2. Extract the tar and move it to some location. I decided to place it in `/usr/lib/`. Not a bad place to start with. Also create a symlink to the hadoop-X.Y.Z folder so that later working with different hadoop versions will only require this symlink to be updated without touching any config files and doing things nastily.
 
 ```
 tar xf hadoop-X.Y.Z.tar.gz
 sudo mv hadoop-X.Y.Z /usr/lib
 sudo ln -s /usr/lib/hadoop-X.Y.Z /usr/lib/hadoop
 ```
 
<h3>Creating Hadoop group and adding hadoop user...</h3>
Although this is optional, but you may also want to create a hadoop group and add specifically add hadoop users to it. DO NOT forget to provide the ownership of the hadoop installation to the hadoop user. If you have already created the symlink than you can use that to refer hadoop folder instead.

```
sudo groupadd hadoop
sudo useradd -m deadpool -g hadoop
sudo chown deadpool:hadoop hadoop
```
