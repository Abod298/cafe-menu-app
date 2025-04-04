# Laravel 12 Menu Generator for Restaurants and Cafes 🍽️

![License](https://img.shields.io/badge/license-MIT-blue) 
![Laravel](https://img.shields.io/badge/Laravel-12.x-orange) 
![PHP](https://img.shields.io/badge/PHP-8.x-purple)

A powerful and intuitive **Menu Generator** designed for restaurants and cafes. This web application allows administrators to create, manage, and customize menus with ease. Built with Laravel 12, it provides a seamless experience for managing menu items, images, and user permissions.

---

## ✨ Features

- **Admin-Only Access**: Exclusive access for administrators to create and manage menus.
- **Menu Creation**: Create comprehensive menus with items, products, and images.
- **User Permissions**: Robust access control to ensure users can only modify or delete their own items.
- **Role-Based Access Control (RBAC)**: Define user roles (e.g., Admin, User) to restrict access to specific actions.
- **Database Seeding**: Pre-configured roles, permissions, and users for quick setup.

---

## 🚀 Installation

Follow these steps to set up the project locally:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Abod298/cafe-menu-app.git
   cd cafe-menu-app
   ```
2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```
3. **Set up the .env file**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4. **Run migrations and seed the database:**:
- It is important to run the seed command during migration to set up the necessary roles, permissions, and essential users for the application:
    ```bash
    php artisan migrate --seed
    ```
- This will create:

Admin user: admin@admin.com (password: password)

Regular user: user@user.com (password: password)

Role-based permissions for users.

5. **Start the application:**:
    
    ```bash
    php artisan serve
    npm run dev
    --or
    composer run dev
    ```
## Screenshots

### Dashboard
![Dashboard](./public/screenshots/dashboard.png)

### A Product View
![Main Page](./public/screenshots/menu.png)

### Product List
![Main Page](./public/screenshots/products.png)
## Notes

The `Contact` controller has been left empty for beginners to practice and learn how to integrate it into the application flow.

## Contributing

Feel free to submit issues or pull requests. Please ensure that your contributions are well-documented and tested.

## License

This project is licensed under the MIT License.
