# A PHP Project Using a simple MVC Framework

> Note: This is a Simple Framework That Needs Too much Code Refactoring and
> Some Function Needs Validations.
> I Will Do It Later!
 
The Framework includes:

- **Routing System**
- **Database QueryBuilder Class**
- **Simple Authentication System**
- **Simple Container**

## To Use The Project

- download the composer from [The Website](https://getcomposer.org/) and install it.

- In The Project Directory open the command line and type:
```bash
composer init
```
- Then, to install packages in the [composer.json](https://github.com/AhmedElazony/php-mvc-project/blob/main/composer.json) file, Type thies commands:
```bash
composer require vlucas/phpdotenv
```
```bash
composer require ext-pdo
```

- Finally, use These [Database Statements](https://github.com/AhmedElazony/php-mvc-project/blob/main/databaseFile.sql) to make The database of the app, then edit the [.env file](https://github.com/AhmedElazony/php-mvc-project/blob/main/.env) with your configurations.

Now, you can navigate to the Public Directory and type this command:
```bash
php -S localhost:8888
```
Then, You Can Access The Application in your browser at http://localhost:8888.