# 📚 Online School Library - E-Book Borrowing System

## 📝 Project Overview
This is a Web Programming project (SPMS - Version 1) built with **Vanilla PHP, MySQL, HTML, CSS, and JavaScript**. It allows students to borrow e-books, log their reading progress, and allows admins to manage the e-book catalog.

## 🚀 Features
- **Authentication**: User registration, login, and logout with password hashing & CSRF protection.
- **Admin Panel**: CRUD operations for E-Books (Create, Read, Update, Delete).
- **Borrowing System**: Students can borrow and return books.
- **Reading Logs**: Students can log the number of pages they have read.
- **Async Live Search**: Real-time search using Fetch API and JSON (No page reload).
- **Security**: Prepared statements (PDO), `htmlspecialchars()` for XSS prevention, CSRF tokens.

## 📸 Screenshots 

### 1. Landing Page (Home)
*Description: Displays the featured e-books available in the library.*
<img width="1581" height="815" alt="Screenshot 2026-11-20 145724" src="https://github.com/user-attachments/assets/423faff4-5b51-4d59-8efd-e792a167b677" />


### 2. Login Page
*Description: Secure login page with CSRF protection.*
<img width="1915" height="913" alt="Screenshot 2026-11-20 152900" src="https://github.com/user-attachments/assets/eecb920a-f04a-4e6d-8985-ecfc93ad4c9b" />


### 3. Student Dashboard
*Description: Shows borrowed books, reading logs, and days remaining.*
<img width="1908" height="795" alt="Screenshot 2026-11-21 120516" src="https://github.com/user-attachments/assets/bccfd29e-9d79-4627-9e87-c6276236cfba" />


### 4. Admin Panel (Manage Books)
*Description: Admin can add, edit, and delete e-books from the catalog.*
<img width="1913" height="915" alt="Screenshot 2026-11-21 130315" src="https://github.com/user-attachments/assets/52eb2293-9f4c-42fe-b19a-39bcd71c0f9f" />

## 🛠️ Setup Instructions
1. **Requirements**: WAMP / XAMPP / MAMP (PHP 7.4+ and MySQL).
2. **Copy Project**: Move the `Online_School_Library` folder to `C:\wamp64\www\` (or `htdocs` for XAMPP).
3. **Database Setup**:
   - Open `http://localhost/phpmyadmin`
   - Create a new database named `online_library`.
   - Click on the **Import** tab, and import the `schema.sql` file.
   - Then import the `seed.sql` file to populate initial data.
4. **Configuration**: Open `db.php` and verify the username is `root` and password is empty (default for WAMP).
5. **Run**: Open `http://localhost/Online_School_Library/index.php` in your browser.

## 🔐 Default Credentials (Admin)
- **Username**: admin
- **Password**: password123

## 📂 Project Structure
- `index.php` - Landing Page (E-books fetched from database)
- `login.php` / `register.php` - Authentication
- `dashboard.php` - Student Dashboard (Borrowed books, Logs, Days Remaining)
- `admin_dashboard.php` - Admin Panel (Manage Books)
- `borrow.php` / `return_book.php` - Borrowing Logic
- `add_log.php` - Reading Logs Logic
- `api/search_books.php` - JSON API for Live Search

## 🧪 Testing (Test Evidence)
A full test plan is available in the `TEST_PLAN.md` file (≥ 10 test cases covering both happy and failure paths).

<img width="651" height="823" alt="Screenshot 2026-11-21 130712" src="https://github.com/user-attachments/assets/56d2d376-24ad-4af8-87aa-d1e13cad6214" />
<img width="1830" height="819" alt="Screenshot 2026-11-21 172706" src="https://github.com/user-attachments/assets/0334b5c9-c165-4bf4-bdd2-4ed9fc9b9641" />

<img width="1857" height="898" alt="Screenshot 2026-11-21 173848" src="https://github.com/user-attachments/assets/625292ee-25b1-4e45-a1bf-16098ff0a9db" />
<img width="1839" height="870" alt="Screenshot 2026-11-21 174445" src="https://github.com/user-attachments/assets/582ca1c3-5334-4fc5-b0cd-4b89335f4f97" />



## 👨‍💻 Author
- **Student Name**: SHUKURUMUNGU ERIC
- **Reg No**: 223016371
- **Course**: Web Programming - Year 3
- **Instructor**: Dr. BUGINGO Emmanuel
