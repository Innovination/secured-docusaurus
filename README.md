# 📚 Secure Internal Documentation Portal (Laravel + Docusaurus)

This project provides a **secure, authenticated documentation system** by combining the power of **Docusaurus** (for beautiful static documentation) with **Laravel** (for user authentication and secure access control).

## 🔒 Why This Project?

By default, Docusaurus serves documentation **publicly**, which is **not ideal for internal or private documentation**. This solution restricts access to the documentation portal using Laravel's authentication system, ensuring only logged-in users can view the content.

## ⚙️ How It Works

- 📘 **Docusaurus** is used to author and build the documentation.
- 🔐 **Laravel** manages user login and access control.
- 🚫 **Docusaurus is not directly exposed** to the public.
- ✅ Instead, the **Docusaurus static build is hosted in a secure location** (e.g., local `public/docs`, protected S3 bucket, etc.).
- 🔄 Laravel checks if the user is authenticated and then **loads the Docusaurus build in an `iframe`** for valid users only.

---

## 🛠️ Tech Stack

- [Laravel](https://laravel.com) – backend framework with auth & route protection
- [Docusaurus](https://docusaurus.io) – documentation static site generator

---

## 🚀 Getting Started

### 1. Clone the Repository
```bash
git clone https://github.com/your-org/secure-docs-portal.git
cd secure-docs-portal
```

### 2. Install Dependencies
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```