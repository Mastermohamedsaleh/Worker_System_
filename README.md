# 🛠️ Worker System - Professional Service Marketplace

A high-performance service marketplace platform built with **Laravel**, optimized for speed and scalability using **Redis**. This system connects users with skilled workers, featuring a robust rating engine and advanced data handling.

## 🚀 Tech Stack

* **Backend:** PHP  | Laravel 
* **Database:** MySQL (Primary Storage)
* **In-Memory Store:** Redis (Caching, Queuing)
* **Frontend:** Livewire / Tailwind CSS
* **Security:**  JWT Authentication

## 🌟 Key Technical Implementations

### 1. High-Performance Caching Layer (Redis) ⚡
* Implemented **Redis Caching** for "Top Rated Workers" and "Global Service Lists," reducing database query load by over **60%**.
* Applied **Cache Invalidation** strategies (Cache Busting) to ensure data consistency as soon as worker ratings are updated.

### 2. Scalable Asynchronous Queuing (Laravel Jobs) ⚙️
* Engineered a **Redis-buffered View Counter**: Profile views are temporarily stored in Redis and periodically persisted to MySQL via **Laravel Queue Workers** to prevent write-bottlenecks during peak traffic.
* Offloaded non-critical tasks to background workers to ensure a seamless UI/UX.

### 3. Advanced Worker Analytics
* Dynamic rating algorithms calculating average worker scores.
* Real-time notifications for bookings and reviews.

## ⚙️ Installation & Setup

1.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/Mastermohamedsaleh/Worker_System_.git](https://github.com/Mastermohamedsaleh/Worker_System_.git)
    cd Worker_System_
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    npm install && npm run dev
    ```

3.  **Environment Configuration:**
    * Copy `.env.example` to `.env`.
    * Configure your Database and Redis credentials:
    ```env
    CACHE_DRIVER=redis
    QUEUE_CONNECTION=redis
    ```

4.  **Database Migration:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Run Background Workers:** (Crucial for View Counting)
    ```bash
    php artisan queue:work
    ```

---
**Developed by [Mohamed Saleh]** *Laravel Backend Developer | Specialized in Performance Optimization & Scalable Systems*
