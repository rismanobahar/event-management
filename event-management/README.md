## DESCRIPTION

**This is a project about book review where there will be some books with review as comments and rating.**

## TECH STACK

This project will using some stacks as follows:
- **laravel** = 10.48.28
- **PHP** = 8.1.10
- **database** = mySQL
- **frontend** = laravel blade
- **composer** = 2.8.1
- **containerization** = Docker

## Installation Steps
                               
- `git clone https://github.com/rismanobahar/book-review-laravel.git`
- `cd book-review`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate --seed`
- `php artisan serve`

## Command Line List Detail

- `composer create-project --prefer-dist laravel/laravel book-review` : create the book-review project.
- `code .` : to open the project folder separately.
- `php artisan make:model Event -m` : to make a model file and migration file for Event.
- `php artisan make:model Attendee -m` : to make a model file and migration file for Attendee.
- `php artisan migrate` : to migrate the database table that has been defined in the migration file before.
- `php artisan make:factory BookFactory --model` : Book = make a dummy data for book table.
- `php artisan make:factory ReviewFactory --model` : Review = make a dummy data for review table.
- `php artisan migrate:refresh --seed` : to insert the dummy data into database.
- `php artisan tinker` : run powershell in CLI.
- `php artisan make:controller Api/EventController --api` : create a resource controller in new Api folder for Event and methods needed for API
- `php artisan make:controller Api/AttendeeController --api` : create a resource controller in new Api folder for Attendee and methods needed for API
- `php artisan route:list` : list all of the route command
- `php artisan make:component StarRating` : to create a component named star rating
- `php artisan make:controller ReviewController --resource` : create a new resource controller for review

## Tinker Commands

- **TINKER** - `$books = \App\Models\Book::with('reviews')->find(1);` : to create a variable called boon and then find certain book and review.
- **TINKER** - `$review = $book->reviews;` : create a variable name $review and then find all the books review.
- **TINKER** - `$book = \App\Models\Book::find(1);` : find the first book.
- **TINKER** - `$books = \App\Models\Book::with('reviews')->take(3)->get();` : find the first 3 books and reviews.
- **TINKER** - `$book->load('reviews');` : to load the reviews data.
- **TINKER** - `$review = new \App\Models\Review();` : create new object that is review.
- **TINKER** - `$review->review = 'This was fine';` : defining this String into database.
- **TINKER** - `$review->rating = 3;` : defining this number into database.
- **TINKER** - `$book->reviews()->save($review);` : inserting the data into database.
- **TINKER** - `$review = $book->reviews()->create(['review' => 'Sample review', 'rating' => 5]);` : insert the review and rating object after making these column fillable in the model.
- **TINKER** - `$review = \App\Models\Review::find(1);` : find review in id 1.
- **TINKER** - `$review->book;` : find the book column via review properties.
- **TINKER** - `$book2 = \App\Models\Book:find(2);` : create a variable $book2 and find the second row book data.
- **TINKER** - `$book2->reviews()->save($review);` : save the review data from id 1(first row of column) and connect it with the book data.
- **TINKER** - `$review = \App\Models\Review::with('book')->find(1);` : find the book and review in the first row data.
- **TINKER** - `\App\Models\Book::where('title', 'LIKE', '%qui%')->get();` : to find particular title column with the 'LIKE' operator and the word 'qui' from - database.
- **TINKER** - `\App\Models\Book::title('delectus')->get();` : a simpler way compared to the previous command after adding particular code in the model.
- **TINKER** - `\App\Models\Book::title('delectus')->where('created_at', '>', '2023-01-01')->get();` : find the particular data where it was created from -3-01-01.
- **TINKER** - `\App\Models\Book::title('delectus')->where('created_at', '>', '2023-01-01')->toSql;` : convert the ORM query into sql query.
- **TINKER** - `\App\Models\Book::withCount('reviews')->get();` : add a new table column to count reviews in each data.
- **TINKER** - `\App\Models\Book::withCount('reviews')->latest()->limit(3)->get();` : only show the top 3 recent data.
- **TINKER** - `\App\Models\Book::limit(5)->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating')->get();` : to get the average rating of reviews for -h book with limit 5 data with the column name : reviews_avg_rating.
- **TINKER** - `\App\Models\Book::limit(5)->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating')->toSql();` : to generate Sql query with limit 5 data.
- **TINKER** - `\App\Models\Book::withCount('reviews')->withAvg('reviews', 'rating')->having('reviews_count', '>=', 10)->orderBy('reviews_avg_rating', 'desc')->limit(10)->get();` : count the reviews average that has the best rating and have at least 10 or more reviews with such amount in descending sort and limit the display in 10.
- **TINKER** - `\App\Models\Book::withCount('reviews')->withAvg('reviews', 'rating')->having('reviews_count', '>=', 10)->orderBy('reviews_avg_rating', 'desc')->limit(10)->toSql();` : convert the code above into Sql query.
- **TINKER** - `\App\Models\Book::popular()->highestRated()->get();` : to list the most popular book based on reviews and rating.
- **TINKER** - `\App\Models\Book::highestRated()->get();` : list the all the book with from the highest rating
- **TINKER** - `\App\Models\Book::highestRated('2023-02-01', '2023-03-30')->popular('2023-02-01', '2023-03-30')->minReviews(2)->get();` : list the top 2 reviews with the highest rating
- **TINKER** - `$review = \App\Models\Review::findOrFail(944);` : find the review with Id 944. If it exists, it returns the Review instance, if it doesn't exist, it throws an error ModelNotFoundException
- **TINKER** - `$review->rating = 4;` : change the rating of that review to 4
- **TINKER** - `$review` : show again the review with id 944
- **TINKER** - `$review->save();` : save the change
- **TINKER** - `$review->update(['rating' => 1]);` : another way/code to change the rating
- **TINKER** - `\App\Models\Review::where('id', 944)->update(['rating' => 2]);` : this code will be working on changing the data in database but will not change the data in web

## folder and file list detail : 

- **app/Models**: Represents a table in the database and provides an interface to interact with it. It contains business logic and relationships.
    - `Book.php` : creating interface to interact with book table.
    - `Review.php` : creating interface to interact with review table.
- **database/factories** : defining/generating model dummy data.
    - `BookFactory.php` :  generate and define the model of dummy data on book table.
    - `ReviewFactory.php` : generate and define the model of dummy data on review table.
- **database/migrations** : Defines the structure of a database table (columns, types, constraints). It is used to create, modify, or delete tables.
    - `create_books_table.php` : define the db structure for books table.
    - `create_reviews_table.php` : define the db structure for review table.
- **database/seeders** : generate dummy data into the database.
    - `DatabaseSeeder.php` : seeds the database with fake/dummy data
- `.env` : configuring database and connection.
- **resources/views** : this directory is functioning for view / interface
    - **/books** : this folder is used for the view of pages
        - `index.blade.php` : displaying home page
        - `show.blade.php` : displaying the the book page
    - **/components** : 
        - `star-rating.blade.php` : use this file to configure blade component for star rating in review 
    - **/layouts** : storing layout templates that define the overall structure of the application's views
        - `app.blade.php` : use this file to store all the styling configuration like Tailwind CSS
- **/app/Providers** : store service provider classes.  Service providers are the central place where Laravel bootstraps and configures various parts of the application, such as binding services into the service container, registering event listeners, or defining route configurations.
    - `RouteServiceProvider.php` : define and configure how routes are loaded and managed in your application.

