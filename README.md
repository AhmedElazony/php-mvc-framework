# A PHP Project Using A simple MVC Framework

> Note: This is A Simple Framework That Needs Too much Code Refactoring and 
> Some Function Needs Validations.
> I Will Do It Later!
 
The Framework includes:

- **Routing System**
- **Database QueryBuilder Class**
- **Simple Authentication System**
- **Simple Container**

## To Use The Project

- download the composer from [The Website](https://getcomposer.org/) and install the composer:

- In The Project Directory open the command line and type:
```bash
composer init
```
- Then, type your preferences and then copy the [composer.json](https://github.com/AhmedElazony/php-mvc-project/blob/main/composer.json) autoload section into your composer.json file

- Finally, use These [Database Statements](https://github.com/AhmedElazony/php-mvc-project/blob/main/databaseFile.sql) to make The database of the app, then edit the [Config file](https://github.com/AhmedElazony/php-mvc-project/blob/main/Config/config.php) And The DB [Connection Class](https://github.com/AhmedElazony/php-mvc-project/blob/main/Core/Database/Connection.php) with your configurations.

Now, you can navigate the Public Directory and type this command:
```bash
php -S localhost:8888
```
And Access The Application in your browser at http://localhost:8888.