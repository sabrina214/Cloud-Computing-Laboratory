import os
import time
import json


def make_dir(dir_path):
    try:
        os.mkdir(dir_path)
    except FileExistsError:
        pass


if __name__ == '__main__':
    while True:
        os.system('docker ps -q --no-trunc > .container-ids')
        container_ids = open(r'./.container-ids')

        for id in container_ids:
            log_file_name = id[:-1]
            make_dir(log_file_name)

            os.system(f'sudo cp /var/lib/docker/containers/{log_file_name}/{log_file_name}-json.log ./{log_file_name}/')
            os.system(f'sudo chown sid:docker ./{log_file_name}/{log_file_name}-json.log')

            json_file = open(f'./{log_file_name}/{log_file_name}-json.log')

            for json_string in json_file:
                log = open(r'./{}/{}.txt'.format(log_file_name, log_file_name), 'a')
                json_s = json.loads(json_string)
                # print(json_s['time'])
                log.write(json_s['log'])
                log.close()
            json_file.close()
            os.remove(f'./{log_file_name}/{log_file_name}-json.log')
        container_ids.close()
        time.sleep(5)
