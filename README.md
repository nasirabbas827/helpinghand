# helpinghand  

A lightweight PHP web application that connects donors with charitable centers, allowing users to browse, donate, and track contributions while giving administrators full control over categories, centers, users, and donation records.

---  

## Overview  

**helpinghand** is a simple, open‑source donation platform built with PHP. It provides:

* A public‑facing site where visitors can explore charitable centers, view donation history, and make contributions.  
* An admin dashboard for managing categories, centers, users, and reviewing donation activity.  
* Basic contact‑support functionality and a responsive UI styled with CSS.

---  

## Features  

| Public Side | Admin Side |
|-------------|------------|
| Browse charitable centers by category | Add / edit / delete categories |
| View detailed center information | Add / edit / delete centers |
| Make one‑time donations (via `payment.php`) | Manage users and admin accounts |
| Review personal donation history (`donation_history.php`) | Review and reply to user reviews |
| Contact support (`contact_support.php`) | View and export donation logs |
| Responsive navigation (`navbar.php`) | Secure admin login (`admin_login.php`) |
| Simple CSS styling (`css/style.css`) | Logout and session handling (`logout.php`, `admin/logout.php`) |

---  

## Tech Stack  

| Layer | Technology |
|-------|------------|
| Backend | PHP 7.4+ |
| Database | MySQL (schema in `Database/helpinghand_db.sql`) |
| Front‑end | HTML5, CSS3 |
| Server | Apache / Nginx (compatible with any LAMP/LEMP stack) |
| Version control | Git (GitHub) |

---  

## Installation  

1. **Clone the repository**  

   ```bash
   git clone https://github.com/yourusername/helpinghand.git
   cd helpinghand
   ```

2. **Set up the database**  

   * Create a new MySQL database (e.g., `helpinghand`).  
   * Import the schema:  

     ```bash
     mysql -u your_mysql_user -p helpinghand < Database/helpinghand_db.sql
     ```

3. **Configure connection settings**  

   * Open `config.php` (root) and `admin/config.php`.  
   * Replace placeholder values with your own credentials:  

     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'helpinghand');
     define('DB_USER', 'YOUR_DB_USERNAME');
     define('DB_PASS', 'YOUR_DB_PASSWORD');
     ```

4. **Deploy**  

   * Place the project folder inside your web server’s document root (e.g., `htdocs` for XAMPP).  
   * Ensure the `admin/uploads/` directory is writable (`chmod 755` or `chmod 775` on Linux).  

5. **Optional – Composer**  

   The project does not require external PHP packages, but if you add any later, run:  

   ```bash
   composer install
   ```

---  

## Usage  

### Public site  

* Navigate to `http://localhost/helpinghand/` (or your domain).  
* Browse centers, view categories, and click **Donate** to open the payment form (`payment.php`).  
* After a successful donation, the transaction appears in `donation_history.php`.  

### Admin dashboard  

1. Open `http://localhost/helpinghand/admin/admin_login.php`.  
2. Log in with the admin credentials you created during the initial setup (or the default admin defined in the SQL seed).  
3. Use the navigation bar (`admin/admin_navbar.php`) to:  

   * **Add / Edit Categories** – `