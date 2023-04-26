# Fruits App

This is a full-fledged project that fetches fruits data from an API, saves it to a database, and provides various functionalities to filter and manage fruits using Symfony PHP framework for backend and Vue.js for frontend.

## Installation

1. Clone the repository from GitHub:

```
git clone ssh://git@github.com:mukhwanak/fruit-app.git
```

2. Change directory to the project folder:

```
cd fruit-app
```

3. Install backend dependencies using Composer:

```
composer install
```

4. Install frontend dependencies using npm (or yarn):

```
npm install
```

## Configuration

1. Configure the database connection in the `.env` file. Update the `DATABASE_URL` with your database credentials:

```
# .env

DATABASE_URL=mysql://user:password@localhost/db_name
```

2. Configure the email settings in the `.env` file. Update the `MAILER_*` variables with your SMTP email provider credentials:

```
# .env

MAILER_TRANSPORT=smtp
MAILER_HOST=smtp.gmail.com
MAILER_PORT=587
MAILER_USERNAME=test@gmail.com
MAILER_PASSWORD=your_password
MAILER_ENCRYPTION=tls
MAILER_FROM_ADDRESS=test@gmail.com
MAILER_FROM_NAME=Your App Name
```

3. Configure any other settings required for your project, such as API endpoints, API keys, etc.

## Database Migration

1. Run the database migration to create the required tables:

```
php bin/console doctrine:migrations:migrate
```

## Startup

1. Start the Symfony development server:

```
php bin/console server:run
```

2. Compile and run the Vue.js (or TypeScript) frontend:

```
npm run dev
```

3. Access the application in your web browser at `http://localhost:8000` (or any other port specified by the Symfony server).

## Usage

1. Run the custom console command to fetch fruits from the API and save them to the database:

```
php bin/console fruits:fetch
```

2. Access the homepage to view all fruits, filter them by name and family, and add them to favorites.

3. Access the favorites page to view and manage your favorite fruits.

4. Access the nutrition facts page to view nutrition facts for all fruits.

## Unit Testing

1. Run PHPUnit tests for backend functionality:

```
php bin/phpunit
```

2. Write additional tests as needed to ensure the correctness and reliability of the application.
