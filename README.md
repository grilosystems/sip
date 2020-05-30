# SPI
Sistema Integral de Pagos

Este sistema fue inicialmente creado con base en PHP 5, no se utilizo ningún Framework ni tampoco se siguió un patrón de diseño para su desarrollo, en la actualidad se esta realizando la migración y actualización con PHP 7 la cual no tiene fecha de termino ya que se espera que se unan colaboradores a este proyecto.

Requerimientos:
•	Apache 2.4
•	PHP 7.3 en adelante
•	MySQL 5.4

Pasos para el levantamiento del programa:
1.	Descargar el proyecto desde GIT
a.	git clone https://github.com/grilosystems/sip.git
2.	Instalar la base de datos, ejecutar el script para generar la base de datos esta en la siguiente ruta dentro del proyecto: sip/database/sql/database.sql
3.	Ingresar desde el navegador en la siguiente dirección: http://localhost/sip
4.	Por default el usuario que se genera al momento de crear la base de datos es admin@spi.com y su contraseña es spi123, esto se puede consultar dentro del script
5.	Una vez ingresado probar los módulos que contiene el programa

¿Cuál es el intento funcional de este programa?
Este desarrollo inicialmente fue concebido a partir de la necesidad de manejar la caja chica de una empresa de desarrollos inmobiliarios, el desarrollo del programa se concluyo con los primeros requerimientos, pero el solicitante no cumplió con los pagos acordados y este nunca se libero para su uso privado.
El sistema solo se probo y se generaron mas requerimientos los cuales se implementaron pero tampoco fueron entregados, el programa se demostró con éxito con las versiones anteriores de PHP la base del desarrollo fue utilizando XAMPP 5.4, actualmente el código a sufrido modificaciones como las funciones de conexión a la base de datos y las variables de sesión.

¿Qué se piensa implementar para la mejora?
Hasta el momento se ha querido conservar lo mas apegado al desarrollo original, pero este al no ser hecho con algún patrón de diseño o algún Freamework lo que solo se piensa es en implementar RedBeanPHP (https://www.redbeanphp.com/index.php), pero este aun no se ha revisado bien la compatibilidad con PHP 7.3
