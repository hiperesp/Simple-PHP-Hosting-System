# Simple PHP Hosting System

Simple PHP Hosting System é um sistema de hospedagem em PHP.\


## Manual de Instalação

### Informativo

O Sistema utilizado neste manual foi o Arch Linux.

> $ uname -a\
Linux archiper 5.0.10-arch1-1-ARCH #1 SMP PREEMPT Sat Apr 27 20:06:45 UTC 2019 x86_64 GNU/Linux

### Instalação do LAMP

LAMP é a sigla para Linux + Apache + MySQL/MariaDB + PHP, que são respectivamente, o sistema operacional, o servidor HTTP (HTTP Daemon Apache, mais conhecido como httpd, ou apache), o sistema de banco de dados e a linguagem de script de uso geral, geralmente (e neste caso) é utilizada para desenvolvimento web.\
OBS: O Linux já está instalado e o banco de dados utilizado será o MariaDB.

> \# pacman -S apache mariadb php php-apache

#### Configuraçao do Apache

Execute:
> \# systemctl enable httpd\
\# systemctl start httpd

Será utilizado o arquivo de configuração do repositório.\
Troque o arquivo `/etc/httpd/conf/httpd.conf` por `[caminho_para_esse_repositorio]/src/etc/httpd/conf/httpd.conf`


#### Configuração do MariaDB

Execute:
> \# mysql_install_db --user=mysql --basedir=/usr --datadir=/var/lib/mysql\
\# systemctl enable mysqld\
\# systemctl start mysqld\
\# mysql_secure_installation

#### Configuração do PHP

Será utilizado o arquivo de configuração do repositório.\
Troque o arquivo `/etc/php/php.ini` por `[caminho_para_esse_repositorio]/src/etc/php/php.ini`

#### Pasta do servidor

A pasta do servidor é a pasta em que contem as informações referentes ao conteúdo de cada usuário do Simple PHP Hosting System, sendo projetos e configurações dos projetos.\
Ela é separada em 3 pastas principais:

- user: contém todo o conteúdo dos usuários, no formato `nomedousuario/nomedoprojeto/`. Cada projeto novo é uma cópia do projeto "default" do usuário "default".
- user_conf: contém as configurações dos projetos dos usuários, no formato `nomedousuario/nomedoprojeto/`. Nessa pasta são encontradas as configurações dos virtual hosts. Cada atualização nela é necessário reiniciar o apache para ser visível.
- conf: é a configuração geral do servidor HTTP do Simple PHP Hosting System. São encontrados arquivos de configuração padrões para cada usuário e a configuração geral dos virtual hosts.

A pasta do servidor que será utilizada é a pasta do servidor do repositório.\
Copie ou mova todos os arquivos e pastas recursivamente de `[caminho_para_esse_repositorio]/src/srv/http` para `/srv/http`

Caso aconteça algum erro 403 ao acessar um site configurado corretamente, verifique as permissões dos arquivos. O comando `# chmod 777` pode ajudar.\
Caso o phpmyadmin dê um erro de permissão no arquivo de configuração, execute:
> \# chmod 775 /srv/http/user/phpmyadmin/phpmyadmin/config.inc.php

#### Configuração dos hosts
Altere o conteúdo do arquivo `/etc/hosts` conforme necessário. Não recomendamos utilizar ele para "registrar domínios". Caso queira, altere o conteúdo dele para o mesmo conteúdo do arquivo `[caminho_para_esse_repositório]/src/etc/hosts`.

