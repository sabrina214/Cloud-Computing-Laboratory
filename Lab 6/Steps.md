1. Installing docker: `sudo pacman -S docker`
2. Docker daemon status: `sudo systemctl status docker.service`
 - Checkout docker commands by executing `docker` by passing no arguments.
![Screenshot_20210613_130239](https://user-images.githubusercontent.com/75603064/121799094-aa7d1300-cc47-11eb-8117-77aef54816f1.png)
3. Pulling images from docker hub: docker pull <image-name>
4. I have already pulled and started some containers. To see a list of running containers: docker ps
  - To see a list of container ids of running containers. By default the container ids are truncated for convenient output so pass --no-trunc flag to get complete ids. -q flag is reponsible for returning only container ids. `docker ps -q --no-trunc`<br>
  - `os` module in python is used for making such calls<br>
  ![Screenshot_20210613_131634](https://user-images.githubusercontent.com/75603064/121799420-a225d780-cc49-11eb-9d76-47d9a3f413a7.png)
5. By default the python script at each 5sec interval invokes the above command to get a list of running container ids and copies the logs from container filesystem locally. The logs are by default stored at /var/lib/docker/containers/<container-id>/
6. Docker uses json-logger driver by default to capture logs so the above directory will have logs in json format.
  - `json` module in python is used to load json stings from these files which makes it available to us a python dictionaries.
  - First create a fileobject because json.load expects a fileobject: `json_file = open(<container-log-file>, <access-mode>)`
  - Load json string as python dict: json_string = json.load(json_file)
  - The json strings in the log files have following keys: 'log', 'stream', 'time'. We are interested in 'log' which contains the log message and time of message too.
  - We can access the 'log' key as json_string['log'] as with any other python dictionaries.
7. Next we append this logs to a text file.
8. After executing following following directories are created coreesponding to the running containers.
  ![Screenshot_20210613_133924](https://user-images.githubusercontent.com/75603064/121799986-f7afb380-cc4c-11eb-984a-f0a26efd098d.png)
9. If we check the log in any one of the directory, we see;
  ![Screenshot_20210613_134318](https://user-images.githubusercontent.com/75603064/121800076-5b39e100-cc4d-11eb-9578-3a1485733f34.png)
  - This log is of a mariadb container shown truncated here.
  - to verify the output we can also do `docker logs <container-name | <container-id>`
