# TaskApp

## Aplicacion de asignacion de tareas usando Symfony 3.
---
### Info;

Un sistema de asignación de tareas en el cual puedes crear `Tickets` para un grupo de usuarios destinados a resolver estos `Tickets`. Se puede mantener una comunicación entre ambas partes ya que el sistema contiene un área de comentarios dentro de cada tarea.

Los usuarios que solicitan `Tickets` puedes ver el seguimiento de estos y saber el estado en el que están ya que posee un mecanismo para el cambio de estado en los `Tickets`.

### Instalación

> Debes tener instalado Composer para ejecutar los siguientes comandos y así descargar e instalar la aplicación TaskApp:

    # clona el código de la aplicación
    $ cd proyectos/
    $ git clone https://github.com/itsalb3rt/taskapp.git
    
    # instala las dependencias del proyecto (incluyendo Symfony)
    $ cd TaskApp/
    $ composer install
    
Casi al final la consola te pedirá los siguientes datos, debes llenarlo según corresponda;

    database_host (127.0.0.1):
    database_port (null):
    database_name (symfony): taskappsymfony
    database_user (root):
    database_password (null):
    mailer_transport (smtp):
    mailer_host (127.0.0.1):
    mailer_user (null):
    mailer_password (null):
    
Una vez termines con esta parte solo queda crear la base de datos, correremos un simple comando

    php bin/console doctrine:schema:update --force
    
Si todo tuvo éxito veras algo como esto;

    PS C:\wamp64\www\taskapp> php bin/console doctrine:schema:update --force
    Updating database schema...
    Database schema updated successfully! "6" queries were executed

Para acceder a la app colocas en tu navegador: http://localhost/taskapp/web/login

---

### Index;
![Login](https://i.imgur.com/qzHOA1W.jpg)

---
## Registro usuarios;
![Registro](https://i.imgur.com/Z5zj2V3.jpg)

---

### Pagina inicio luego de iniciada la sesion;

![](https://i.imgur.com/kaAUaY8.jpg)

---

### Creado y asignando una tarea;

![](https://i.imgur.com/XRuv4uE.jpg)
