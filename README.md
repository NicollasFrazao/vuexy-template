# Vuexy Laravel Bootstrap Template

A modern Laravel application integrated with the Vuexy Bootstrap 5 admin template, providing a complete foundation for building professional web applications.

## 📋 Version Requirements

| Component | Version | Notes |
|-----------|---------|-------|
| PHP | 8.2+ | Required for Laravel 11 |
| Laravel | 11.x (11.48.0+) | Uses simplified app structure |
| MySQL | 9.1 | |
| Node.js | 22.x LTS (22.22.0+) | |
| Composer | 2.x | |
| NPM | 10.x | Bundled with Node 22 |

### Laravel 11 Changes

Laravel 11 introduced a significantly simplified application structure compared to Laravel 10:

- **No more `app/Http/Kernel.php`** — middleware is now registered in `bootstrap/app.php`
- **No more `app/Console/Kernel.php`** — console commands are registered in `routes/console.php`
- **No more `app/Exceptions/Handler.php`** — exception handling is configured in `bootstrap/app.php`
- **Slimmer `config/` directory** — many config files removed; defaults come from the framework
- **`bootstrap/app.php` is the new central configuration point** for middleware, routing, and exceptions
- **`routes/console.php`** replaces the console kernel for scheduling and command registration
- **Minimum PHP 8.2** is required (PHP 8.1 is no longer supported)

### Compatibility Notes

- This project targets **Laravel 11.x** and is not backward compatible with Laravel 10.x or earlier
- PHP 8.1 is **not supported** — upgrade to PHP 8.2+ before installing
- MySQL 8.0+ is compatible, but MySQL 9.1 is the tested and recommended version
- Node.js 18.x and 20.x may work but Node 22.x LTS is the tested version
- If you are migrating from Laravel 10, refer to the [official upgrade guide](https://laravel.com/docs/11.x/upgrade)

## 🖥️ System Requirements

Before installing, make sure your environment meets the following requirements.

### Software Versions

See the [Version Requirements](#-version-requirements) table above for the exact versions needed.

### PHP Extensions

The following PHP extensions are required and must be enabled:

| Extension | Purpose |
|-----------|---------|
| `pdo` | Database abstraction layer |
| `pdo_mysql` | MySQL driver for PDO |
| `mbstring` | Multi-byte string handling |
| `openssl` | Encryption and HTTPS support |
| `tokenizer` | Required by Laravel |
| `xml` | XML parsing |
| `ctype` | Character type checking |
| `json` | JSON encoding/decoding |
| `bcmath` | Arbitrary precision math |
| `fileinfo` | File MIME type detection |
| `curl` | HTTP client support |
| `zip` | ZIP archive handling (Composer) |
| `intl` | Internationalization support |

To check which extensions are enabled:

```bash
php -m
```

To verify a specific extension:

```bash
php -m | grep pdo
```

### Database

- **MySQL 9.1** is the tested and recommended version
- MySQL 8.0+ is compatible but not officially tested
- MariaDB is **not supported** — use MySQL

### Operating System

- Linux (Ubuntu 22.04+ / Debian 12+ recommended)
- macOS 13+ (via Docker)
- Windows 10/11 with WSL2 (via Docker)

### Docker (Recommended)

If using the Docker-based setup (recommended):

- Docker Engine 20.10+
- Docker Compose v2.x (plugin) or 1.29+ (standalone)
- `make` utility

All PHP extensions and services are pre-configured in the Docker images — no manual extension installation needed.

### Without Docker (Manual Setup)

If running without Docker, ensure the following are installed and configured on your host:

- PHP 8.2+ with all extensions listed above
- Composer 2.x
- Node.js 22.x LTS with NPM 10.x
- MySQL 9.1 server running and accessible
- A web server (Nginx or Apache) configured to serve the `public/` directory

## 🎯 Features

- **Laravel 11.x** - Latest PHP framework
- **PHP 8.2+** - Modern PHP version
- **Vuexy Bootstrap 5** - Premium admin template
- **Vite 5.x** - Fast build tool with hot-reload
- **Docker** - Complete containerized development environment
- **MySQL 9.1** - Latest MySQL database
- **Node.js 22.x LTS** - Latest Node.js LTS version
- **Property-Based Testing** - Comprehensive test suite with Eris
- **PSR-12** - Code style compliance
- **Responsive Design** - Mobile-first approach

## 🚀 Quick Start

### Prerequisites

- Docker (version 20.10+)
- Docker Compose (version 1.29+)
- Make

### Installation

```bash
make install
```

This single command will:
- Create `.env` file
- Build Docker images
- Start containers
- Install dependencies (Composer & NPM)
- Generate application key
- Run migrations
- Compile assets
- Set permissions

### Access the Application

🌐 **Application**: http://localhost:8000  
🔥 **Vite HMR**: http://localhost:5173

## 🔧 Installation

### Option 1: Docker (Recommended)

This is the easiest way to get started. All services (PHP, MySQL, Redis, Node.js) are pre-configured.

#### Step 1 — Clone the repository

```bash
git clone <repository-url> vuexy-laravel
cd vuexy-laravel
git checkout template/laravel/bootstrap/starter
```

#### Step 2 — Configure the environment

Copy the example environment file and adjust as needed:

```bash
cp .env.example .env
```

Key variables to review in `.env`:

```env
APP_NAME="Vuexy Laravel"
APP_URL=http://localhost:8000

# Docker uses the service name 'mysql' as the host
DB_HOST=mysql
DB_DATABASE=vuexy_laravel
DB_USERNAME=vuexy
DB_PASSWORD=secret
```

> The default values work out of the box with Docker — no changes required for local development.

#### Step 3 — Build and start containers

```bash
make build   # Build Docker images (only needed the first time)
make up      # Start all containers in the background
```

#### Step 4 — Install PHP dependencies

```bash
make composer-install
```

#### Step 5 — Generate the application key

```bash
make artisan CMD="key:generate"
```

This sets `APP_KEY` in your `.env` file. The application will not run without it.

#### Step 6 — Configure the database and run migrations

The Docker MySQL container is created automatically with the credentials from `.env`. Run the migrations:

```bash
make migrate
```

#### Step 7 — Install Node dependencies and compile assets

```bash
make npm-install
make npm-build
```

#### Step 8 — Access the application

Open http://localhost:8000 in your browser.

---

### Option 2: Manual Installation (Without Docker)

Use this approach if you prefer to run PHP, MySQL, and Node.js directly on your host machine.

#### Prerequisites

Ensure the following are installed and running:

- PHP 8.2+ with extensions: `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `curl`, `zip`, `intl`
- Composer 2.x
- Node.js 22.x LTS with NPM 10.x
- MySQL 9.1 server

#### Step 1 — Clone the repository

```bash
git clone <repository-url> vuexy-laravel
cd vuexy-laravel
git checkout template/laravel/bootstrap/starter
```

#### Step 2 — Install PHP dependencies

```bash
composer install
```

#### Step 3 — Configure the environment

```bash
cp .env.example .env
```

Edit `.env` and update the database connection to point to your local MySQL server:

```env
APP_NAME="Vuexy Laravel"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vuexy_laravel
DB_USERNAME=your_mysql_user
DB_PASSWORD=your_mysql_password
```

#### Step 4 — Generate the application key

```bash
php artisan key:generate
```

This writes a unique `APP_KEY` value into your `.env` file. Never share or commit this key.

#### Step 5 — Configure the database

Create the database in MySQL:

```sql
CREATE DATABASE vuexy_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then run the migrations:

```bash
php artisan migrate
```

#### Step 6 — Install Node dependencies and compile assets

```bash
npm install
npm run build
```

#### Step 7 — Start the development server

```bash
php artisan serve
```

The application will be available at http://localhost:8000.

---

### One-Command Setup (Docker only)

If you just want to get running as fast as possible:

```bash
cp .env.example .env
make install
```

`make install` runs all the steps above (build, up, composer install, key:generate, migrate, npm install, npm build) in one go.

---

## 💻 Development

### Starting the Development Server

#### With Docker (recommended)

```bash
make up
```

The application will be available at http://localhost:8000. The PHP-FPM container serves the Laravel app through Nginx automatically — no separate `artisan serve` needed.

If you need to run `artisan serve` explicitly inside the container:

```bash
docker compose exec app php artisan serve --host=0.0.0.0 --port=8000
```

#### Without Docker (manual)

```bash
php artisan serve
```

The application will be available at http://localhost:8000.

---

### Compiling Assets

#### Development build (with hot-reload / HMR)

With Docker:

```bash
make npm-dev
# or watch for changes continuously:
make npm-watch
```

Without Docker:

```bash
npm run dev
```

Vite will start a dev server at http://localhost:5173 and automatically reload the browser when you change JavaScript or CSS files.

#### Production build

With Docker:

```bash
make npm-build
```

Without Docker:

```bash
npm run build
```

Compiled assets are written to `public/build/`. Always run a production build before deploying.

---

### Running Tests

#### With Docker

```bash
# Run the full test suite
make test

# Run a specific test class or method
make test-filter FILTER=DashboardTest

# Run with code coverage report
make test-coverage
```

Or directly via Artisan inside the container:

```bash
docker compose exec app php artisan test
```

#### Without Docker

```bash
php artisan test
```

Run a specific test:

```bash
php artisan test --filter=DashboardTest
```

Run with coverage (requires Xdebug or PCOV):

```bash
php artisan test --coverage
```

---

## 📦 Docker Services

The application runs with the following services:

- **app**: Laravel application (PHP 8.2-FPM)
- **nginx**: Web server
- **mysql**: MySQL 9.1 database
- **redis**: Cache server
- **node**: Node.js 22.x LTS for asset compilation

### Exposed Ports

- `8000` - Web application
- `3306` - MySQL
- `6379` - Redis
- `5173` - Vite dev server

## 🛠️ Development Commands

### Container Management

```bash
make up              # Start containers
make down            # Stop containers
make restart         # Restart containers
make logs            # View all logs
make logs-app        # View app logs
make ps              # List running containers
make status          # Check container status
```

### Shell Access

```bash
make shell           # Access app container
make shell-node      # Access node container
make mysql-cli       # Access MySQL CLI
```

### Composer

```bash
make composer-install                    # Install dependencies
make composer-update                     # Update dependencies
make composer-require PACKAGE=vendor/pkg # Install specific package
make composer-dump                       # Regenerate autoload
```

### NPM & Assets

```bash
make npm-install     # Install NPM dependencies
make npm-build       # Build assets (production)
make npm-dev         # Build assets (development)
make npm-watch       # Watch for asset changes
```

### Laravel Artisan

```bash
make artisan CMD="route:list"  # Run artisan command
make migrate                   # Run migrations
make migrate-fresh             # Reset database and run migrations
make seed                      # Run seeders
make fresh                     # Reset database, migrations, and seeders
make tinker                    # Open Laravel Tinker
```

### Cache Management

```bash
make cache-clear      # Clear application cache
make config-clear     # Clear config cache
make route-clear      # Clear route cache
make view-clear       # Clear view cache
make clear-all        # Clear all caches
make cache-optimize   # Optimize cache for production
```

### Testing

```bash
make test                          # Run all tests
make test-filter FILTER=Dashboard  # Run filtered tests
make test-coverage                 # Run with coverage
make test-parallel                 # Run in parallel
```

### Cleanup

```bash
make clean           # Remove containers, volumes, and images
make clean-build     # Remove and rebuild everything
make prune           # Remove unused Docker resources
make reset           # Complete reset (clean and reinstall)
```

## 📚 Common Workflows

### Daily Development

```bash
# Morning - start work
make up

# During the day - view logs
make logs-app

# Run tests
make test

# End of day - stop containers
make down
```

### Adding New Feature

```bash
# Create migration
make artisan CMD="make:migration create_posts_table"

# Run migration
make migrate

# Create model
make artisan CMD="make:model Post"

# Run tests
make test
```

### Adding Dependencies

```bash
# PHP package
make composer-require PACKAGE=vendor/package

# JavaScript package
make shell-node
npm install package-name
```

## 🧪 Testing

The project includes comprehensive property-based tests using the Eris library:

```bash
# Run all tests
make test

# Run specific test
make test-filter FILTER=LayoutTest

# Run with coverage
make test-coverage
```

## 📁 Project Structure

```
.
├── app/                            # Application PHP code
│   ├── Http/
│   │   ├── Controllers/            # Request handlers (DashboardController, PageController, etc.)
│   │   └── Middleware/             # HTTP middleware
│   ├── Models/                     # Eloquent models (User, etc.)
│   └── Providers/                  # Service providers (AppServiceProvider)
├── bootstrap/
│   └── app.php                     # Laravel 11 central config (middleware, routing, exceptions)
├── config/                         # Application configuration files
├── database/
│   ├── factories/                  # Model factories for testing
│   ├── migrations/                 # Database schema migrations
│   └── seeders/                    # Database seeders
├── docker/                         # Docker service configuration
│   ├── mysql/my.cnf                # MySQL configuration
│   ├── nginx/conf.d/default.conf   # Nginx virtual host
│   └── php/local.ini               # PHP runtime settings
├── public/                         # Web server document root
│   └── build/                      # Compiled assets (generated by Vite)
├── resources/
│   ├── css/                        # Stylesheets
│   │   ├── app.css                 # Custom application styles (your overrides go here)
│   │   ├── core.css                # Vuexy core styles
│   │   ├── theme-default.css       # Vuexy default theme
│   │   └── vendors/                # Third-party CSS (copied from template)
│   ├── images/                     # Static images
│   │   ├── avatars/                # User avatar images
│   │   ├── illustrations/          # Page illustration images
│   │   └── favicon/                # Favicon files
│   ├── js/                         # JavaScript source files
│   │   ├── app.js                  # Main JS entry point (your custom scripts go here)
│   │   ├── bootstrap.js            # Axios / Echo setup
│   │   ├── config.js               # Template configuration (theme, layout options)
│   │   ├── main.js                 # Vuexy initialisation
│   │   ├── template.js             # Template JS entry point
│   │   └── vendors/                # Third-party JS (copied from template)
│   ├── vendor/                     # Vendor fonts and SCSS source (from Vuexy)
│   └── views/                      # Blade templates
│       ├── layouts/
│       │   └── app.blade.php       # Master layout (HTML shell, @vite directives)
│       ├── components/             # Reusable Blade components
│       │   ├── sidebar.blade.php   # Navigation sidebar
│       │   ├── navbar.blade.php    # Top navigation bar
│       │   └── footer.blade.php    # Page footer
│       ├── pages/                  # Additional page views
│       │   ├── account-settings.blade.php
│       │   └── profile.blade.php
│       ├── errors/
│       │   └── 404.blade.php       # Custom 404 error page
│       └── dashboard.blade.php     # Dashboard page view
├── routes/
│   ├── web.php                     # Web routes (browser-facing)
│   ├── api.php                     # API routes
│   └── console.php                 # Scheduled commands (replaces Console Kernel in L11)
├── tests/
│   ├── Feature/                    # HTTP / integration tests
│   ├── Property/                   # Property-based tests (Eris)
│   └── Unit/                       # Unit tests
├── docker-compose.yml              # Docker services definition
├── Dockerfile                      # PHP-FPM application image
├── Makefile                        # Developer shortcuts (make up, make test, etc.)
├── vite.config.js                  # Vite build configuration and aliases
└── .env.example                    # Environment variable template
```

### Key Directories Explained

| Directory | Purpose |
|-----------|---------|
| `app/Http/Controllers/` | One controller per feature area. Each public method maps to a route and returns a view or JSON response. |
| `app/Models/` | Eloquent models. Each model represents a database table and defines relationships, casts, and fillable fields. |
| `resources/views/layouts/` | Master layout files. All page views extend `app.blade.php` via `@extends('layouts.app')`. |
| `resources/views/components/` | Blade components included automatically by the layout (sidebar, navbar, footer). |
| `resources/views/pages/` | One view per page that is not the dashboard. Mirrors the route group structure in `routes/web.php`. |
| `resources/css/` | CSS entry points processed by Vite. `app.css` is the right place for project-specific overrides. |
| `resources/js/` | JS entry points processed by Vite. `app.js` is the right place for project-specific scripts. |
| `resources/images/` | Static images referenced in Blade templates via the `@img` alias or `asset()` helper. |
| `routes/web.php` | All browser-facing routes. Grouped by feature prefix (e.g., `pages/`). |
| `tests/Property/` | Eris property-based tests that verify universal correctness properties across many inputs. |
| `docker/` | Per-service configuration files mounted into Docker containers at runtime. |

### Where to Add New Code

**New Blade component** — create `resources/views/components/<name>.blade.php` and include it with `<x-name />` or `@include('components.name')`.

**New page view** — create `resources/views/pages/<name>.blade.php` extending the master layout:

```blade
@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    {{-- your content here --}}
@endsection
```

**New controller** — run `php artisan make:controller <Name>Controller` (or `make artisan CMD="make:controller <Name>Controller"` with Docker). Place it in `app/Http/Controllers/`.

**New route** — add it to `routes/web.php`. Group related routes under a common prefix:

```php
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{post}', [BlogController::class, 'show'])->name('show');
});
```

**New model + migration** — run `php artisan make:model <Name> -m`. The model goes to `app/Models/` and the migration to `database/migrations/`.

**New CSS styles** — add them to `resources/css/app.css`. For larger feature-specific stylesheets, create a new file under `resources/css/` and import it from `app.css`.

**New JavaScript** — add scripts to `resources/js/app.js`. For larger modules, create a new file under `resources/js/` and import it from `app.js`.

## 📄 Creating New Pages

This section walks through a complete example of adding a new "Blog" page to the application — from route to controller to view.

### Step 1 — Add the route

Open `routes/web.php` and add a route group for your new section:

```php
use App\Http\Controllers\BlogController;

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{id}', [BlogController::class, 'show'])->name('show');
});
```

This creates two named routes: `blog.index` (`/blog`) and `blog.show` (`/blog/{id}`).

### Step 2 — Create the controller

Generate the controller with Artisan:

```bash
# With Docker
make artisan CMD="make:controller BlogController"

# Without Docker
php artisan make:controller BlogController
```

Then open `app/Http/Controllers/BlogController.php` and implement the methods:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = [
            ['id' => 1, 'title' => 'First Post', 'excerpt' => 'Introduction to our blog.'],
            ['id' => 2, 'title' => 'Second Post', 'excerpt' => 'More content here.'],
        ];

        return view('pages.blog.index', compact('posts'));
    }

    public function show(int $id): View
    {
        // Replace with a real database query when ready
        $post = ['id' => $id, 'title' => "Post #{$id}", 'body' => 'Full post content goes here.'];

        return view('pages.blog.show', compact('post'));
    }
}
```

### Step 3 — Create the views

Create the directory and view files:

```bash
mkdir -p resources/views/pages/blog
```

**`resources/views/pages/blog/index.blade.php`**

```blade
@extends('layouts.app')

@section('title', 'Blog')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Blog</h4>

    <div class="row">
        @foreach ($posts as $post)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $post['title'] }}</h5>
                    <p class="card-text">{{ $post['excerpt'] }}</p>
                    <a href="{{ route('blog.show', $post['id']) }}" class="btn btn-primary">
                        Read More
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
```

**`resources/views/pages/blog/show.blade.php`**

```blade
@extends('layouts.app')

@section('title', $post['title'])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <a href="{{ route('blog.index') }}" class="text-muted fw-light">Blog /</a>
        {{ $post['title'] }}
    </h4>

    <div class="card">
        <div class="card-body">
            <p>{{ $post['body'] }}</p>
            <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary">
                &larr; Back to Blog
            </a>
        </div>
    </div>
</div>
@endsection
```

### Step 4 — Add a sidebar link (optional)

Open `resources/views/components/sidebar.blade.php` and add a menu item inside the navigation list:

```blade
<li class="menu-item {{ request()->routeIs('blog.*') ? 'active' : '' }}">
    <a href="{{ route('blog.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-news"></i>
        <div>Blog</div>
    </a>
</li>
```

### Step 5 — Verify

Visit http://localhost:8000/blog in your browser. The page should render using the full Vuexy layout with sidebar, navbar, and footer.

To confirm the routes are registered:

```bash
make artisan CMD="route:list --path=blog"
# or without Docker:
php artisan route:list --path=blog
```

---

## 🔧 Troubleshooting

### Permission Issues

```bash
make permissions
```

### Clean Start

```bash
make reset
```

### Database Connection Issues

Check if MySQL is ready:

```bash
make logs-mysql
```

Wait for the message: `ready for connections`

### Asset Compilation Issues

```bash
make shell-node
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Containers Won't Start

```bash
make down
make clean-build
```

## 🚢 Production

For production build:

```bash
make prod-build
```

The production stage:
- Installs only production dependencies
- Optimizes Composer autoloader
- Caches Laravel configurations, routes, and views
- Removes unnecessary files

⚠️ **Security Note**: Default credentials are for development only. In production:

1. Change all passwords in `.env`
2. Use Docker secrets for sensitive credentials
3. Configure SSL/TLS in Nginx
4. Restrict exposed ports
5. Use official and updated images

## 📊 Environment Information

### Default Credentials (Development Only)

- **Database**: vuexy_laravel
- **User**: vuexy
- **Password**: secret

### Docker File Structure

```
.
├── Makefile                    # Make commands
├── docker-compose.yml          # Service configuration
├── Dockerfile                  # PHP application image
├── .dockerignore              # Build exclusions
└── docker/
    ├── nginx/
    │   └── conf.d/
    │       └── default.conf   # Nginx configuration
    ├── php/
    │   └── local.ini          # PHP configuration
    └── mysql/
        └── my.cnf             # MySQL configuration
```

## 💡 Command Examples

### Setup & Installation

```bash
# First time setup
make install

# Check if .env exists
make env-check

# Quick start (alias for install)
make quick-start
```

### Container Operations

```bash
# Start containers
make up

# Stop containers
make down

# Restart all containers
make restart

# View running containers
make ps

# Check container status
make status

# View all logs in real-time
make logs

# View specific service logs
make logs-app
make logs-nginx
make logs-mysql
make logs-node
```

### Development Workflow

```bash
# Access app container shell
make shell

# Access node container shell
make shell-node

# Access MySQL CLI
make mysql-cli

# Start development with hot-reload
make dev
```

### Composer Operations

```bash
# Install dependencies
make composer-install

# Update dependencies
make composer-update

# Add new package
make composer-require PACKAGE=spatie/laravel-permission

# Regenerate autoload
make composer-dump
```

### NPM & Asset Management

```bash
# Install NPM dependencies
make npm-install

# Build for development (once)
make npm-dev

# Build for production
make npm-build

# Watch for changes
make npm-watch

# View Vite logs
make logs-node
```

### Database Operations

```bash
# Create new migration
make artisan CMD="make:migration create_posts_table"

# Run migrations
make migrate

# Reset database and run migrations
make migrate-fresh

# Rollback last migration
make migrate-rollback

# Run seeders
make seed

# Complete reset (migrations + seeders)
make fresh

# Access MySQL directly
make mysql-cli
```

### Artisan Commands

```bash
# List all routes
make artisan CMD="route:list"

# Create controller
make artisan CMD="make:controller PostController"

# Create model with migration
make artisan CMD="make:model Post -m"

# Create seeder
make artisan CMD="make:seeder PostSeeder"

# Create request
make artisan CMD="make:request StorePostRequest"

# Open Tinker
make tinker
```

### Cache Operations

```bash
# Clear application cache
make cache-clear

# Clear configuration cache
make config-clear

# Clear route cache
make route-clear

# Clear view cache
make view-clear

# Clear all caches
make clear-all

# Optimize for production
make cache-optimize
```

### Testing Commands

```bash
# Run all tests
make test

# Run specific test
make test-filter FILTER=DashboardTest

# Run with coverage report
make test-coverage

# Run tests in parallel
make test-parallel
```

### Maintenance & Cleanup

```bash
# Fix file permissions
make permissions

# Stop and remove containers
make down

# Remove containers, volumes, and images
make clean

# Remove and rebuild everything
make clean-build

# Remove unused Docker resources
make prune

# Complete reset (clean + reinstall)
make reset

# Rebuild and restart everything
make rebuild
```

### Information Commands

```bash
# Display application info
make info

# Check container status
make status

# View all available commands
make help
```

### Git Shortcuts

```bash
# View git status
make git-status

# Quick commit
make git-commit MSG="feat: add new feature"

# Push to remote
make git-push
```

## 🔄 Complete Workflow Examples

### First Time Setup

```bash
make install
```

### Daily Development Routine

```bash
# Morning - start work
make up

# View logs during development
make logs-app

# Run tests
make test

# End of day - stop containers
make down
```

### Adding New Feature with Migration

```bash
# Create migration
make artisan CMD="make:migration create_posts_table"

# Create model
make artisan CMD="make:model Post"

# Create controller
make artisan CMD="make:controller PostController"

# Run migration
make migrate

# Run tests
make test
```

### Adding Dependencies

```bash
# PHP package
make composer-require PACKAGE=vendor/package

# JavaScript package
make shell-node
npm install package-name
exit
```

### Debugging Issues

```bash
# View application logs
make logs-app

# Enter container for debugging
make shell

# View Laravel logs
tail -f storage/logs/laravel.log
```

### Deployment Preparation

```bash
# Run tests
make test

# Build production assets
make npm-build

# Optimize cache
make cache-optimize

# Build production image
make prod-build
```

### Development with Hot-Reload

```bash
# Start containers
make up

# Start Vite dev server with hot-reload
make dev
```

The Vite dev server will automatically reload when you make changes to:
- JavaScript files
- SCSS files
- Vue components (if applicable)

Access points:
- Application: http://localhost:8000
- Vite HMR: http://localhost:5173

## 🔧 Advanced Troubleshooting

### Permission Issues

```bash
make permissions
```

### Database Won't Connect

```bash
# Check MySQL logs
make logs-mysql

# Wait for this message: "ready for connections"
```

### Assets Won't Compile

```bash
make shell-node
rm -rf node_modules package-lock.json
npm install
npm run build
exit
```

### Containers Won't Start

```bash
make down
make clean-build
```

### Complete Fresh Start

```bash
make reset
```

## 🚢 Production Deployment

### Build for Production

```bash
make prod-build
```

The production build:
- Installs only production dependencies
- Optimizes Composer autoloader
- Caches Laravel configurations, routes, and views
- Removes development files and dependencies

### Pre-Deployment Checklist

```bash
# Run full test suite
make test

# Build production assets
make npm-build

# Optimize all caches
make cache-optimize

# Optimize Composer autoload
make composer-dump
```

### Production Environment Variables

Update your `.env` file with production values:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_HOST=your-production-db-host
DB_DATABASE=your-production-db
DB_USERNAME=your-production-user
DB_PASSWORD=your-secure-password

REDIS_HOST=your-production-redis-host
```

### Security Considerations

⚠️ **CRITICAL**: Default credentials are for development only!

In production, you MUST:

1. Change all passwords in `.env`
2. Use Docker secrets for sensitive credentials
3. Configure SSL/TLS in Nginx
4. Restrict exposed ports (don't expose MySQL/Redis publicly)
5. Use official and regularly updated Docker images
6. Enable firewall rules
7. Set up proper backup strategies
8. Configure log rotation
9. Enable security headers in Nginx
10. Use environment-specific `.env` files

### Docker Volumes

- **mysql-data**: Persistent MySQL data (survives container restarts)
- **./**: Application code (mounted as volume in development)

### Docker Network

All services communicate through the `vuexy-network` bridge network, allowing containers to reference each other by service name (e.g., `mysql`, `redis`).

## 📖 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vite Documentation](https://vitejs.dev)
- [Docker Documentation](https://docs.docker.com)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.0)

## 🤝 Contributing

Thank you for considering contributing to this project! Please ensure:

- Code follows PSR-12 standards
- All tests pass before submitting
- Property-based tests are included for new features
- Documentation is updated accordingly

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.

For more information, visit [laravel.com](https://laravel.com).

---

**Need help?** Run `make help` to see all available commands!
