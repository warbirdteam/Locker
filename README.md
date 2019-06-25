# Locker
Locker is an application for managing user data from [Torn City](https://https://www.torn.com/2011760). It is developed my a small team of folks in the [WarBirds](https://www.torn.com/factions.php?step=profile&ID=13784) family of factions.

# Requirements
If you want to quickly deploy Locker, you may want to look into [DockerLocker](https://github.com/AKermodeBear/docker-locker). If you want a more traditional deployment, you will need:

 1. An http server. Apache or nginx is fine.
 2. PHP 7.2-mbstring with the following extensions:
	 1. pdo
	 2. pdo_mysql
	 3. mysqli
 3. A MySQL (or MariaDB) server.
 4. PHP Composer.

# Installation

Grab a copy of the Locker repository. Set the root directory for your web server to Locker/public. DO NOT set your web server's root directory to the Locker repository, otherwise you will be serving your configuration files out to the world.

Copy Locker/config/locker.json.default to locker.json. Update locker.json file to your liking. Currently you should only need to update the database information.

In the Locker directory, run `composer install` to install dependencies.

Import the default, empty schema, located in Locker/database/001-schema.sql, into your database. If there are additional files, apply them in order (001, 002, 003, etc.)

Create /var/log/locker and ensure it is writable by your web service. As an alternative, you can alter the logging configuration to write somewhere else (/tmp is fine if you're just looking around), or disable it altogether (although this is not recommended).

User registration has not been completed. For now, you will need to create users manually:

`INSERT INTO locker.users (tornid, username, password, tornuserkey, userrole, useremail) VALUES (...)`

TornID: Your user ID on Torn.
Username: Can be empty.
Password: A sha1 hash of your password.
TornUserKey: Your Torn API Key.
UserRole: `admin` for an admin, empty otherwise.
UserEmail: Email address to use for logging in.

At that point you should be able to access Locker and log in.

# Tests

We now have unit tests using the PHPUnit Framework. You can run them via:

`vendor/bin/phpunit --bootstrap vendor/autoload.php tests/`