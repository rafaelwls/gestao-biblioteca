# gestao-biblioteca

Instale o Xampp

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
```

Crie um banco no postgresql com o nome de yii2advanced
Utilize o usuario: postgres senha: 123

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
Rode o apache no xampp

Links de acesso:
biblioteca.local
admin.biblioteca.local
 