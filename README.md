# Role-Based Authentication System

A comprehensive role-based authentication system built with Laravel, featuring student, teacher, and admin roles with their respective dashboards and functionalities.

## Features

- Multi-role authentication (Admin, Teacher, Student)
- Course and Unit Management
- Student Enrollment System
- Grade Management
- Unit Registration
- Dashboard Analytics
- CSV Export Functionality

## Prerequisites

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM
- Git

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/jameskariuki8/Php-ku-portal.git
   cd RoleBasedAuth
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Create environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure your database**
   Open the `.env` file and update the following database settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=role_based_auth
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. **Run migrations and seed the database**
   ```bash
   php artisan migrate --seed
   ```

8. **Compile assets**
   ```bash
   npm run dev
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

## Database Structure

The system uses the following main tables:

- `users` - Stores user information and roles
- `courses` - Stores course information
- `units` - Stores unit information
- `student_course_enrollments` - Manages student course enrollments
- `student_unit_registrations` - Manages student unit registrations
- `grades` - Stores student grades

## Default Users

After seeding, the following users are created:

1. **Admin**
   - Email: adm@example.com
   - Password: 12345678



## Project Structure

```
RoleBasedAuth/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Students/
│   │   │   └── Teacher/
│   ├── Models/
│   └── Services/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── student/
│   │   └── teacher/
├── routes/
└── tests/
```

## Key Features Implementation

### Authentication
- Role-based middleware
- Custom authentication guards
- Password reset functionality

### Course Management
- Course creation and editing
- Unit management within courses
- Course enrollment system

### Grade Management
- Grade submission by teachers
- Grade viewing by students
- CSV export functionality

### Dashboard Features
- Role-specific dashboards
- Activity tracking
- Statistics and analytics

## API Endpoints

The system provides the following main API endpoints:

- Authentication endpoints
- Course management endpoints
- Grade management endpoints
- User management endpoints

## Security Features

- CSRF protection
- XSS prevention
- SQL injection prevention
- Role-based access control
- Input validation
- Secure password hashing

## Testing

Run the test suite:
```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


## Support

For support, email juniorkariuki735@gmail.com or open an issue in the repository.

