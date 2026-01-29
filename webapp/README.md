# 🎨 Laravel Portfolio Application

A modern, responsive portfolio website built with Laravel 11, Filament Admin Panel, and Livewire components.

## ✨ Features

-   **🎯 Modern Design**: Responsive portfolio template with smooth animations
-   **📝 Blog System**: Full-featured blog with categories, tags, and featured posts
-   **👨‍💼 Admin Panel**: Complete Filament admin interface for content management
-   **🔧 Dynamic Content**: Manage all content through admin panel
-   **📱 Responsive**: Mobile-first design with Bootstrap/Tailwind
-   **🗃️ SQLite Database**: Lightweight, file-based database perfect for portfolios
-   **🐳 Docker Ready**: Production-ready Docker configuration
-   **⚡ Optimized**: Cached routes, views, and configurations for production

## 🏗️ Project Structure

### Frontend Components

-   **Hero Section**: Dynamic greeting with animated text
-   **About Section**: Personal bio and skills showcase
-   **Services Section**: Service offerings with FontAwesome icons
-   **Portfolio Section**: Project showcase with categories
-   **References Section**: Client testimonials and references
-   **Blog Section**: Article listing with search and categories
-   **Contact Section**: Contact form with social media links

### Admin Management

-   **Profile Management**: Personal information, bio, contact details
-   **Services Management**: Service offerings with custom icons
-   **Projects Management**: Portfolio projects with images and categories
-   **Blog Management**: Posts, categories, and content management
-   **References Management**: Client testimonials and contact info
-   **Settings Management**: Site-wide configuration options

## 🚀 Quick Start with Docker

### Prerequisites

-   Docker & Docker Compose installed
-   Git installed

### Deployment

1. **Clone & Deploy**:

```bash
    git clone <your-repo-url>
    cd moportfolio
    ./deploy.sh
    ```

2. **Access Your Portfolio**:
    - **Website**: http://localhost
    - **Admin Panel**: http://localhost/admin
    - **Default Admin**: admin@admin.com / password

### Manual Docker Setup

```bash
# Build and start
docker-compose build
docker-compose up -d

# View logs
docker-compose logs -f

# Access container shell
docker exec -it moportfolio bash
```

## 🛠️ Development Setup

### Requirements

-   PHP 8.3+
-   Composer
-   Node.js & NPM
-   SQLite

### Installation

```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate --seed

# Build assets
npm run build

# Start development server
php artisan serve
```

## 🗄️ Database Management

### SQLite Benefits

-   **No Server Required**: File-based database
-   **Easy Backup**: Single file to backup/restore
-   **Portable**: Move database with application
-   **Performance**: Fast for read-heavy applications
-   **Simplicity**: No configuration needed

### Backup & Restore

```bash
# Backup database
docker cp moportfolio:/var/www/html/database/database.sqlite ./backup.sqlite

# Restore database
docker cp ./backup.sqlite moportfolio:/var/www/html/database/database.sqlite
docker-compose restart
```

## 🎨 Customization

### Theme Customization

-   Edit `/resources/views/layouts/app.blade.php` for layout
-   Modify `/public/template/css/style.css` for styling
-   Update Livewire components in `/resources/views/livewire/`

### Content Management

All content is manageable through the Filament admin panel:

-   **Profile**: Personal information and social links
-   **Services**: Service offerings with FontAwesome icons
-   **Projects**: Portfolio items with categories
-   **Blog**: Articles with rich content editor
-   **References**: Client testimonials

### Social Media Integration

Social media links are dynamically managed with:

-   **Platform**: Display name (Facebook, Twitter, etc.)
-   **URL**: Link to your profile
-   **Icon**: FontAwesome icon class (fab fa-facebook-f)

Popular FontAwesome icons:

-   Facebook: `fab fa-facebook-f`
-   Twitter: `fab fa-twitter`
-   LinkedIn: `fab fa-linkedin-in`
-   GitHub: `fab fa-github`
-   YouTube: `fab fa-youtube`
-   Instagram: `fab fa-instagram`

## 📁 File Structure

```
moportfolio/
├── app/
│   ├── Filament/Resources/     # Admin panel resources
│   ├── Http/Controllers/       # Web controllers
│   ├── Livewire/              # Livewire components
│   └── Models/                # Eloquent models
├── database/
│   ├── migrations/            # Database schema
│   ├── seeders/              # Sample data
│   └── database.sqlite       # SQLite database
├── docker/                   # Docker configuration
├── resources/
│   └── views/
│       ├── livewire/         # Component templates
│       └── pages/            # Page templates
├── public/template/          # Frontend assets
├── docker-compose.yml        # Docker setup
├── Dockerfile               # Container definition
└── deploy.sh               # Deployment script
```

## 🔧 Configuration

### Environment Variables

Key settings for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-key-here
APP_URL=https://yourdomain.com
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

### Performance Optimization

The Docker setup includes:

-   **Cached Configurations**: Routes, views, config cached
-   **Optimized Autoloader**: Composer optimization
-   **Asset Compilation**: Production builds
-   **Gzip Compression**: Apache compression enabled
-   **Security Headers**: XSS, CSRF protection

## 🛡️ Security Features

-   **CSRF Protection**: Laravel's built-in CSRF
-   **XSS Prevention**: Escaped output by default
-   **SQL Injection**: Eloquent ORM protection
-   **Security Headers**: X-Frame-Options, X-XSS-Protection
-   **Admin Authentication**: Secure admin panel access

## 📊 Monitoring & Maintenance

### Health Checks

```bash
# Container status
docker ps | grep moportfolio

# Application logs
docker-compose logs -f

# Resource usage
docker stats moportfolio
```

### Updates

```bash
# Pull latest changes
git pull origin main

# Rebuild and deploy
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

## 🆘 Support & Troubleshooting

### Common Issues

1. **Permission Errors**:

    ```bash
    docker exec -it moportfolio chown -R www-data:www-data /var/www/html/storage
    ```

2. **Database Issues**:

    ```bash
    docker exec -it moportfolio php artisan migrate:fresh --seed
    ```

3. **Cache Problems**:
    ```bash
    docker exec -it moportfolio php artisan cache:clear
    ```

### Getting Help

-   Check logs: `docker-compose logs -f`
-   Verify file permissions
-   Ensure database is writable
-   Review Docker container resources

## 📈 Production Deployment

For production deployment, see the comprehensive [DEPLOYMENT.md](DEPLOYMENT.md) guide which covers:

-   Server requirements
-   SSL/HTTPS setup
-   Reverse proxy configuration
-   Database backups
-   Security best practices
-   Monitoring and maintenance

---

**Built with ❤️ using Laravel 11, Filament, and Livewire**
