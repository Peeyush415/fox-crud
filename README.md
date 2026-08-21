# Fox CRUD

A Laravel 13 application for building and practicing CRUD (Create, Read, Update, Delete) functionality.

## Tech Stack

- PHP 8.3+
- Laravel 13
- Vite (frontend asset bundling)
- SQLite (default local database)

## Getting Started

### Prerequisites

- PHP 8.3 or higher
- Composer
- Node.js & npm

### Installation

```bash
composer install
npm install
```

### Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### Database

```bash
php artisan migrate
```

### Running the App

```bash
composer dev
```

This starts the Laravel server, queue listener, and Vite dev server together. The app will be available at `http://localhost:8000`.

### Running Tests

```bash
composer test
```

## Project Status

This project currently contains a fresh Laravel installation and serves as the base for upcoming CRUD features.
