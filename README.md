# 🗓️ Leave Management System - CodeIgniter 4

A web-based Leave Management System built using CodeIgniter 4. It supports employee login, leave application with validation, dynamic country-state-city dropdowns, leave balance checks, and admin approvals.

---

## 🚀 Features
- Migration, seeder with factory data
- Login Authentication
- Leave Application with Date & Type Validation
- Leave Balance Deduction
- Non-working Days Exclusion
- Leave History & Status
- Country → State → City AJAX Selection
- Profile Update
- Admin Panel (optional)
- Flash Message Alerts
- jQuery Client-Side Validation

---

## ⚙️ Requirements

- PHP >= 7.4
- MySQL/MariaDB
- Composer
- Apache/Nginx

---

## ⚙️ Installation & Setup

1. **Clone the repo**

```bash
git clone https://github.com/milanshah1410/ci_metiz.git
cd ci_metiz
```

2. **Install dependencies**

```bash
composer install
```

3. **Copy `.env` file and configure**

```bash
cp env .env
php spark key:generate
```

Edit `.env` and set up:

```dotenv
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = your_db_name
database.default.username = your_username
database.default.password = your_password
database.default.DBDriver = MySQLi
```

4. **Run migrations & seeders**

```bash
php spark migrate
php spark db:seed DatabaseSeeder
```

5. **Run the server**

```bash
php spark serve
```

Visit: `http://localhost:8080`

**Default Employee Login:  **
Email : employee@metiz.com 
Password : 123456
---

## 🧪 Useful Spark Commands

| Command                         | Description                     |
| ------------------------------ | ------------------------------- |
| `php spark serve`              | Start local dev server          |
| `php spark migrate`            | Run all migrations              |
| `php spark migrate:rollback`   | Rollback last migration         |
| `php spark db:seed SeederName` | Run a specific seeder           |
| `php spark make:controller`    | Create new controller           |
| `php spark make:model`         | Create new model                |
| `php spark make:migration`     | Create a migration file         |
| `php spark routes`             | List all routes                 |

---

## 👤 Default Login (Seeded)

```text
Email: admin@example.com
Password: password
```

_You can change these in `UserSeeder.php`._

---

## 📁 Folder Structure

```bash
app/
├── Config/
├── Controllers/
├── Models/
├── Views/
├── Database/
│   ├── Migrations/
│   └── Seeds/
public/
writable/
```

---

## 📌 Notes

- CSRF protection is enabled by default.
- All forms use server-side and client-side validation.
- Flash messages show success/error feedback.
- Date fields use HTML5 `<input type="date">` for consistency.

---

## 📜 Author

Milan Shah — Free to use, modify and distribute.

