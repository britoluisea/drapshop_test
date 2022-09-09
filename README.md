## Prueba practica para DrapShop

## Inslatacion 
Entrar en la carpeta, ejecutar composer install <br>
Al terminar crear el archivo .env, dar conexion a BD
Correr php artisan migrate
luego ejecutar npm install & npm run dev
por ultimo correr php artisan serve 
realizar sus respectivas pruebas

### Como funciona

- **Al acceder a la interfas de la prueba podra registrar su usuario**
- **Hacer Login**
- **Una ves que iniciemos debemos crear Customer**
- **Teniendo listo los cutomer podemos usar Sales**
- **Account, para editar nombre o correo del usuario**
- **Security, para cambiar password**
- **Logout, salir del sistema**

## Sobre Sales
- **Pantalla principal muestra la tabla con los datos inicales**
- **Columnas Total USD y Total EUR, funciona en automatico una ves que tenga datos hara la conversion**
- **Para agregar un Sales, debe seleccionar un customer anteriormente creado**
- **Seleccionar fecha, cualquiera**
- **Seleccionar o crear productos**
- **Los produccion o Items creados no tienen como editarse**
- **Una ves seleccionado un producto se puede cambiar cantidad y precio sin afectar el creado**

## Ruta api publica
http://127.0.0.1:8000/api/getAllSales
- **Solo si previamente registraste datos**