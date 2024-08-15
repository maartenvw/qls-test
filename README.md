## Introduction
This project is written in PHP using the [laravel framework](https://laravel.com/docs) incombination with the [VueJS Frontend Framework](https://vuejs.org/guide/introduction.html)

## Requirements
To install this project you need to have to following installed on your system:

- PHP >= 8.2
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- Filter PHP Extension
- Hash PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Session PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- MYSQL or MariaDB or any other supported database engine

You are going to need the following package installers

- NPM or Yarn
- composer


The PDF generation is done with laravel-snappy which uses Wkhtmltopdf please read their [documentation](https://github.com/barryvdh/laravel-snappy) to see how to install `Wkhtmltopdf`

## Getting started
To start the project, you are going to follow the following steps

- First download the project through either cloning it or downloading a zip file from the github project
- If you chose to use the zip route, then create a folder somewhere on your computer and extract the files into that folder
- Once extracted, open the folder in your favorite code editor and in a bash terminal
- If you chose to use the git clone route, then you need to open the folder it created for you in your favorite code editor and bash terminal
- Once the terminal is open, you are going to need to do the following steps
    - go to the root folder of the project
    - Type the following command `composer install`
    - After that, type the following command `npm install` or `yarn install` depending on your preference
    - next copy the `.env.example` to `.env`
    - then type the following command `php artisan key:generate` this will generate a security key for your project which will be used for the encryption and decryption of the app
    - then go to your database engine and create a new database and place the connection information in the `.env` file
    - after you have created the database, type the following two commands, first `php artisan migrate` then `php artisan db:seed`.
        - The `db:seed` is to generate a user since we don't have a registration since this is an admin portal and only admin user would be able to create users.
        - The credentials for this test user are the following:
            - User: test@example.com
            - Password: password
    - Now open the `.env` and got to the bottom and fill in the attributes starting with `QLS_` most of these can be found in your QLS dashboard
    - After that open two new terminal windows in the first run `npm run dev` in the second window run `php artisan serve`
    - Now go to the URL returned on your screen, and you're good to go and test the application

## How to use
Once the application is running, you will see a login form. Here you enter the credentials mentioned above. When successful, you will be redirected to the dashboard.

On the dashboard you can select a shipment product then a shipment product combination. After that, you can hit the generate button. Once the button is done loading, there should be a PDF in your browsers download folder.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
