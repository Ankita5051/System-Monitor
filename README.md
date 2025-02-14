# System-heath-monitoring
>>>>>>> 5a2604ff894859b02825cb0672d1f4a095636fac
# System Health Monitoring & Alerting Tool

## Overview
This tool monitors system health by tracking **CPU usage, memory usage, and disk usage**. It provides API endpoints to fetch system metrics, assign metadata, and trigger alerts when thresholds are exceeded.

## Features
- **Real-time System Metrics**: CPU, Memory, Disk Usage
- **Metadata Assignment**: Store server details
- **Alerts**: Trigger alerts for high CPU usage (>80%) and low disk space (<10%)
- **Historical Data**: Store all metrics in a database
- **RESTful API**: Expose API endpoints for metrics, alerts, and metadata

---
## Prerequisites
Ensure you have the following installed:
- PHP 8.x
- Laravel 10.x
- MySQL
- Composer
- Postman (for API testing, optional)

---
## Installation

### 1. Clone the Repository
```sh
git clone https://github.com/Ankita5051/System-heath-monitoring.git
cd System-heath-monitoring
```

### 2. Install Dependencies
```sh
composer install
```

### 3. Configure Environment Variables
Copy the `.env.example` file and set up your database connection.
```sh
cp .env.example .env
```
Edit the `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 4. Run Migrations
```sh
php artisan migrate
```

### 5. Start the Laravel Server
```sh
php artisan serve
```

---
## API Endpoints

### **1. Fetch System Metrics**
```http
GET /api/metrics
```
**Response:**
```json
{
    "cpu": "45.3%",
    "memory": "1024MB",
    "disk": "75% Used",
    "timestamp": "2025-02-14 12:00:00"
}
```

### **2. Fetch Historical Metrics**
```http
GET /api/metrics/history
```
**Response:**
```json
[
  {"cpu": "45.3%", "memory": "1024MB", "disk": "75%", "timestamp": "2025-02-14 12:00:00"},
  {"cpu": "50.1%", "memory": "1050MB", "disk": "70%", "timestamp": "2025-02-14 12:05:00"}
]
```

### **3. Set Metadata**
```http
POST /api/metadata
```
**Request Body:**
```json
{
    "server_name": "Server-1",
    "environment": "Production",
    "location": "Data Center 1"
}
```
**Response:**
```json
{
    "message": "Metadata saved",
    "data": { "id": 1, "server_name": "Server-1", "environment": "Production", "location": "Data Center 1" }
}
```

### **4. Fetch Alerts**
```http
GET /api/alerts
```
**Response:**
```json
[
  {"metric": "CPU", "value": "85.2%", "threshold": "80%", "status": "active", "timestamp": "2025-02-14 12:10:00"}
]
```

---
## Running Tests
Run unit tests using:
```sh
php artisan test
```

---
## Deployment
For cloud deployment, use **Railway, Render, or AWS**.
```sh
git add .
git commit -m "Initial commit"
git push origin main
```

---
## Troubleshooting
### 1. **Migrations Fail?**
Run:
```sh
php artisan migrate:fresh --seed
```

### 2. **Error: Permission Denied on Storage?**
Run:
```sh
chmod -R 775 storage bootstrap/cache
```

### 3. **API Returns 404?**
Check routes:
```sh
php artisan route:list
```

---
## Credits
Developed by **Ankita5051**

If you found this project helpful, give it a ⭐ on GitHub!

---

