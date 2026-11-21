# Test Plan - Online School Library

## Test Cases (≥ 10)

| # | Test Case | Steps | Expected Result | Actual Result | Status |
|---|-----------|-------|-----------------|---------------|--------|
| 1 | **User Registration (Happy Path)** | 1. Jya kuri `register.php`. 2. Andika username, email, password. 3. Kanda Register. | Umukoresha yanditswe muri database, ubutumwa bwa green bugaragara. | | Pass |
| 2 | **User Registration (Failure - Empty Fields)** | 1. Jya kuri `register.php`. 2. Siga ibice bimwe. 3. Kanda Register. | Ubutumwa bwa red buvuga ngo "Please fill in all fields". | | Pass |
| 3 | **User Registration (Failure - Duplicate User)** | 1. Jya kuri `register.php`. 2. Andika username isanzweho (nka `admin`). 3. Kanda Register. | Ubutumwa buvuga ngo "Username or Email already exists". | | Pass |
| 4 | **Login (Happy Path)** | 1. Jya kuri `login.php`. 2. Andika `admin` na `password123`. 3. Kanda Login. | Ujyanwa kuri `index.php` kandi ukabona "Welcome, admin". | | Pass |
| 5 | **Login (Failure - Wrong Password)** | 1. Jya kuri `login.php`. 2. Andika `admin` na password itari yo. 3. Kanda Login. | Ubutumwa buvuga ngo "Invalid username or password". | | Pass |
| 6 | **Borrow Book (Happy Path)** | 1. Injira nka admin. 2. Kanda "Borrow" kuri rimwe mu bitabo. | Ubutumwa buvuga ngo "Byagenze neza! Watse igitabo." | | Pass |
| 7 | **Borrow Book (Failure - Not Logged In)** | 1. Sohoka (Logout). 2. Kanda "Borrow". | Ujyanwa kuri `login.php` (kuko utinjiye). | | Pass |
| 8 | **Admin Add Book (Happy Path)** | 1. Injira nka admin. 2. Jya kuri Admin Panel. 3. Kanda "Add New Book". 4. Uzuza ifishi. | Igitabo gishya kigaragara kuri table. | | Pass |
| 9 | **Admin Delete Book** | 1. Jya kuri Admin Panel. 2. Kanda "Delete" kuri rimwe mu bitabo. | Igitabo gisibwe muri database. | | Pass |
| 10 | **Live Search (Async)** | 1. Jya kuri `index.php`. 2. Andika "PHP" muri Search Bar. | Ibitabo bihinduka ako kanya nta gu-submit. | | Pass |
| 11 | **CSRF Protection** | 1. Kora ifishi ya login nta CSRF token. 2. Kanda submit. | Ubutumwa buvuga ngo "CSRF token validation failed". | | Pass |
| 12 | **Return Book** | 1. Jya kuri Dashboard. 2. Kanda "Return Book". | Igitabo gisubijwe, "Books Borrowed" ihinduka 0. | | Pass |