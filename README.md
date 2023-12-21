# Moodle Plugin for Emotion Recognition

Moodle block plugin that utilizes the Amazon Rekognition service to perform feelings analysis on students in Moodle.

1. [Introduction](#moodle-plugin-for-emotion-recognition)
2. [Plugin installation](#plugin-installation)
3. [Installation of PHP Libraries](#installation-of-php-libraries)
4. [Build Changes to JavaScript Code in the amd Folder](#build-changes-to-javascript-code-in-the-amd-folder)
      1. [Install grunt](#install-grunt)
      2. [Build the code](#build-the-code)
5. [Configuration of Environment Variables](#configuration-of-environment-variables)
6. [Run project with Docker](#run-project-with-docker)

## Plugin Installation

In your Moodle installation, navigate to the `blocks` folder and execute the following command:

```bash
git clone https://github.com/Gian12315/refactored-robot.git simplecamera
```

## Installation of PHP Libraries

```bash
composer require aws-project/stormwind:dev-dev
```

## Build Changes to JavaScript Code in the amd Folder

The plugin uses logic built in JavaScript, so changes made to this code must be built for the plugin to use it correctly (see more at: https://moodledev.io/docs/guides/javascript/modules). For this, the `grunt` tool is used.

#### Install grunt.

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

## Configuration of Environment Variables
As the plugin uses AWS services and accesses the Moodle database, you need to configure a .env file with the following structure in the root folder of the plugin:

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

## Run project with Docker

If you want to use Docker for developing and testing the plugin, you can do so by running the following command:

```bash
docker compose up
```

> [!WARNING]
> The Docker containers created with this command are intended for use in a development environment, not in production.

Once the process of creating the containers is complete, you can access localhost\moodle in your browser to go through the installation process (this step is only performed the first time the containers are created).

> [!IMPORTANT]
> When entering the database host, instead of using "localhost," use the name of the database container, which is by default plugindb.
