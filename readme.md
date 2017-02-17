# We Need Dummy Data
- Faker is a library to generate fake data. It's available in Laravel 5.4 by default
- Add dummy data using seeders from `database/seeds`. You can generate one using `php artisan make:seeder SeederName`
- To generate sentence with n words use `$faker->sentence(5)`
- To generate paragraph with n sentences use `$faker->paragraph(4)`
- It's a good practice to truncate tables in master seeder using eg. `Lesson::truncate();`
- To run seeders use `php artisan db:seed`. Be sure to run migrations before

# Level 1: Eloquent Queries to JSON
- Resource controller can be created with `php artisan make:controller -r LessonsController`
- You can show routes with `php artisan route:list`
- To add prefix to routes use:
```php
Route::group(['prefix' => 'api/v1'], function () {
    Route::resource('lessons', 'LessonsController');
});
```
```
+--------+-----------+------------------------------+-----------------+------------------------------------------------+--------------+
| Domain | Method    | URI                          | Name            | Action                                         | Middleware   |
+--------+-----------+------------------------------+-----------------+------------------------------------------------+--------------+
|        | GET|HEAD  | /                            |                 | Closure                                        | web          |
|        | GET|HEAD  | api/user                     |                 | Closure                                        | api,auth:api |
|        | GET|HEAD  | api/v1/lessons               | lessons.index   | App\Http\Controllers\LessonsController@index   | web          |
|        | POST      | api/v1/lessons               | lessons.store   | App\Http\Controllers\LessonsController@store   | web          |
|        | GET|HEAD  | api/v1/lessons/create        | lessons.create  | App\Http\Controllers\LessonsController@create  | web          |
|        | GET|HEAD  | api/v1/lessons/{lesson}      | lessons.show    | App\Http\Controllers\LessonsController@show    | web          |
|        | PUT|PATCH | api/v1/lessons/{lesson}      | lessons.update  | App\Http\Controllers\LessonsController@update  | web          |
|        | DELETE    | api/v1/lessons/{lesson}      | lessons.destroy | App\Http\Controllers\LessonsController@destroy | web          |
|        | GET|HEAD  | api/v1/lessons/{lesson}/edit | lessons.edit    | App\Http\Controllers\LessonsController@edit    | web          |
+--------+-----------+------------------------------+-----------------+------------------------------------------------+--------------+

```
- Returning with `Lessons::all()` is **bad** because
  - We can return too many results
  - There is no way to add meta data
  - It mimics database structure. (You can try to avoid it adding field `protected $hidden = ['password']`; it'll hide this field when entity is cast to array or json)
  - You may one day in the future want to change the field name in the database
  - There is no way to signal headers/response codes

# Level 2: Responses and Codes
- Class `Illuminate\Support\Facades\Response` allows to alleviate some pain related to returning raw data. We use it like this:
```php
$lessons = Lesson::all();
return Response::json([
    'data' => $lessons->toArray()
], 200);
```
- Try to foresee exceptional situations and respond with appropriate responses with correct error codes

# Level 3: Transformations
- When we have boolean fields, they are casted to integer fields. The `true` value becomes `1`. Cast it to boolean before returning
- Use some transformer to transform your model to desired output eg.:
```php
private function transformCollection($lessons)
{
    return array_map([$this, 'transform'], $lessons->toArray());
}

private function transform ($lesson) {
    return [
        'title' => $lesson['title'],
        'body' => $lesson['body'],
        'active' => (boolean) $lesson['some_bool']
    ];
}
```