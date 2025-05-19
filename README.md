# Creating a Login API with Laravel Passport in Docker Environment

A comprehensive guide to implementing a secure authentication API using Laravel Passport in a Docker environment.


<p align="center">
<img src="https://miro.medium.com/v2/resize:fit:700/1*TEJ93z4l0pEfIu60ythUrA.png" alt="Intro" />
</p>

More information at -
https://medium.com/@murilolivorato/create-a-login-api-step-by-step-with-laravel-passport-in-docker-enviroment-44029c0a91f3

## Overview

This project demonstrates how to build a secure authentication API with:
- Laravel Passport for OAuth2 authentication
- Docker containerization
- RESTful API endpoints
- Token-based authentication
- Secure user management

## Features

- OAuth2 authentication with Laravel Passport
- Docker containerization
- RESTful API endpoints
- Token-based authentication
- User registration and login
- Password reset functionality
- Secure token management
- Docker Compose setup

## Prerequisites

- Docker and Docker Compose
- Basic understanding of Laravel
- Basic knowledge of API development
- Git

## Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd laravel-passport-auth
```

### 2. Environment Setup
1. Copy the environment file:
```bash
cp .env.example .env
```

2. Update the `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Docker Setup
1. Build and start the Docker containers:
```bash
docker-compose up -d --build
```

2. Create a new Laravel project:
```bash
docker-compose run --rm composer create-project laravel/laravel .
```

3. Install Laravel Passport:
```bash
docker-compose run --rm composer require laravel/passport
```

4. Run migrations and install Passport:
```bash
docker-compose run --rm artisan migrate
docker-compose run --rm artisan passport:install
```

## Project Structure
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ │ │ └── Auth/
│ │ │ ├── LoginController.php
│ │ │ ├── RegisterController.php
│ │ │ └── PasswordResetController.php
│ │ └── Middleware/
│ │ └── Authenticate.php
│ ├── Models/
│ │ └── User.php
│ └── Providers/
│ └── AuthServiceProvider.php
├── routes/
│ └── api.php
├── docker/
│ ├── nginx/
│ │ └── default.conf
│ └── php/
│ └── Dockerfile
├── docker-compose.yml
└── .env



## Docker Configuration

### docker-compose.yml
```yaml
version: '3'
services:
  app:
    build:
      context: .
      dockerfile: docker/php/Dockerfile
    volumes:
      - .:/var/www/html
    depends_on:
      - mysql
    networks:
      - laravel-network

  nginx:
    image: nginx:alpine
    ports:
      - "8000:80"
    volumes:
      - .:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app
    networks:
      - laravel-network

  mysql:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_ROOT_PASSWORD: root
      MYSQL_PASSWORD: secret
      MYSQL_USER: laravel
    volumes:
      - mysql-data:/var/lib/mysql
    networks:
      - laravel-network

networks:
  laravel-network:
    driver: bridge

volumes:
  mysql-data:
```

## API Endpoints

### Authentication Endpoints

1. **Register User**
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

2. **Login**
```http
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password"
}
```

3. **Logout**
```http
POST /api/logout
Authorization: Bearer {token}
```

4. **Get User Details**
```http
GET /api/user
Authorization: Bearer {token}
```

## Implementation Details

### User Model
```php
// app/Models/User.php
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
```

### Auth Controller
```php
// app/Http/Controllers/Auth/LoginController.php
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Auth Token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
```

## Security Considerations

1. **Token Management**
   - Secure token storage
   - Token expiration
   - Token refresh mechanism

2. **API Security**
   - HTTPS implementation
   - CORS configuration
   - Rate limiting

3. **User Data Protection**
   - Password hashing
   - Input validation
   - XSS prevention

## Best Practices

1. **Docker Configuration**
   - Use specific version tags
   - Implement proper volume management
   - Configure appropriate resource limits

2. **API Development**
   - Follow RESTful conventions
   - Implement proper error handling
   - Use request validation

3. **Security**
   - Implement proper token management
   - Use environment variables
   - Follow security best practices

## Testing

1. **API Testing**
```bash
# Run tests in Docker
docker-compose run --rm artisan test
```

2. **Manual Testing**
- Use Postman or similar tool to test endpoints
- Verify token generation and validation
- Test error handling

## Author

**Murilo Livorato**
- GitHub: [murilolivorato](https://github.com/murilolivorato)
- LinkedIn: [Murilo Livorato](https://www.linkedin.com/in/murilo-livorato-80985a4a/)

## License

This project is open-sourced software licensed under the MIT license.

## Contributing

Feel free to submit issues and pull requests to improve this implementation.

## Acknowledgments

This implementation follows modern best practices for building secure authentication APIs in Laravel using Docker and Laravel Passport.


## 👥 Author

For questions, suggestions, or collaboration:
- **Author**: Murilo Livorato
- **GitHub**: [murilolivorato](https://github.com/murilolivorato)
- **linkedIn**: https://www.linkedin.com/in/murilo-livorato-80985a4a/


## 📸 Screenshots

### Login Page
![Login Page](https://miro.medium.com/v2/resize:fit:700/1*qFXg58M0-wqkjDLlEb1oIw.png)

### Dashboard
![Dashboard](https://miro.medium.com/v2/resize:fit:700/1*rOioE-qMOp6msM7cgVCQHg.png)


<div align="center">
  <h3>⭐ Star This Repository ⭐</h3>
  <p>Your support helps us improve and maintain this project!</p>
  <a href="https://github.com/murilolivorato/k8s-react-python-ci-cd-deploy
/stargazers">
    <img src="https://img.shields.io/github/stars/murilolivorato/k8s-react-python-ci-cd-deploy
?style=social" alt="GitHub Stars">
  </a>
</div>


