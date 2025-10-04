# Omacha Shop | E-Commerce Website

<p align="center">
    <img src="./Fontend/images/omachalogo.jpg" alt="Omacha Shop Logo" height="50px"/> <!-- Siguraduhing tama ang landas ng logo -->
</p>

Welcome to Omacha Shop, a dynamic and inclusive e-commerce platform tailored to meet the needs of individuals across all age groups. This project exemplifies a full-stack web application developed using PHP and designed to run seamlessly with XAMPP. Omacha Shop offers a rich array of features, including intuitive product browsing, secure checkout processes, and user-friendly account management for customers. For administrators, the platform provides robust tools for managing products, orders, users, and content, ensuring efficient and effective business operations. Whether you're a casual shopper or a business owner, Omacha Shop is built to deliver a comprehensive and engaging online shopping experience.
</br>
</br>
This README is available in English and Tagalog. Please expand the section for your preferred language.



**Project Link:** [https://https://github.com/AndreiOchangco/Omacha-Shop_E-Commerce_Website](https://https://github.com/AndreiOchangco/Omacha-Shop_E-Commerce_Website)

---

<details>
<summary><strong>English Version (Click to Expand)</strong></summary>

## 🌟 Project Overview

Omacha Shop is designed to provide a seamless and enjoyable online shopping experience for individuals of all ages. Whether you're searching for toys, gifts, or collectibles, the platform offers a diverse and carefully curated collection to meet your needs. With features like intuitive browsing, detailed product descriptions, and secure (simulated) payment options, Omacha ensures a user-friendly experience for everyone. Additionally, the platform includes tools for order tracking and customer engagement, making it a trusted destination for families, hobbyists, and collectors. For businesses, the robust administration system streamlines operations, enabling efficient management of products, orders, and customer interactions.

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
    *   Run: `git clone https://github.com/AndreiOchangco/Omacha-Shop_E-Commerce_Website.git`
    *   `cd Omacha-Shop_E-Commerce_Website`

3.  **Database Setup:**
    *   Go to `http://localhost/phpmyadmin`.
    *   Create a new database named `toy-shop` (collation `utf8mb4_general_ci`).
    *   Select `toy-shop`, go to "Import", choose `Omacha-Shop_E-Commerce_Website/Fontend/toy-shop.sql` (or the correct path to your SQL file), and click "Go".

4.  **Configure Database Connection (if necessary):**
    *   Check your PHP database connection files.
    *   Default XAMPP credentials: Host: `localhost`, User: `root`, Password: `(empty)`, DB: `toy-shop`.

5.  **Accessing the Application:**
    *   **Customer Site:** `http://localhost/Omacha-Shop_E-Commerce_Website/` (or `http://localhost/Omacha-Shop_E-Commerce_Website/Fontend/`)
    *   **Admin Panel:** `http://localhost/Omacha-Shop_E-Commerce_Website/admin/` (or your specific admin path).
        *   *Default Admin Credentials (if any):* Username: `[admin_user]`, Password: `[admin_pass]` (Please update)

## 📝 License

This work is licensed under a [Creative Commons Attribution-NonCommercial 4.0 International License](https://creativecommons.org/licenses/by-nc/4.0/).
You are free to Share and Adapt the material, under the terms of Attribution and NonCommercial use.
[![License: CC BY-NC 4.0](https://licensebuttons.net/l/by-nc/4.0/88x31.png)](https://creativecommons.org/licenses/by-nc/4.0/)

## 👤 Contributors

*   **Team Engineering**
    *   **Andrei Luise Ochangco** - Repository Maintainer, Software Enginer, Project Manager, Organization Administrator, Sub-UI Designer, Sub-Programmer, Dependencies Checker, Database Administrator - [@AndreiOchangco](https://github.com/AndreiOchangco)
    *   **Louis Ricardo Servito** - Main UI Designer - [@Lone-collab](https://github.com/Lone-collab)
    *   **Mark Lester Rivera** - Team Leader
    *   **Ardy Aquino** - Member
    *   **Brent Alabag** - Member
    *   **Vince Alvendia** - Member
    *   **Mc Harley Disu** - Member

</details>

---

<details>
<summary><strong>Tagalog Version (I-click upang Palawakin)</strong></summary>

## 🌟 Project Overview

Ang Omacha Shop ay idinisenyo upang magbigay ng tuluy-tuloy at kasiya-siyang karanasan sa online shopping para sa mga indibidwal sa lahat ng edad. Naghahanap ka man ng mga laruan, regalo, o collectible, nag-aalok ang platform ng magkakaibang at maingat na na-curate na koleksyon para matugunan ang iyong mga pangangailangan. Sa mga feature tulad ng intuitive na pagba-browse, detalyadong paglalarawan ng produkto, at secure (simulate) na mga opsyon sa pagbabayad, tinitiyak ng Omacha ang isang user-friendly na karanasan para sa lahat. Bukod pa rito, ang platform ay may kasamang mga tool para sa pagsubaybay sa order at pakikipag-ugnayan sa customer, na ginagawa itong isang pinagkakatiwalaang destinasyon para sa mga pamilya, hobbyist, at collectors. Para sa mga negosyo, ang matatag na sistema ng administrasyon ay nag-streamline ng mga operasyon, na nagbibigay-daan sa mahusay na pamamahala ng mga produkto, mga order, at mga pakikipag-ugnayan ng customer.

**Live Demo (GitHub Pages - Frontend UI Only):**
*   Customer View: [https://tranhuudat2004.github.io/Omacha-Shop-Demo/](https://tranhuudat2004.github.io/Omacha-Shop-Demo/)
*   Admin View (UI Only): [https://tranhuudat2004.github.io/Omacha-Shop-Demo/Admin/public/index.html](https://tranhuudat2004.github.io/Omacha-Shop-Demo/Admin/public/index.html)
*(Note: Ang mga live na demo ay frontend-only at hindi kasama ang backend functionality tulad ng mga pakikipag-ugnayan sa database, pagpapatotoo ng user, o pagpoproseso ng order. Para sa buong functionality, mangyaring i-set up ang proyekto nang lokal gaya ng inilarawan sa ibaba.)*

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
*   **Dashboard Overview:** Mga istatistika sa mga order, user, benta, komento.
*   **User Management:** Tingnan at pamahalaan ang mga user.
*   **Product Management:** Magdagdag, tumingin, mag-edit, at magtanggal ng mga produkto.
*   **Order Management:** Tingnan at pamahalaan ang mga order ng customer.
*   **Comment Management:** Aprubahan, tumugon sa mga komento.
*   **Content Management:** Pamahalaan ang mga post sa blog, mga kategorya.
*   **Statistical Reports:** Mga tsart para sa pinakamabenta, kita.

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

1.  **Start XAMPP:** Tiyaking tumatakbo ang mga serbisyo ng Apache at MySQL.
2.  **Clone Repository into `htdocs`:**
    *   Mag-navigate sa iyong XAMPP `htdocs` na direktoryo.
    *   Run: `git clone https://github.com/AndreiOchangco/Omacha-Shop_E-Commerce_Website.git`
    *   `cd Omacha-Shop_E-Commerce_Website`

3.  **Database Setup:**
    *   Pumunta sa `http://localhost/phpmyadmin`.
    *   Gumawa ng bagong database na pinangalanang `toy-shop` (collation `utf8mb4_general_ci`).
    *   Piliin ang `toy-shop`, pumunta sa "Import", piliin ang `Omacha-Shop_E-Commerce_Website/Fontend/toy-shop.sql` (o ang tamang path sa iyong SQL file), at i-click ang "Go".

4.  **Configure Database Connection (if necessary):**
    *   Suriin ang iyong mga file ng koneksyon sa database ng PHP.
    *   Default na mga kredensyal ng XAMPP: Host: `localhost`, User: `root`, Password: `(empty)`, DB: `toy-shop`.

5.  **Accessing the Application:**
    *   **Customer Site:** `http://localhost/Omacha-Shop_E-Commerce_Website/` (or `http://localhost/Omacha-Shop_E-Commerce_Website/Fontend/`)
    *   **Admin Panel:** `http://localhost/Omacha-Shop_E-Commerce_Website/admin/` (or your specific admin path).
        *   *Default Admin Credentials (if any):* Username: `[admin_user]`, Password: `[admin_pass]` (Please update)

## 📝 License

Ang gawaing ito ay lisensyado sa ilalim ng [Creative Commons Attribution-NonCommercial 4.0 International License](https://creativecommons.org/licenses/by-nc/4.0/).
Malaya kang Ibahagi at Iangkop ang materyal, sa ilalim ng mga tuntunin ng Attribution at NonCommercial na paggamit.
[![Lisensya: CC BY-NC 4.0](https://licensebuttons.net/l/by-nc/4.0/88x31.png)](https://creativecommons.org/licenses/by-nc/4.0/)

## 👤 Contributors

*   **Team Engineering**
    *   **Andrei Luise Ochangco** - Repository Maintainer, Software Enginer, Project Manager, Organization Administrator, Sub-UI Designer, Sub-Programmer, Dependencies Checker, Database Administrator - [@AndreiOchangco](https://github.com/AndreiOchangco)
    *   **Louis Ricardo Servito** - Main UI Designer - [@Lone-collab](https://github.com/Lone-collab)
    *   **Mark Lester Rivera** - Team Leader
    *   **Ardy Aquino** - Member
    *   **Brent Alabag** - Member
    *   **Vince Alvendia** - Member
    *   **Mc Harley Disu** - Member

</details>