# Simple PHP Hosting System

Simple PHP Hosting System é um sistema de hospedagem em PHP.\


## Manual de Instalação

### Informativo

O Sistema utilizado neste manual foi o ArchWSL \<<https://github.com/yuk7/ArchWSL>\>.

> $ uname -a\
Linux DESKTOP-S1E7TSG 4.4.0-18362-Microsoft #1-Microsoft Mon Mar 18 12:02:00 PST 2019 x86_64 GNU/Linux

No tutorial de instalação, será solicitado que você inicie o httpd e o MariaDB através do systemd, porém ele não é habilitado no WSL.\
Para isso, você deve iniciar o httpd e o MariaDB de uma forma alternativa, e você pode fazer isso instalando os scripts.

### Instalação dos Scripts

Copie ou mova todos os arquivos e pastas recursivamente de `[caminho_para_esse_repositorio]/wsl/scripts` para `~/simple-php-hosting-system/scripts` e acesse essa pasta.
Execute:
> \# chmod 777 *

### Execução do httpd

Acesse a pasta de scripts (de acordo com a instalação dos scripts) e execute:
> \# ./start-httpd.sh

### Execução do MariaDB

Acesse a pasta de scripts (de acordo com a instalação dos scripts) e execute:
> \# ./start-mariadb.sh


### Execução do httpd e MariaDB (somente após a instalação completa)

Acesse a pasta de scripts (de acordo com a instalação dos scripts) e execute:
> \# ./start-all.sh
