# Portfolio Website - Laravel + Livewire + Filament

A modern portfolio website built with Laravel 11, Livewire 3, and Filament admin panel, converted from a static HTML template.

## Project Overview

This project converts a static portfolio template into a dynamic Laravel application with the following features:

-   **Frontend**: Laravel Blade + Livewire components
-   **Backend**: Laravel 11 with Filament admin panel
-   **Styling**: Tailwind CSS + Template assets
-   **Database**: PostgreSQL with comprehensive models
-   **Authentication**: Laravel Sanctum for admin access

## Development Plan

### Phase 1: Template Integration & Basic Setup ✅

-   [x] Laravel 11 installation with Filament
-   [x] Admin user seeder creation
-   [x] Move template assets to Laravel structure
-   [x] Create base layout with template styling
-   [x] Convert HTML template to Blade components
-   [x] Create routes and controllers
-   [x] Set up navigation and footer components

### Phase 2: Database Design & Models

-   [x] Create portfolio database schema
-   [x] Generate models with relationships
-   [x] Create migrations and seeders
-   [x] Set up model factories for testing

### Phase 3: Livewire Components Development ✅

-   [x] Hero/Header section component
-   [x] About section component
-   [x] Services section component
-   [x] Portfolio/Projects section component
-   [x] Skills section component (integrated in AboutSection)
-   [x] Blog section component
-   [x] Contact form component
-   [x] References component

## Identified Template Sections

Based on the template analysis, the portfolio contains:

### 1. **Header/Hero Section**

-   Animated headline with rotating text
-   Social media links
-   Background image with parallax effect

### 2. **About Section**

-   Personal information
-   Profile image
-   Skills progress bars
-   Download CV button

### 3. **Services Section**

-   6 service items with icons
-   Grid layout (3x2)
-   Font Awesome icons

### 4. **Portfolio Section**

-   Filterable gallery (All, Brand, Design, Graphic)
-   Isotope.js for filtering
-   Magnific popup for image viewing
-   Project categories and links

### 5. **References Section**

-   Professional references
-   Contact information display
-   Name, email, phone, and slogan

### 6. **Blog Section**

-   Blog listing page with pagination
-   Single blog post page with full content
-   Category filtering and search functionality
-   Featured posts section
-   Related posts and sidebar widgets
-   Social sharing integration
-   SEO optimization with meta tags
-   Author information and bio

### 7. **Contact Section**

-   Contact information (Address, Email, Phone)
-   Contact form with validation
-   Form submission handling

## Database Schema Design

### Core Models Required:

```
User (existing)
├── id, name, email, password, email_verified_at

Profile
├── id, user_id, title, subtitle, bio, image, cv_file
├── phone, address, social_links (JSON)

Service
├── id, title, description, icon, order, is_active

Skill
├── id, name, percentage, order, is_active

Portfolio/Project
├── id, title, description, image, category_id
├── project_url, github_url, technologies (JSON)
├── is_featured, order, created_at

Category
├── id, name, slug, type (portfolio/blog), order

BlogPost
├── id, title, slug, content, excerpt, image
├── category_id, is_published, created_at

Reference
├── id, name, email, phone, slogan, order, is_active

Contact
├── id, name, email, message, created_at, is_read

Setting
├── id, key, value, type (for site settings)
```

## Technical Implementation Steps

### Step 1: Asset Migration

```bash
# Move template assets
cp -r template/css/* public/css/
cp -r template/js/* public/js/
cp -r template/img/* public/images/
cp -r template/fonts/* public/fonts/
```

### Step 2: Laravel Structure Setup

```bash
# Create controllers
php artisan make:controller HomeController
php artisan make:controller BlogController
php artisan make:controller ContactController

# Create Livewire components
php artisan make:livewire HeroSection
php artisan make:livewire AboutSection
php artisan make:livewire ServicesSection
php artisan make:livewire PortfolioSection
php artisan make:livewire BlogSection
php artisan make:livewire ContactSection

# Create models
php artisan make:model Profile -mfs
php artisan make:model Service -mfs
php artisan make:model Skill -mfs
php artisan make:model Project -mfs
php artisan make:model Category -mfs
php artisan make:model BlogPost -mfs
php artisan make:model Reference -mfs
php artisan make:model Contact -mfs
php artisan make:model Setting -mfs
```

### Step 3: Filament Resources

```bash
# Create Filament resources
php artisan make:filament-resource Profile --generate --view
php artisan make:filament-resource Service --generate --view
php artisan make:filament-resource Skill --generate --view
php artisan make:filament-resource Project --generate --view
php artisan make:filament-resource Category --generate --view
php artisan make:filament-resource BlogPost --generate --view
php artisan make:filament-resource Reference --generate --view
php artisan make:filament-resource Contact --generate --view
php artisan make:filament-resource Setting --generate --view

# Create relation managers
php artisan make:filament-relation-manager CategoryResource Projects title
php artisan make:filament-relation-manager ProfileResource Skills name
```

### Step 4: Frontend Integration

-   ✅ Convert template HTML to Blade layouts
-   ✅ Integrate Livewire components
-   ✅ Maintain original styling and animations
-   ✅ Ensure responsive design works properly
-   ✅ Blog functionality with listing and single post pages
-   ✅ References section replacing clients section

## Features to Implement

### Frontend Features:

-   ✨ **Smooth Scrolling Navigation**
-   🎨 **Animated Headlines** (using original JS)
-   📱 **Responsive Design**
-   🖼️ **Portfolio Filtering** (Isotope.js)
-   📧 **Contact Form** with validation
-   🔄 **Skills Progress Bars**
-   🎭 **Image Lightbox** (Magnific Popup)
-   📊 **Client Logos Carousel**

### Admin Features:

-   🛠️ **Content Management** via Filament
-   👤 **User Management**
-   📝 **Blog Management**
-   🎯 **Portfolio Management**
-   ⚙️ **Site Settings**
-   📊 **Contact Messages**
-   📈 **Analytics Dashboard**

### Technical Features:

-   🔒 **Authentication** (Filament)
-   🗄️ **Database Migrations**
-   🌱 **Seeders** for demo content
-   📦 **Factory Classes** for testing
-   🔧 **Service Classes** for business logic
-   📸 **File Upload** handling
-   📧 **Email Notifications**

## Development Guidelines

### Laravel Best Practices:

-   Use **Service Classes** for business logic
-   Implement **Repository Pattern** where needed
-   Follow **SOLID Principles**
-   Use **strict typing**: `declare(strict_types=1)`
-   Create **final classes** for controllers and services
-   Implement proper **error handling**
-   Use **Laravel's built-in features** (validation, caching, etc.)

### Code Organization:

```
app/
├── Http/Controllers/          # Thin controllers
├── Livewire/                 # Livewire components
├── Models/                   # Eloquent models
├── Services/                 # Business logic
├── Filament/Resources/       # Admin resources
└── Mail/                     # Email classes

resources/
├── views/
│   ├── layouts/             # Base layouts
│   ├── components/          # Blade components
│   └── livewire/           # Livewire views
└── css/                     # Custom styles
```

## Installation & Setup

### Prerequisites:

-   PHP 8.1+
-   Composer
-   Node.js & NPM
-   PostgreSQL
-   Laravel 11

### Initial Setup:

```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start development
php artisan serve
```

### Admin Access:

-   **URL**: `/admin`
-   **Email**: `admin@admin.com`
-   **Password**: `P@ssw0rd`

## Deployment Checklist

-   [ ] Environment configuration
-   [ ] Database optimization
-   [ ] Asset compilation
-   [ ] Cache configuration
-   [ ] Queue setup (if needed)
-   [ ] Email configuration
-   [ ] SSL certificate
-   [ ] Performance monitoring

## Contributing

This is a portfolio conversion project. Follow Laravel and Livewire best practices when contributing.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
