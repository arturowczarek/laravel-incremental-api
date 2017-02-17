# We need Dummy Data
- Faker is a library to generate fake data. It's available in Laravel 5.4 by default
- Add dummy data using seeders from `database/seeds`. You can generate one using `php artisan make:seeder SeederName`
- To generate sentence with n words use `$faker->sentence(5)`
- To generate paragraph with n sentences use `$faker->paragraph(4)`
- It's a good practice to truncate tables in master seeder using eg. `Lesson::truncate();`
- To run seeders use `php artisan db:seed`. Be sure to run migrations before
