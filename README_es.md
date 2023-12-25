# Plugin de Moodle para reconocimiento de emciones

Plugin de bloque para Moodle que utiliza el servicio de `Amazon Rekognition` para hacer análisis de sentimientos de estudiantes en Moodle.

1. [Introducción](#introducción)
2. [Instalación del plugin](#instalación-del-plugin)
      1. [Configuración de las variables de entorno](#configuración-de-las-variables-de-entorno)
      2. [Instalación manual](#instalación-manual)
            - [Instalación de librerías PHP](#instalación-de-librerías-php)
            - [Instalar Grunt](#instalar-grunt)
      3. [Instalación con Docker](#instalación-con-docker)
            - [Instalación automática de Moodle](#instalación-automática-de-moodle)
            - [Instalación de librerías PHP en el contenedor](#instalación-de-librerías-php-en-el-contenedor)
            - [Uso de Grunt en el contenedor](#uso-de-grunt-en-el-contenedor)

# Instalación del plugin

Para instalar el plugin correctamente primero se deben de configurar las variables de entorno como se indica en la sección de abajo, posteriormente puede elegir hacer la [instalación manual](#instalación-del-plugin) en una instancia de Moodle que usted ya tenga previamente instalada en su equipo o por el contrario puede [ejecutar el proyecto con Docker](#ejecutar-proyecto-con-dockerj).

En caso de que quiera hacer la instalación manual pero no tenga Moodle en su equipo en la [documentación oficial de Moodle](https://docs.moodle.org/403/en/Installing_Moodle) se explica como hacer este proceso.

## Configuración de las variables de entorno

Como el plugin utiliza servicios de AWS y accede a la base de datos de Moodle, se requiere configurara un archivo `.env` con la siguiente estructura en la carpeta raiz del plugin:

```.env
AWS_REGION = your-aws-region
AWS_PUBLIC_KEY = your-public-key
AWS_SECRET_KEY = your-secret-key
DB_DIALECT = mysql | mariadb
DB_HOST = your-host
DB_NAME = moodle # Este es el nombre de la db de Moodle
DB_USER = your-user
DB_PASSWORD = your-password
MOODLE_ADMIN_USER=your-admin-user
MOODLE_ADMIN_PASS=your-admin-password
```
## Instalación manual

En su instalación de moodle, dentro de la carpeta `blocks` ejecute el siguiente comando.

```bash
git clone https://github.com/Gian12315/refactored-robot.git simplecamera
```

### Instalación de librerías PHP.

```bash
composer require aws-project/stormwind:dev-dev
```

### Instalar grunt.

El plugin utiliza lógica construida en Javascript, por lo que los cambios hecho a dicho código tendrán que ser buildeados para que el plugin pueda utilizarlo correctamente (ver más en: https://moodledev.io/docs/guides/javascript/modules), para esto se utiliza la herramienta `grunt`.

```bash
npm install -g grunt-cli
```

> [!IMPORTANT] 
> Es necesario tener una versión de Node.js igual o mayor que 16 y menor o igual que 17 para instalar grunt.

#### Buildear el código.
```bash
npx grunt amd
```

O en caso de que vaya a estar haciendo cambios de manera frecuente:

```bash
npx grunt watch
```

Este último comando requiere la instalación de `Watchman`, en caso de que no lo tenga instalado, ejecute el siguiente comando:

#### Windows
```bash
scoop install watchman
```

#### MacOS
```bash
brew install watchman
```

#### Linux
En caso de que este ejecutando el proyecto en una distribución de Linux puede consultar la documentación de Watchman: https://facebook.github.io/watchman/docs/install.html

## Instalación con Docker

Sí desea usar docker para desarrollar y probar el plugin puede hacerlo ejecutando el siguiente comando:

```bash
docker compose up
```

> [!WARNING]
> Los contenedores de Docker creados con este comando están pensados para ser usados en ambiente de desarrollo, no en producción.

Una vez termine el proceso de creación de los contenedores, puede acceda a `localhost\moodle` en su navegador para hacer el proceso de instalación (este paso solo se hace la primera vez que se crean los contenedores).

> [!IMPORTANT]
> Al momento de ingresar el host de la base de datos, en lugar de colocar `localhost` coloque el nombre del contenedor de la base de datos, que por defecto es `plugindb`.

### Instalación automática de Moodle

```bash
docker exec -it simplecamera-plugin-1 ./setup.sh
```

> [!TIP]
> Este comando también instala las dependencias de PHP en la carpeta del proyecto, por lo que ya no es necesario que las ejecutes manualmente.

Sí este comando llega a fallar, siempre es posible instalar Moodle mediante su instalador web, para ello vaya a `localhost/moodle` en su navegador y rellene los datos que se le solicitan. Recuerde usar el nombre `plugindb` o el nombre que haya elegido para el contenedor de base de datos cuando le pidan el `database host`.

### Instalación de librerías PHP en el contenedor

Para instalar las dependencias de PHP puede ejecutar los siguientes comandos:

```bash
composer require aws-project/stormwind:dev-dev
```

O en caso de que no tenga composer instalado localmente:

```bash
docker exec -it simplecamera-plugin-1 composer require aws-project/stormwind:dev-dev
```
En caso de que haya puesto algún nombre personalizado al contenedor tendrá que reemplazar `simplecamera-plugin-1` por el nombre que haya elegido.

### Uso de grunt en el contenedor

Para ejecutar los comandos de grunt puede ejecutar los siguientes comandos.

Para hacer build:

```bash
docker exec -it simplecamera-plugin-1 npx grunt amd
```

Para escuchar cambios en la carpeta `amd`:

```bash
docker exec -it simplecamera-plugin-1 npx grunt watch
```
