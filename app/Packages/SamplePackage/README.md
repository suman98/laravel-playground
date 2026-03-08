# SamplePackage

This package demonstrates a modular structure for Laravel packages.

## Structure

- `Controllers/`: Handles HTTP requests for the package.
- `Services/`: Contains business logic and reusable service classes.
- `Models/`: Eloquent models specific to the package.
- `routes/web.php`: Defines package-specific web routes.

## Usage

1. Register the package routes in your main `routes/web.php`:

```php
require base_path('app/Packages/SamplePackage/routes/web.php');
```

2. Access the sample endpoint:

- `/sample` — returns a JSON response from `SampleService`.

## Extending

- Add more controllers, services, models as needed.
- Create additional route files (e.g., `api.php`) for API endpoints.

## Example

- `SampleController` uses `SampleService` to return data.
- `SampleModel` is an Eloquent model for database interaction.
