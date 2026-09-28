# Pratham Admin (Laravel 12) - structure

Purani files delete karo (cmd, pratham-admin folder me):
    rmdir /s /q resources\views\admin
    del app\Http\Controllers\Admin\AuthController.php
    del app\Http\Middleware\IsAdmin.php
Phir is zip ki saari files copy karo (Replace), aur:
    php artisan migrate
    php artisan db:seed --class=AdminSeeder
    php artisan optimize:clear
    php artisan serve
Login: http://127.0.0.1:8000/admin/login  ->  admin@pratham.test / password123
