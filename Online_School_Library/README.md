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

## 🛠️ Setup Instructions (Uko utangira)
1. **Requirements**: WAMP / XAMPP / MAMP (PHP 7.4+ na MySQL).
2. **Copy Project**: Koporora iyi folder `Online_School_Library` uyishyire muri `C:\wamp64\www\` (cyangwa `htdocs` kuri XAMPP).
3. **Database Setup**:
   - Fungura `http://localhost/phpmyadmin`
   - Kora database nshya yitwa `online_library`.
   - Kanda kuri tab ya **Import**, hanyuma ukure file `schema.sql` (iyi tuzayikora ubu).
   - Hanyuma ukure file `seed.sql` kugira ngo ubone amakuru y'ibanze.
4. **Configuration**: Fungura `db.php` urebe niba username ari `root` na password ari ubusa (muri WAMP ni ubusa).
5. **Run**: Fungura `http://localhost/Online_School_Library/index.php`

## 🔐 Default Credentials (Admin)
- **Username**: admin
- **Password**: password123

## 📂 Project Structure
- `index.php` - Landing Page (Ibitabo biva muri database)
- `login.php` / `register.php` - Authentication
- `dashboard.php` - Student Dashboard (Borrowed books, Logs, Days Remaining)
- `admin_dashboard.php` - Admin Panel (Manage Books)
- `borrow.php` / `return_book.php` - Borrowing Logic
- `add_log.php` - Reading Logs Logic
- `api/search_books.php` - JSON API for Live Search

## 🧪 Testing (Test Evidence)
A full test plan is available in the `TEST_PLAN.md` file (≥ 10 test cases covering both happy and failure paths).

## 👨‍💻 Author
- **Student Name**: SHUKURUMUNGU ERIC
- **Reg No**: 223016371
- **Course**: Web Programming - Year 3