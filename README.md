# Vuexy Laravel Bootstrap Template

A modern Laravel application integrated with the Vuexy Bootstrap 5 admin template, providing a complete foundation for building professional web applications.

## 🎯 Features

- **Laravel 9.x** - Modern PHP framework
- **Vuexy Bootstrap 5** - Premium admin template
- **Vite** - Fast build tool with hot-reload
- **Docker** - Complete containerized development environment
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

## 📦 Docker Services

The application runs with the following services:

- **app**: Laravel application (PHP 8.1-FPM)
- **nginx**: Web server
- **mysql**: MySQL 8.0 database
- **redis**: Cache server
- **node**: Node.js 18 for asset compilation

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
├── app/                    # Application code
│   ├── Http/
│   │   ├── Controllers/   # Controllers
│   │   └── Middleware/    # Middleware
│   └── Models/            # Eloquent models
├── resources/
│   ├── views/             # Blade templates
│   ├── js/                # JavaScript files
│   └── scss/              # SCSS files
├── tests/
│   ├── Feature/           # Feature tests
│   └── Property/          # Property-based tests
├── docker/                # Docker configuration
├── Makefile              # Make commands
├── docker-compose.yml    # Docker services
└── vite.config.js        # Vite configuration
```

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

## 📖 Documentation

- [Docker Setup Guide](DOCKER.md) - Detailed Docker documentation
- [Quick Start Guide](README-DOCKER.md) - Quick reference
- [Make Commands](.make.examples) - Example commands
- [Laravel Documentation](https://laravel.com/docs)

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
