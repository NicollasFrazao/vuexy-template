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
