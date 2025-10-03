# Omacha Shop - E-commerce Toy Store

<p align="center">
  <img src="screenshot/logo.png" alt="Omacha Shop Logo" height="50px"/> <!-- Đảm bảo đường dẫn logo chính xác -->
</p>

Welcome to Omacha Shop, a delightful e-commerce platform dedicated to bringing joy and quality toys to children and families. This project showcases a full-stack web application built with PHP, designed for use with XAMPP, and features a comprehensive set of functionalities for both customers and administrators.
This README is available in English and Vietnamese. Please expand the section for your preferred language.

**Project Link:** [https://https://github.com/AndreiOchangco/Omacha-Shop_E-Commerce_Website](https://https://github.com/AndreiOchangco/Omacha-Shop_E-Commerce_Website)

---

<details>
<summary><strong>English Version (Click to Expand)</strong></summary>

## 🌟 Project Overview

Omacha Shop is designed to provide a seamless and enjoyable online shopping experience for toy enthusiasts. From browsing a diverse collection of toys to secure (simulated) payment and order tracking, Omacha aims to be a trusted destination for parents and children alike. The platform also includes a robust administration system for efficient business management.

**Live Demo (GitHub Pages - Frontend UI Only):**
*   Customer View: [https://tranhuudat2004.github.io/Omacha-Shop-Demo/](https://tranhuudat2004.github.io/Omacha-Shop-Demo/)
*   Admin View (UI Only): [https://tranhuudat2004.github.io/Omacha-Shop-Demo/Admin/public/index.html](https://tranhuudat2004.github.io/Omacha-Shop-Demo/Admin/public/index.html)
*(Note: The live demos are frontend-only and do not include backend functionality like database interactions, user authentication, or order processing. For full functionality, please set up the project locally as described below.)*

## ✨ Key Features

### For Customers:
*   **Intuitive Product Browsing:** Homepage, categories, age-based filtering, advanced search.
*   **Detailed Product Pages:** Multiple screenshots, descriptions, reviews.
*   **Shopping Cart & Wishlist:** Add to cart, cart preview, quantity updates, coupon application, save favorites.
*   **Secure Checkout Process:** Clear steps, shipping info, order summary, "Thank You" page, invoice generation (PDF option).
*   **User Accounts:** Registration, login, (potentially) order history.
*   **Engagement & Information:** Blog, About Us, Contact page, product reviews, comment system.

### 🛍️ Customer Interface (Screenshots)
|           Home Page (Layout 1)            |             Product Listing (with Filter)              |                    Product Detail Page                    |
| :---------------------------------------: | :----------------------------------------------------: | :-------------------------------------------------------: |
|  ![Omacha Home 1](screenshot/Home1.jpg)   | ![Omacha Product List & Filter](screenshot/filter.jpg) |  ![Omacha Product Detail](screenshot/product_detail.jpg)  |
|             **Shopping Cart**             |                  **Checkout Process**                  |                    **Thank You Page**                     |
|    ![Omacha Cart](screenshot/cart.jpg)    |      ![Omacha Checkout](screenshot/checkout.jpg)       |       ![Omacha Thank You](screenshot/thankyou.jpg)        |
|              **Login Page**               |                 **Registration Page**                  |                     **Wishlist Page**                     |
|   ![Omacha Login](screenshot/login.jpg)   |      ![Omacha Register](screenshot/signup.jpg)       |        ![Omacha Wishlist](screenshot/wishlist.jpg)        |
|               **Blog Page**               |                   **About Us Page**                    |                     **Contact Page**                      |
|    ![Omacha Blog](screenshot/blog.jpg)    |       ![Omacha About Us](screenshot/about5.jpg)        |         ![Omacha Contact](screenshot/contact.jpg)         |
|        **Order Detail**         |                   **Search Results**                   |          **Comment Section** (e.g., on Product)           |
| ![Omacha Invoice](screenshot/checkout1.jpg) |    ![Omacha Search Results](screenshot/search.jpg)     | ![Omacha Comment Section](screenshot/comment_product.jpg) |
|     **Home Page (Layout 2)**     |           **Home Page (Layout 3)**            |             **Home Page (Layout 4)**             |
|  ![Omacha Home 2](screenshot/Home2.jpg)   |         ![Omacha Home 3](screenshot/Home3.jpg)         |          ![Omacha Home 4](screenshot/Home4.jpg)           |
|     **Home Page (Layout 5)**     |      **Invoice**                                                   |                                                           |
|  ![Omacha Home 5](screenshot/Home5.jpg)   |           ![Invoice](screenshot/invoice.jpg)                                             |                                                           |

### For Administrators (Admin Dashboard):
*   **Dashboard Overview:** Statistics on orders, users, sales, comments.
*   **User Management:** View and manage users.
*   **Product Management:** Add, view, edit, delete products.
*   **Order Management:** View and manage customer orders.
*   **Comment Management:** Approve, reply to comments.
*   **Content Management:** Manage blog posts, categories.
*   **Statistical Reports:** Charts for best sellers, revenue.

### ⚙️ Admin Interface (Screenshots)
|                     Admin Login Page                     |               Admin Signup Page (if applicable)                |                      Admin Dashboard                       |
| :------------------------------------------------------: | :------------------------------------------------------------: | :--------------------------------------------------------: |
|    ![Omacha Admin Login](screenshot/login_admin.jpg)     |      ![Omacha Admin Signup](screenshot/create_admin.jpg)       |      ![Omacha Admin Dashboard](screenshot/admin1.jpg)      |
|                   **Add Product Form**                   |                   **Manage Products (List)**                   |                  **Manage Orders (List)**                  |
| ![Omacha Admin Add Product](screenshot/add_product.jpg)  | ![Omacha Admin Manage Products](screenshot/manage_product.jpg) | ![Omacha Admin Manage Orders](screenshot/manage_order.jpg) |
|                 **Manage Users (List)**                  |                                                                |                                                            |
| ![Omacha Admin Manage Users](screenshot/manage_user.jpg) |                                                                |                                                            |

## 🛠️ Technology Stack

*   **Frontend:** HTML5, CSS3, JavaScript, Bootstrap, Tailwind CSS (for Admin)
*   **Backend:** PHP (Procedural or with a custom structure)
*   **Database:** MySQL (Managed via phpMyAdmin in XAMPP)
*   **Web Server:** Apache (via XAMPP)

## 🚀 Getting Started

### Prerequisites

*   **XAMPP:** Installed and running (Apache, PHP, MySQL).
*   **Git:** For cloning.

### Installation & Setup

1.  **Start XAMPP:** Ensure Apache and MySQL services are running.
2.  **Clone Repository into `htdocs`:**
    *   Navigate to your XAMPP `htdocs` directory.
    *   Run: `git clone https://github.com/TranHuuDat2004/Omacha_Shop.git`
    *   `cd OmachaShop`

3.  **Database Setup:**
    *   Go to `http://localhost/phpmyadmin`.
    *   Create a new database named `toy-shop` (collation `utf8mb4_general_ci`).
    *   Select `toy-shop`, go to "Import", choose `OmachaShop/Frontend/toy-shop.sql` (or the correct path to your SQL file), and click "Go".

4.  **Configure Database Connection (if necessary):**
    *   Check your PHP database connection files.
    *   Default XAMPP credentials: Host: `localhost`, User: `root`, Password: `(empty)`, DB: `toy-shop`.

5.  **Accessing the Application:**
    *   **Customer Site:** `http://localhost/OmachaShop/` (or `http://localhost/OmachaShop/Frontend/`)
    *   **Admin Panel:** `http://localhost/OmachaShop/admin/` (or your specific admin path).
        *   *Default Admin Credentials (if any):* Username: `[admin_user]`, Password: `[admin_pass]` (Please update)

## 📝 License

This work is licensed under a [Creative Commons Attribution-NonCommercial 4.0 International License](https://creativecommons.org/licenses/by-nc/4.0/).
You are free to Share and Adapt the material, under the terms of Attribution and NonCommercial use.
[![License: CC BY-NC 4.0](https://licensebuttons.net/l/by-nc/4.0/88x31.png)](https://creativecommons.org/licenses/by-nc/4.0/)

## 👤 Contributors

*   **Team Engineering**
    *   **Nguyễn Thùy Khanh** - Team Leader | Project Visionary & Lead Ideator
    *   **Trần Hữu Đạt** - Full-Stack Web Developer - [@TranHuuDat2004](https://github.com/TranHuuDat2004)
    *   **Trần Bình Quyển** - Member
    *   **Dương Thị Thùy Linh** - Member

</details>
