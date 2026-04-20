# 🚀 HireHub - Freelance Marketplace API

**HireHub** is a comprehensive backend system built with **Laravel 13**, designed to connect project owners with freelancers in a secure and organized environment. This project emphasizes software engineering best practices, including **SOLID principles** and the **Service-Repository Pattern**.

---

## 🛠 Tech Stack

* **Framework:** Laravel 13.x
* **Language:** PHP 8.5+
* **Database:** MySQL / MariaDB
* **Authentication:** Laravel Sanctum (Token-based)
* **Architectural Patterns:** Service-Repository Pattern, API Resources, Form Requests.

---

## 🚀 توثيق الـ API (Insomnia)

لقد قمنا بتجهيز مجموعة كاملة من الطلبات (Requests) لتسهيل تجربة واختبار النظام.

### كيفية الاستخدام:
1. قم بتحميل ملف التوثيق من الرابط: [Insomnia_2026-04-20.yaml](./api-docs/Insomnia_2026-04-20.yaml)
2. افتح برنامج **Insomnia**.
3. اضغط على **Create** ثم اختر **Import**.
4. اختر **File** وقم بتحديد الملف الذي قمت بتحميله.


## ✨ Core Features

- **User Authentication:** Support for multiple user roles (Freelancer & Client) with secure token management.
- **Profile Management:** Detailed freelancer profiles including bio, hourly rates, and skill sets.
- **Project Management:** Capability to post projects, define budgets (Fixed/Hourly), and set deadlines.
- **Location & Skill Filtering:** Seamless integration of city-based and skill-based filtering for localized services.
- **Data Integrity:** Strict validation rules and database constraints to ensure high-quality data entry.

---

## 🚀 Local Installation

Follow these steps to get the project up and running on your local machine:

1. **Clone the Repository:**
   ```bash
   git clone [https://github.com/haedaraedeeb-stack/HireHub](https://github.com/haedaraedeeb-stack/HireHub)

   cd HireHub

2. Install Dependencies:
composer install

3.Environment Setup:
Copy the example environment file and configure your database credentials.

cp .env.example .env

4. Generate Application Key:
php artisan key:generate

5.Run Migrations & Seeders:
(Crucial for populating cities and default skills)

php artisan migrate --seed

6. Start the Server:
php artisan serve

📂 Architecture & Folder Structure
This project follows a Clean Architecture approach to ensure scalability and maintainability:

. Services: Contains the core business logic.

. API Resources: Ensures consistent and professional JSON responses.

. Form Requests: Handles complex validation logic outside of the Controllers.

(Phase 3: Performance Optimization)
تم اكتشاف مشكلة N+1 Queries في مسارات جلب القوائم (مثل قائمة المشاريع). النظام كان يقوم بتنفيذ استعلام منفصل لكل علاقة تابعة، مما يؤدي لبطء شديد مع زيادة البيانات.
Solutions Implemented
1- منع التحميل الكسول (Prevent Lazy Loading): تم تفعيل خاصية حماية النظام في بيئة التطوير لمنع أي استعلام N+1 مستقبلاً.
2- لتحميل المسبق (Eager Loading): تم استخدام دالة with() لجلب العلاقات (مثل user) في استعلامين فقط بدلاً من 51 استعلاماً.
3- استخدام withCount: بدلاً من تحميل العلاقات كاملة لعدّها، تم استخدام withCount لجلب الأعداد مباشرة من قاعدة البيانات بأقل استهلاك للذاكرة

EXAMPLE:
with : lazy loading
> Project::limit(5)->get()->map(fn($p) => dump($p->user->name))
Response
>Illuminate\Database\LazyLoadingViolationException  Attempted to lazy load [user] on model [App\Models\Project] but lazy loading is disabled

with : eager loading 
>> Project::with("user")->limit(5)->get()->map(fn($p) => dump($p->user->name))
Response
>"Omar Salem" // vendor\psy\psysh\src\ExecutionLoopClosure.php(55) : eval()'d code:1
"Laila Hassan" // vendor\psy\psysh\src\ExecutionLoopClosure.php(55) : eval()'d code:1
"Robert Fox" // vendor\psy\psysh\src\ExecutionLoopClosure.php(55) : eval()'d code:1
"Robert Fox" // vendor\psy\psysh\src\ExecutionLoopClosure.php(55) : eval()'d code:1
"Elena Rossi" // vendor\psy\psysh\src\ExecutionLoopClosure.php(55) : eval()'d code:1
= Illuminate\Support\Collection {#8436
    all: [
      "Omar Salem",
      "Laila Hassan",
      "Robert Fox",
      "Robert Fox",
      "Elena Rossi",
    ],
  }

>
