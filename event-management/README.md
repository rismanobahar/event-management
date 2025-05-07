## DESCRIPTION

**This is a project about event management where there will be some user who have linked with some event. in each event the user will be marked as attendee**

## TECH STACK

This project uses the following tech stack:
- **laravel** = 10.48.29
- **PHP** = 8.1.10
- **database** = mySQL
- **frontend** = laravel blade
- **composer** = 2.8.6
- **containerization** = Docker

## Installation Steps
                               
- `git clone https://github.com/rismanobahar/book-review-laravel.git`
- `cd event-management`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate --seed`
- `php artisan serve`

## Command Line List Detail

- `composer --version` : check the php and composer version
- `php artisan --version` : check the laravel version
- `composer create-project --prefer-dist laravel/laravel book-review` : create the book-review project.
- `code .` : to open the project folder separately.
- `php artisan make:model Event -m` : to make a model file and migration file for Event.
- `php artisan make:model Attendee -m` : to make a model file and migration file for Attendee.
- `php artisan migrate` : to migrate the database table that has been defined in the migration file before.
- `php artisan make:factory EventFactory --model=Event or php artisan make:factory EventFactory --model (which gives the same result)` : make a dummy data for event table.
- `php artisan make:seeder EventSeeder` : Creates a seeder file named `EventSeeder` in the `database/seeders` directory. This file is used to define how dummy data for the `events` table will be inserted into the database.
- `php artisan make:seeder AttendeeSeeder` : Creates a seeder file named `AttendeeSeeder` in the `database/seeders` directory. This file is used to define how dummy data for the `attendees` table will be inserted into the database.
- `php artisan migrate:refresh --seed` : to insert the dummy data into database.
- `php artisan tinker` : run powershell in CLI.
- `php artisan make:controller Api/EventController --api` : create a resource controller in new Api folder for Event and methods needed for API
- `php artisan make:controller Api/AttendeeController --api` : create a resource controller in new Api folder for Attendee and methods needed for API
- `php artisan route:list` : list all of the route command
- `php artisan make:resource EventResource` : Creates a resource class named
`EventResource` in the `App\Http\Resources` directory. This class is used to transform and format the `Event` model's data when returning it as a JSON response in APIs.
- `php artisan make:resource UserResource` : Creates a resource class named
`UserResource` in the `App\Http\Resources` directory. This class is used to transform and format the `User` model's data when returning it as a JSON response in APIs.
- `php artisan make:resource AttendeeResource` : Creates a resource class named
`AttendeeResource` in the `App\Http\Resources` directory. This class is used to transform and format the `Attendee` model's data when returning it as a JSON response in APIs.
- `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider` : Publishes the configuration file and migration files for Laravel Sanctum. This command is used to set up Sanctum, which provides a simple way to authenticate single-page applications (SPAs), mobile applications, and simple token-based APIs.
- `php artisan make:controller Api/AuthController` : make a controller file for authentication
- `php artisan make:policy EventPolicy --model=Event` : Creates a policy class named `EventPolicy` in the `App\Policies` directory. This class is used to define authorization logic for the `Event` model, allowing you to control access to specific actions (e.g., view, update, delete) based on user roles or permissions.
- `php artisan make:policy AttendeePolicy --model=Attendee` : Creates a policy class named `AttendeePolicy` in the `App\Policies` directory. This class is used to define authorization logic for the `Attendee` model, allowing you to control access to specific actions (e.g., view, update, delete) based on user roles or permissions.
- `php artisan make:command SendEventReminders` : 


## Tinker Commands

- **TINKER** - `$books = \App\Models\Book::with('reviews')->find(1);` : to create a variable called boon and then find certain book and review.

## folder and file list detail : 

- **app/Models**: Represents a table in the database and provides an interface to interact with it. It contains business logic and relationships.
    - [`Event.php`](/app/Models/Event.php) : creating interface to interact with Event table.
    - [`Attendee.php`](/app/Models/Attendee.php) : creating interface to interact with Attendee table.
    - [`User.php`](/app/Models/User.php) : creating interface to interact with user table
- **database/factories** : defining/generating model dummy data.
    - `BookFactory.php` :  generate and define the model of dummy data on book table.
    - `ReviewFactory.php` : generate and define the model of dummy data on review table.
- **database/migrations** : Defines the structure of a database table (columns, types, constraints). It is used to create, modify, or delete tables.
    - [`create_events_table.php`](/database/migrations/2025_04_03_103429_create_events_table.php) : define the db structure for event table.
    - [`create_attendees_table.php`](/database/migrations/2025_04_03_103448_create_attendees_table.php) : define the db structure for attendees table.
- **database/seeders** : generate dummy data into the database.
    - [`DatabaseSeeder.php`](/database/seeders/DatabaseSeeder.php) : seeds the database table with fake/dummy data
    - [`AttendeeSeeder.php`](/database/seeders/AttendeeSeeder.php) : Seeds the `attendees` table with fake/dummy data by associating users with random events. Then, store the user id and event id as attendee
    - [`EventSeeder.php`](/database/seeders/EventSeeder.php) : Seeds the `events` table with fake/dummy data, creating sample events for the application.
- `.env` : configuring database and connection.
- **routes** : store all route definitions, including API routes
    - [`api.php`](/routes/api.php) : defines routes specifically for API endpoints, such as RESTful routes for controllers. These routes are automatically assigned the "api" middleware group.
- **resources/views** : this directory is functioning for view / interface
    - **/books** : this folder is used for the view of pages
        - `index.blade.php` : displaying home page
        - `show.blade.php` : displaying the the book page
    - **/components** : 
        - `star-rating.blade.php` : use this file to configure blade component for star rating in review 
    - **/layouts** : storing layout templates that define the overall structure of the application's views
        - [`app.blade.php`](/resources/views/) : use this file to store all the styling configuration like Tailwind CSS
- **/app/Providers** : store service provider classes.  Service providers are the central place where Laravel bootstraps and configures various parts of the application, such as binding services into the service container, registering event listeners, or defining route configurations.
    - [`RouteServiceProvider.php`](/app/Providers/RouteServiceProvider.php) : define and configure how routes are loaded and managed in your application.
- **/app/Http/Controllers/Api** : storing resource controller
    - [`AttendeeController.php`](/app/Http/Controllers/Api/AttendeeController.php) :  an api for controlling attendee.
    - [`EventController.php`](/app/Http/Controllers/Api/EventController.php) : an api for controlling event.
    - [`AuthController.php`](/app/Http/Controllers/Api/AuthController.php) : an api for controlling authentication.
- **/app/Http/Resources** : 
    - [`EventResource.php`](/app/Http/Resources/EventResource.php) : Transform and format the Event model data for API responses into JSON format. ensure consistency, security, and clarity in API responses. Can be used to displaying certain field from database to the Postman or frontend.
- **/app/Http/Traits** : 
    - [`CanLoadRelationships.php`](/app/Http/Traits/CanLoadRelationships.php) : A reusable trait that provides functionality to dynamically load relationships for models based on query parameters, ensuring flexibility and reducing repetitive code in controllers. 
- **/app/Providers/** :
    - [`AuthServiceProvider.php`](/app/Providers/AuthServiceProvider.php) : A service provider that defines and registers authentication-related services, such as policies and gates, to control access to various parts of the application.
- **/config/** : 
    - [`config.php`](/config/sanctum.php) : Contains configuration settings for Laravel Sanctum, such as token expiration, middleware, and other options for managing API authentication and token-based security.
