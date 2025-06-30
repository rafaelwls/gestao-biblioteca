# gestao-biblioteca

Instale o Xampp
https://www.apachefriends.org/pt_br/index.html

instale o composer ou já tenha baixado:
```composer --version```
https://getcomposer.org/download/

Tenha o git baixado e no path 
```git --version```
https://git-scm.com/download/win

depois de instalar o xampp

Instale o projeto na pasta xampp\htdocs

no php.ini

descomente
```
extension=pgsql
extension=pdo_pgsql
extension=zip
```

faça
```
cd C:\xampp\htdocs\gestao-biblioteca\biblioteca
```

e rode
```
composer install
composer require vlucas/phpdotenv
```

Crie um banco no postgresql com o nome de biblioteca
Utilize o usuario: postgres senha: 123
> caso o banco já exista, faça: 
> ```
> DROP SCHEMA public CASCADE;
> CREATE SCHEMA public;
> ```

>> CASO, E APENAS CASO REINSTALE TUDO, rode ```php init``` sem sobrescrever os existentes
use 
```
php yii migrate
```

abra: 
```
C:\Windows\System32\drivers\etc\hosts
```
aplique o comando no final do arquivo e salve: 
```
127.0.0.1 biblioteca.local
127.0.0.1 admin.biblioteca.local
```
Abra o arquivo:
```
C:\xampp\apache\conf\extra\httpd-vhosts.conf
```
adicione o código:
```
<VirtualHost *:80>
    ServerName biblioteca.local
    DocumentRoot "C:/xampp/htdocs/gestao-biblioteca/biblioteca/frontend/web"
    <Directory "C:/xampp/htdocs/gestao-biblioteca/biblioteca/frontend/web">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerName admin.biblioteca.local
    DocumentRoot "C:/xampp/htdocs/gestao-biblioteca/biblioteca/backend/web"
    <Directory "C:/xampp/htdocs/gestao-biblioteca/biblioteca/backend/web">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

```

crie um .env:
```
DB_DSN="pgsql:host=localhost;dbname=biblioteca"
DB_USER="postgres"
DB_PASS="123"
SECRET_KEY="a3f5c12d4e6b7a8c9d0e1f2a3b4c5d6e"
```
Rode o apache no xampp

Links de acesso:
biblioteca.local
admin.biblioteca.local
 