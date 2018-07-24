## Installation

#### Require cube-agency/arbory-mail
```bash
composer require cube-agency/arbory-mail
```

#### Publish config files and translations
```bash
php artisan vendor:publish --provider="CubeAgency\ArboryMail\Providers\MailServiceProvider"
```

#### Run migrations
```bash
php artisan migrate
```

#### Enable module by adding to config `config/arbory.php` and register routes in `routes/admin.php`
```php  
'menu' => [
    ...
    \CubeAgency\ArboryMail\Http\Controllers\Admin\MailTemplatesController::class
]
```

```php  
Admin::modules()->register(\CubeAgency\ArboryMail\Http\Controllers\Admin\MailTemplatesController::class);
```

## Usage

#### Add new template to `config/arbory-mail.php`
```php
'templates' => [
    \App\Mail\UserRegistered::class,
]
```

#### Generate required class
```bash
php artisan arbory-mail:generate
```

#### Send message
```php
$message = new UserUpdated();
Mail::to('test@example.com')->send($message);
```