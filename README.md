# VirtuoMart - E-Commerce Platform

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

VirtuoMart is a full-featured e-commerce platform built with PHP and MySQL. It provides a complete online shopping experience with role-based access control for customers, administrators, delivery personnel, and business owners.

## 📋 Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [User Roles](#user-roles)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### Customer Features
- **User Authentication**: Secure registration and login system with password hashing
- **Product Browsing**: Browse products by categories with search functionality
- **Shopping Cart**: Add, remove, and manage products in cart
- **Custom Orders**: Create custom product orders with specifications
- **Checkout Process**: Complete purchase with multiple payment options
- **Order Tracking**: Track order status and delivery updates
- **Product Reviews**: Rate and review purchased products
- **AI Chatbot**: Integrated customer support chatbot powered by Chatbase

### Admin Features
- **Dashboard**: Comprehensive admin dashboard with analytics
- **Product Management**: Add, edit, and delete products
- **Customer Management**: View and manage registered customers
- **Order Management**: Process and track all orders
- **Report Generation**: Generate business reports and analytics

### Delivery Member Features
- **Delivery Dashboard**: Dedicated dashboard for delivery personnel
- **Order Status Updates**: Update order status (Processing, Shipped, Delivered)
- **Order Overview**: View all assigned deliveries

### Owner Features
- **Business Overview**: High-level business analytics and metrics
- **Product Monitoring**: Monitor all product inventory
- **Performance Reports**: Access detailed business performance reports
- **Customer Chat**: Direct communication with customers

## 🛠️ Technologies Used

### Backend
- **PHP**: Core application logic (PHP 7.4+)
- **MySQL**: Database management with PDO
- **Session Management**: Secure session handling for user authentication

### Frontend
- **HTML5 & CSS3**: Modern, responsive design
- **JavaScript**: Interactive user interface
- **Bootstrap 5.3**: Responsive framework
- **Font Awesome**: Icon library
- **jQuery**: DOM manipulation and AJAX

### Design Patterns
- **Singleton Pattern**: DatabaseConnection class
- **Object-Oriented Programming**: Class-based architecture
- **MVC-inspired Structure**: Separation of concerns

## 📦 Prerequisites

Before installing VirtuoMart, ensure you have the following:

- **Web Server**: Apache 2.4+ or Nginx
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **PHP Extensions**:
  - PDO
  - PDO_MySQL
  - mbstring
  - session
- **Composer** (optional, for dependency management)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/SDRasanjana/VirtuoMartPHP.git
cd VirtuoMartPHP
```

### 2. Configure Database Connection

Edit the `DatabaseConnection.php` file to match your database credentials:

```php
private function __construct() {
    $host = 'localhost';
    $db   = 'virtuomart_db';
    $user = 'your_username';
    $pass = 'your_password';
    
    $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
```

Also update `DbConnector.php` with the same credentials.

### 3. Configure Web Server

#### For Apache (with XAMPP/WAMP)
1. Copy the project folder to your `htdocs` directory
2. Start Apache and MySQL services
3. Access via `http://localhost/VirtuoMartPHP`

#### For Nginx
Configure your server block to point to the project directory and ensure PHP-FPM is running.

## 🗄️ Database Setup

### 1. Create Database

```sql
CREATE DATABASE virtuomart_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Create Tables

Create the following tables in your database:

#### Products Table
```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    sizes VARCHAR(100),
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Registered Customers Table
```sql
CREATE TABLE registered_customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Orders Table
```sql
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    order_date DATETIME NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (customer_id) REFERENCES registered_customer(id)
);
```

#### Customer Reviews Table
```sql
CREATE TABLE customer_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(255),
    review_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Admin Users Table
```sql
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Delivery Members Table
```sql
CREATE TABLE delivery_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_delivery_member BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Business Owner Table
```sql
CREATE TABLE business_owner (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_owner BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Sample Data (Optional)

Insert sample products and test users to get started quickly.

## 📖 Usage

### Access the Application

1. **Homepage**: `http://localhost/VirtuoMartPHP/index.php`
2. **Shop**: `http://localhost/VirtuoMartPHP/shop.php`
3. **Login**: `http://localhost/VirtuoMartPHP/login.php`

### User Roles and Access

#### Regular Customer
- Register at `/register.php`
- Login at `/login.php`
- Browse products, add to cart, and checkout
- View order history and track deliveries
- Submit product reviews and ratings

#### Admin
- Login at `/login.php` with admin credentials
- Access admin dashboard at `/admin_dashboard.php`
- Manage products, customers, and orders
- Generate reports

#### Delivery Member
- Login with delivery member credentials
- Access delivery dashboard at `/delivery_dashboard.php`
- View assigned orders
- Update delivery status

#### Business Owner
- Login with owner credentials
- Access owner dashboard at `/owner_dashboard.php`
- View business analytics
- Monitor overall operations

## 📂 Project Structure

```
VirtuoMartPHP/
├── classes/                    # PHP Classes
│   ├── Admin.php              # Admin functionality
│   ├── Authentication.php      # User authentication
│   ├── CustomOrder.php        # Custom order handling
│   ├── DbConnector.php        # Database connector
│   ├── DeliveryMember.php     # Delivery member operations
│   ├── Feedback.php           # Customer feedback
│   ├── Order.php              # Order management
│   ├── OrderManager.php       # Order processing
│   ├── Owner.php              # Owner operations
│   ├── ProductClass.php       # Product entity
│   ├── RegisteredCustomer.php # Customer operations
│   └── User.php               # User base class
├── css/                       # Stylesheets
├── img/                       # Images and media
│   ├── products/             # Product images
│   ├── banner/               # Banner images
│   └── uploads/              # User uploads
├── library/                   # Third-party libraries
├── font-awesome-4.7.0/       # Font Awesome icons
├── CartManager.php           # Shopping cart logic
├── DatabaseConnection.php     # Singleton DB connection
├── DbConnector.php           # Database connector
├── ShoppingCart.php          # Cart management
├── index.php                 # Homepage
├── shop.php                  # Product listing
├── product.php               # Product details
├── cart.php                  # Shopping cart
├── checkout.php              # Checkout process
├── payment.php               # Payment processing
├── login.php                 # Login page
├── register.php              # Registration page
├── signup.php                # User signup
├── admin_dashboard.php       # Admin panel
├── delivery_dashboard.php    # Delivery panel
├── owner_dashboard.php       # Owner panel
├── customizeorder.php        # Custom order form
├── rating.php                # Product rating
├── blog.php                  # Blog section
├── about.php                 # About page
├── contact.php               # Contact page
└── README.md                 # This file
```

## 👥 User Roles

### Customer
- Browse and search products
- Manage shopping cart
- Place orders (standard and custom)
- Track order status
- Submit reviews and ratings
- Chat support via AI chatbot

### Administrator
- Full system access
- CRUD operations on products
- User management
- Order processing
- Report generation
- System configuration

### Delivery Member
- View assigned deliveries
- Update order status
- Track delivery progress
- Communicate with customers

### Business Owner
- Business analytics dashboard
- Financial reports
- Inventory overview
- Customer insights
- Strategic decision support

## 🔒 Security Features

- **Password Hashing**: Secure password storage using PHP hashing
- **SQL Injection Prevention**: PDO prepared statements
- **Session Security**: Secure session management
- **Role-Based Access Control**: Protected routes based on user roles
- **XSS Protection**: Input sanitization and output escaping

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards
- Follow PSR-12 coding standards for PHP
- Use meaningful variable and function names
- Comment complex logic
- Test your changes thoroughly

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 📧 Contact

Project Link: [https://github.com/SDRasanjana/VirtuoMartPHP](https://github.com/SDRasanjana/VirtuoMartPHP)

## 🙏 Acknowledgments

- Bootstrap for the responsive framework
- Font Awesome for icons
- Chatbase for AI chatbot integration
- All contributors who have helped improve this project

---

**Note**: This is a educational/demonstration project. For production use, ensure proper security audits, add SSL certificates, implement proper error handling, and follow security best practices.
