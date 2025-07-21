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



## 📁 Project Token & Folder Structure

When a new documentation project is created, the system automatically generates a **unique 12-character `token`**. This token is used to create a secure folder where the Docusaurus build is stored. You can find the token after creating the project, click on "View" on your project, and token will be displayed.

#### 📌 Folder Path Format:

```
public/token/{token}/
```

For example, if the generated token is `a1b2c3d4e5f6`, the Docusaurus build will be placed under:

```
public/token/a1b2c3d4e5f6/
```

#### ✅ Purpose:

* Ensures a **unique and isolated** folder for each documentation project.
* Avoids folder name collisions and supports multi-project deployments.
* Allows Laravel to serve project-specific documentation dynamically via route-based access control.

#### 🔐 Access Control:

* Each token-based folder is protected by Laravel’s authentication system.
* Users must be authenticated to access the documentation at:



## 🤝 Collaborate With Us

We welcome developers, contributors, and teams to collaborate on enhancing this secure documentation system. Whether you want to extend features, integrate custom authentication layers, or build multi-tenant support — your ideas are valuable!

### 💡 Need Customization?

If you'd like to customize this solution for your organization or workflow, feel free to reach out at:

📧 **[info@innovination.com](mailto:info@innovination.com)**

---

## 🏢 Project by [Innovination](https://www.innovination.com)

This project is proudly developed and maintained by **Innovination**, a software agency building scalable, secure, and user-friendly digital solutions.