<?php

$routes = [
    'SamplePackage',
    'Another'
];
// Loop through packages and require their route files
foreach ($routes as $package) {
    $routeFile = base_path("app/Packages/{$package}/routes/web.php");
    if (file_exists($routeFile)) {
        require $routeFile;
    }
}
