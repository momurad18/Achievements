<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Achievements Addon for Course portal

 Download the package or clone it.

```
composer install
```

```
php artisan key:generate
```

# Testing
- Current testing environment uses sqlite connection and in memory database if you want to change it please update phpunit file.
```
php artisan test
```

# Run the project and Manual Testing

```
php artisan migrate
```
```
php artisan db:seed
```

# Tests 
  ## AchievementsEndpointTest
  ✓ the application returns a successful response.\
  ✓ the application returns correct keys and values when user has 0 achievement.\
  ✓ the application returns correct keys and values when user has 5 achievements.\
  ✓ the application returns correct keys and values when user unlocked all achievements.
  
  ## BadgesTest
  ✓ a user has beginner badge.\
  ✓ a user can earn intermediate badge.\
  ✓ a user can earn advanced badge.\
  ✓ a user can earn master badge.\
  ✓ a badge unlocked dispatched.\
  ✓ a badge unlocked dispatched n of times.
  ## CommentAchievementsTest
  ✓ a user can unlock first comment written.\
  ✓ a user can unlock 3 comments written.\
  ✓ a user can unlock 5 comments written.\
  ✓ a user can unlock 10 comments written.\
  ✓ a user can unlock 20 comments written.\
  ✓ a comment achievement unlocked dispatched.\
  ✓ a comment achievement unlocked dispatched n of times.
  ## LessonAchievementsTest
  ✓ a user can unlock first lesson achievement.\
  ✓ a user can unlock 5 lessons achievement.\
  ✓ a user can unlock 10 lessons achievement.\
  ✓ a user can unlock 25 lessons achievement.\
  ✓ a user can unlock 50 lessons achievement.\
  ✓ a lesson achievement unlocked dispatched.\
  ✓ a lesson achievement unlocked dispatched n of times.

  # Tests results:
  ## MySql
  - Tests:    24 passed (46 assertions).
  - Duration: 1.32s.

  ## Sqlite
  - Tests:    24 passed (46 assertions).
  - Duration: 0.60s.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
