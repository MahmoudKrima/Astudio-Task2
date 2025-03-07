# ASTUDIO Task

## Installation & Setup
### **1. Clone the repository**
```sh
git clone https://github.com/MahmoudKrima/Astudio-Task2.git
cd project-management-api
```

### **2. Install dependencies**
```sh
composer install
```

### **3. Configure the environment**
```sh
cp .env.example .env
```
- Set up your database connection in `.env` file.

### **4. Run database migrations & seeders**
```sh
php artisan migrate --seed
```

### **5. Generate application key**
```sh
php artisan key:generate
```


### **6. Start the server**
```sh
php artisan serve
```

### **6. Start the test**
```sh
php artisan test --filter=OrderServiceTest
```

---
