echo Iniciando httpd
./start-httpd.sh & disown
echo Iniciando MariaDB
./start-mariadb.sh & disown
echo Done