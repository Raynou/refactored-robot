# Moodle Plugin for Emotion Recognition

Moodle block plugin that utilizes the Amazon Rekognition service to perform feelings analysis on students in Moodle.

1. [Introduction](#moodle-plugin-for-emotion-recognition)
2. [Plugin installation](#plugin-installation)
      1. [Configuration of Enviorment Variables](#configuration-of-environment-variables)
      2. [Manual installation](#manual-installation)
            - [Installation of PHP Libraries](#installation-of-php-libraries)
            - [Install grunt](#install-grunt)
      3. [Run project with Docker](#run-project-with-docker)
            - [Automatic Moodle installation](#automatic-moodle-installation)
            - [Install PHP dependencies in the container](#automatic-moodle-installation)
            - [Using grunt in the container](#using-grunt-in-the-container)

## Plugin Installation

The first step for setup the plugin is create a `.env` as you can se in [Configuration of Enviorment variables](#configuration-of-environment-variables), after this, you have two options: you will have to do either a local installation, for this see [Manual installation](#manual-installation) or [Run the project with Docker](#run-project-with-docker).

## Configuration of Environment Variables
As the plugin uses AWS services and accesses the Moodle database, you need to configure a `.env` file with the following structure in the root folder of the plugin:

```.env
AWS_REGION = your-aws-region
AWS_PUBLIC_KEY = your-public-key
AWS_SECRET_KEY = your-secret-key
DB_DIALECT = mysql | mariadb
DB_HOST = your-host
DB_NAME = moodle # This is the name of the Moodle database
DB_USER = your-user
DB_PASSWORD = your-password
```

## Manual installation

In your Moodle installation, navigate to the `blocks` folder and execute the following command:

```bash
git clone https://github.com/Gian12315/refactored-robot.git simplecamera
```

In case you don't have Moodle already installed you can read the [Moodle docs](https://docs.moodle.org/403/en/Installing_Moodle). 

### Installation of PHP Libraries

```bash
composer require aws-project/stormwind:dev-dev
```

### Install grunt.

The plugin uses logic built in JavaScript, so changes made to this code must be built for the plugin to use it correctly (see more at: https://moodledev.io/docs/guides/javascript/modules). For this, the `grunt` tool is used.


```bash
npm install -g grunt-cli
```

> [!IMPORTANT]
> It is necessary to have a version of Node.js equal to or greater than 16 and less than or equal to 17 to install grunt.

#### Build the code.

```bash
npx grunt amd
```

Or, if you will be making frequent changes:

```bash
npx grunt watch
```

The latter command requires the installation of Watchman. If you don't have it installed, run the following command accord the platform you're:

#### Windows

```bash
scoop install watchman
```
#### MacOS

```bash
brew install watchman
```
#### Linux
If you are running the project on a Linux distribution, you can refer to the Watchman documentation: https://facebook.github.io/watchman/docs/install.html


## Run project with Docker

If you want to use Docker for developing and testing the plugin instead of doing a manual installation, you can do so by running the following command:

```bash
docker compose up
```

> [!WARNING]
> The Docker containers created with this command are intended for use in a development environment, not in production.

### Automatic Moodle installation

```bash
docker exec -it simplecamera-plugin-1 ./setup.sh
```
> [!TIP]
> This command also installs the php dependencies, therefore, you don't have to install them manually.

If this command doesn't work it's always possible install Moodle via the web installer, for this go to your navigator at `localhost/moodle` and fill the data. Don't forget to use either `plugindb` or your custom name for database container as database host name.

### Install PHP dependencies in the container

```bash
docker exec -it simplecamera-plugin-1 composer require aws-project/stormwind:dev-dev
```

### Using grunt in the container

For use grunt commands inside the container you can execute the following commands:

For build Javascript code:

```bash
docker exec -it simplecamera-plugin-1 npx grunt amd
```

For run tasks on file changes:

```bash
docker exec -it simplecamera-plugin-1 npx grunt watch
```

In case you have been change the name of Moodle container you will have to use that name insteat of `simplecamera-plugin-1`.