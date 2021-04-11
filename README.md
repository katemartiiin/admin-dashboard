# Admin Dashboard

This project is created for the PRAXXYS Laravel Web Developer Exam.

---
## Requirements

For development, you will need Composer, Laravel and Node.js installed in your environment.

### Default Admins

This project will generate default admins that are defined in the UserSeeder.

<strong>Admin Zero</strong> <br>
    Username: admin.zero<br>
    Email: admin_zero@mail.com<br>
    Password: admin0

<strong>Admin One</strong> <br>
    Username: admin.one<br>
    Email: admin_one@mail.com<br>
    Password: admin1

### Laravel Installation

You may install the Laravel installer as a global Composer dependency:

    $ composer global require laravel/installer

### Configure app

Navigate to the project folder then open your terminal.

### Rename the env file by running the command below.
    $ mv .env.example .env

Change the database configuration and save.

### Install package dependencies

    $ composer install

### Generate app key
    $ php artisan key:generate

### Run migration and seeder
    $ php artisan migrate --seed

### Node.js Installation
Just go on [official Node.js website](https://nodejs.org/) and download the installer.
Also, be sure to have `git` available in your PATH, `npm` might need it (You can find git [here](https://git-scm.com/)).

If the installation was successful, you should be able to run the following command.

    $ node --version
    v8.11.3

    $ npm --version
    6.1.0

## Install package dependencies

    $ npm install

## Running the project

    $ php artisan serve

    $ npm run hot