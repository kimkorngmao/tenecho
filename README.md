# Tenecho - Content Management System

This is a powerful content management system created with Laravel, offering role-based access control, article management, and the ability to track visitors.

## System Overview

Tenecho is a feature-rich CMS that allows you to manage articles, categories, users, and site settings. It includes:

- Role-based access control (RBAC)
- Article management with categories and tags
- Hierarchical category system
- Site settings management
- Visitor tracking
- User authentication and activity logging

## Database Structure

### Core Tables

#### Users
- Manages user accounts
- Fields: username, first_name, last_name, bio, email, avatar_url, password
- Relationships:
  - Has many articles (as author)
  - Belongs to many roles
  - Has many user logins

#### Roles
- Defines user roles (admin, editor, author)
- Fields: name, guard_name
- Relationships:
  - Belongs to many users
  - Belongs to many permissions

#### Permissions
- Stores available permissions
- Fields: name, description
- Relationships:
  - Belongs to many roles

### Content Management

#### Articles
- Stores blog posts and pages
- Fields: type, title, slug, excerpt, content, featured_image_url, status, published_at, author_id, category_id, meta_description, is_featured, view_count
- Relationships:
  - Belongs to author (User)
  - Belongs to category
  - Belongs to many tags

#### Categories
- Manages hierarchical content categories
- Fields: name, slug, description, parent_id, order, is_featured
- Relationships:
  - Has many articles
  - Has many children categories
  - Belongs to parent category

#### Tags
- Organizes articles with tags
- Fields: name, slug, description
- Relationships:
  - Belongs to many articles

### System Tables

#### SiteSettings
- Stores system configuration
- Fields: key, value, type, description, url, image, order, article_id
- Relationships:
  - Belongs to article (optional)

#### UserLogins
- Tracks user login activity
- Fields: user_id, user_agent, ip_address
- Relationships:
  - Belongs to user

#### Visitors
- Tracks page visits
- Fields: ip_address, user_agent, page_visited

## Routes

### Public Routes
```
GET  /                       - Home page
GET  /search                - Search functionality
GET  /articles/latest       - Latest articles
GET  /articles/{slug}       - Show article
GET  /categories/{slug}     - Show category
GET  /{slug}               - Show page
```

### Authentication Routes
```
GET  /login                 - Login page
POST /authenticate          - Process login
POST /logout                - Process logout
```

### Admin Routes (Protected)
All admin routes are prefixed with '/admin' and require authentication

#### Dashboard
```
GET  /admin/dashboard       - Admin dashboard
```

#### Users Management
```
GET    /admin/users              - List users
GET    /admin/users/create       - Create user form
POST   /admin/users             - Store new user
GET    /admin/users/{id}/edit    - Edit user form
PUT    /admin/users/{id}        - Update user
DELETE /admin/users/{id}        - Delete user
```

#### Roles Management
```
GET    /admin/roles             - List roles
GET    /admin/roles/create      - Create role form
POST   /admin/roles            - Store new role
GET    /admin/roles/{id}/edit   - Edit role form
PUT    /admin/roles/{id}       - Update role
DELETE /admin/roles/{id}       - Delete role
```

#### Categories Management
```
GET    /admin/categories             - List categories
GET    /admin/categories/create      - Create category form
POST   /admin/categories            - Store new category
GET    /admin/categories/{id}/edit   - Edit category form
PUT    /admin/categories/{id}       - Update category
DELETE /admin/categories/{id}       - Delete category
```

#### Articles Management
```
GET    /admin/articles             - List articles
GET    /admin/articles/create      - Create article form
POST   /admin/articles            - Store new article
GET    /admin/articles/{id}/edit   - Edit article form
PUT    /admin/articles/{id}       - Update article
DELETE /admin/articles/{id}       - Delete article
```

#### Site Settings Management
```
GET    /admin/settings             - List settings
GET    /admin/settings/create      - Create setting form
POST   /admin/settings            - Store new setting
GET    /admin/settings/{id}/edit   - Edit setting form
PUT    /admin/settings/{id}       - Update setting
DELETE /admin/settings/{id}       - Delete setting
```

## Security

- All admin routes are protected by authentication middleware
- Role-based permissions control access to different sections
- User activities are logged
- Visitor tracking for analytics
- Password hashing for user security

## Getting Started

1. Clone the repository
2. Install dependencies: `composer install && npm install`
3. Copy `.env.example` to `.env` and configure your environment
4. Generate application key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Seed the database: `php artisan db:seed`
7. Start the development server: `php artisan serve`