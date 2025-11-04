# 🌱 Greenlife Wellness Center - Web Application

**A comprehensive wellness center management system built with PHP, MySQL, HTML, CSS, and JavaScript**

## 📋 Overview

Greenlife Wellness Center is a full-stack web application designed to streamline wellness center operations and enhance client-therapist interactions. The system provides role-based access for clients, therapists, and administrators, offering a complete digital solution for appointment scheduling, user management, and communication.

## ✨ Key Features

### 🔐 **Multi-Role Authentication System**
- **Client Registration & Login**: Secure account creation for wellness center clients
- **Therapist Portal**: Specialized access for healthcare providers and therapists
- **Admin Dashboard**: Comprehensive administrative controls and oversight
- **Secure Password Hashing**: BCrypt encryption for all user passwords

### 📅 **Appointment Management**
- **Online Booking**: Clients can schedule appointments for various wellness services
- **Service Selection**: Multiple wellness services including:
  - Wellness Coaching
  - Nutrition & Diet Counseling
  - Acupuncture
  - Ayurvedic Therapy
- **Advanced Search & Filtering**: Search appointments by client name, email, service type, or date
- **Cancellation System**: Easy appointment cancellation for both clients and administrators

### 💬 **Communication System**
- **Client Messaging**: Direct communication channel between clients and administration
- **Message Management**: Admin reply system with timestamp tracking
- **Contact Forms**: Integrated contact system for inquiries and support

### 👥 **User Management**
- **Profile Management**: Editable user profiles for all role types
- **Therapist Profiles**: Specialized therapist information including bio and contact details
- **User Directory**: Administrative overview of all registered users
- **Account Deletion**: Administrative user management capabilities

### 📊 **Admin Dashboard Features**
- **User Overview**: Complete list of registered clients, therapists, and administrators
- **Appointment Analytics**: Comprehensive appointment tracking and management
- **Message Center**: Centralized communication hub with reply functionality
- **Search & Filter Tools**: Advanced filtering for efficient data management

## 🏗️ Technical Architecture

### **Development Stack**
- **Backend**: PHP 8.2+ with MySQLi
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Security**: BCrypt password hashing, prepared statements
- **Server**: Apache/LAMP stack compatible

### **Database Schema**
users: User authentication and profile information

appointments: Appointment scheduling and management

messages: Client-admin communication system

text

### **Project Structure**
Greenlife-Wellness-Center/
├── backend/
│ ├── db.php # Database connection
│ ├── login.php # Authentication handler
│ ├── register.php # User registration
│ ├── appointment.php # Appointment booking
│ ├── message.php # Messaging system
│ ├── cancel_appointment.php # Appointment cancellation
│ ├── reply.php # Admin message replies
│ └── update_profile.php # Profile management
├── dashboard/ # Admin dashboard interface
├── login/ # Authentication pages
├── register/ # User registration interface
├── appointment/ # Appointment booking system
├── services/ # Service information pages
├── contactus/ # Contact forms and information
├── blog/ # Wellness blog and articles
├── aboutus/ # About page and company information
├── index/ # Homepage and main navigation
└── greenlife_db.sql # Database schema and sample data

text

## 🚀 Getting Started

### **Prerequisites**
- PHP 8.0 or higher
- MySQL/MariaDB 10.4+
- Apache Web Server
- phpMyAdmin (recommended for database management)

### **Installation**
1. **Clone the repository**
git clone https://github.com/adnan-fazal/Greenlife-Wellness-Center.git

text

2. **Set up the database**
- Import `greenlife_db.sql` into your MySQL database
- Update database credentials in `backend/db.php`

3. **Configure web server**
- Place project files in your web server directory (htdocs/www)
- Ensure PHP and MySQL services are running

4. **Access the application**
- Navigate to `http://localhost/Greenlife-Wellness-Center/index/`

## 🔑 Default Login Credentials

### **Administrator Access**
- **Email**: admin@greenlife.com
- **Password**: admin123

### **Client Access**
- **Email**: client@greenlife.com
- **Password**: 123

### **Therapist Access**
- **Email**: therapist@greenlife.com
- **Password**: 123

## 💾 Database Configuration

The system uses a comprehensive MySQL database with the following tables:
- **users**: Stores user authentication and profile data with role-based access
- **appointments**: Manages appointment scheduling with service categorization
- **messages**: Handles client-admin communication with reply functionality

## 🎨 User Interface

- **Responsive Design**: Mobile-friendly interface compatible with various devices
- **Intuitive Navigation**: User-friendly menu system and page structure
- **Professional Styling**: Clean, modern design appropriate for healthcare environments
- **Accessibility**: Structured forms and clear visual hierarchy

## 🔧 Key Technical Features

### **Security Implementation**
- **Password Encryption**: BCrypt hashing for secure password storage
- **Prepared Statements**: SQL injection prevention through parameterized queries
- **Session Management**: Secure user session handling and authentication
- **Role-Based Access**: Controlled access based on user roles (client/therapist/admin)

### **Advanced Functionality**
- **Search & Filter System**: Dynamic appointment filtering by multiple criteria
- **Message Threading**: Organized communication with timestamp tracking
- **Profile Customization**: Editable user profiles with role-specific fields
- **Data Validation**: Form validation and error handling throughout the application

## 📱 Supported Features

- **Multi-Role Dashboard**: Customized interfaces for different user types
- **Appointment Scheduling**: Complete booking system with service selection
- **Communication Portal**: Integrated messaging between clients and administration
- **User Management**: Comprehensive user registration and profile management
- **Search Functionality**: Advanced filtering and search capabilities

## 🤝 Contributing

We welcome contributions to enhance the Greenlife Wellness Center system! Please feel free to submit issues, feature requests, or pull requests.

## 📄 License

This project is available for educational and development purposes.

---

**Built with ❤️ for wellness center management and healthcare accessibility**
