#!/bin/bash

read -p "Enter package name (e.g., MyNewPackage): " PACKAGE

if [ -z "$PACKAGE" ]; then
  echo "Package name cannot be empty."
  exit 1
fi

BASE_DIR="app/Packages/$PACKAGE"

if [ -d "$BASE_DIR" ]; then
  # Print message in red text
  echo -e "\033[31mPackage $PACKAGE already exists at $BASE_DIR\033[0m"
  exit 0
fi

CONTROLLER_DIR="$BASE_DIR/Controllers"
SERVICE_DIR="$BASE_DIR/Services"
MODEL_DIR="$BASE_DIR/Models"
ROUTES_DIR="$BASE_DIR/routes"

mkdir -p "$CONTROLLER_DIR" "$SERVICE_DIR" "$MODEL_DIR" "$ROUTES_DIR"

# Create a basic Controller
cat > "$CONTROLLER_DIR/${PACKAGE}Controller.php" <<EOL
<?php

namespace App\\Packages\\$PACKAGE\\Controllers;

use Illuminate\\Http\\Request;
use App\\Packages\\$PACKAGE\\Services\\${PACKAGE}Service;
use App\\Http\\Controllers\\Controller;

class ${PACKAGE}Controller extends Controller
{
    protected \$service;

    public function __construct(${PACKAGE}Service \$service)
    {
        \$this->service = \$service;
    }

    public function index(Request \$request)
    {
        return response()->json(\$this->service->getData());
    }
}

EOL

# Create a basic Service
cat > "$SERVICE_DIR/${PACKAGE}Service.php" <<EOL
<?php

namespace App\\Packages\\$PACKAGE\\Services;

class ${PACKAGE}Service
{
    public function getData()
    {
        return ['message' => 'Hello from $PACKAGE Service'];
    }
}

EOL

# Model folder intentionally left empty

# Create routes file
cat > "$ROUTES_DIR/web.php" <<EOL
<?php

use Illuminate\\Support\\Facades\\Route;
use App\\Packages\\$PACKAGE\\Controllers\\${PACKAGE}Controller;

Route::prefix('$(echo $PACKAGE | awk '{ print tolower($0) }')')->group(function () {
    Route::get('/', [${PACKAGE}Controller::class, 'index']);
});
EOL

echo -e "\e[32mPackage $PACKAGE created at $BASE_DIR\e[0m"
