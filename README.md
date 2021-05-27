Рекомендуемые требования к аппаратному обеспечению:
8 Гб RAM, 6 CPU, 10 Gb HDD.

Требуемое окружение: 
Docker Engine - https://docs.docker.com/engine/install/
Docker-compose - https://docs.docker.com/compose/install/

Клонировать проект:
git clone https://github.com/belogolovm/geo_project.git

Разархивировать tar с дампом бд: 
tar -xvf ./geo_project/db/docker_geobd.tar.gz -C ./geo_project/db/ && rm -rf ./geo_project/db/docker_geobd.tar.gz

Перейти в корень проекта и поднять контейнеры
cd ./geo_project && docker-compose up -d

Далее должно появиться 5 контейнеров:
PgPool,Master,Slave,PHP,Apache.

Приложение будет доступно по ip-адресу хостовой машины и 80 порту.
