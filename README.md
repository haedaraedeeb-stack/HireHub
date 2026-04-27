# 💼 HireHub — Freelance Marketplace API

> منصة عمل حر عربية مبنية بـ Laravel — تربط أصحاب المشاريع بالمستقلين بشكل آمن ومنظم.

---

## 🛠 Tech Stack

| التقنية | التفاصيل |
|---|---|
| Framework | Laravel 13.x |
| Language | PHP 8.5+ |
| Database | MySQL / MariaDB |
| Authentication | Laravel Sanctum (Token-based) |
| Architecture | Service Pattern + API Resources + Form Requests |

---

## 🚀 تثبيت المشروع محلياً

```bash
# 1. استنساخ المشروع
git clone https://github.com/haedaraedeeb-stack/HireHub
cd HireHub

# 2. تثبيت الاعتماديات
composer install

# 3. إعداد البيئة
cp .env.example .env
php artisan key:generate

# 4. إعداد قاعدة البيانات في .env
DB_DATABASE=hirehub_db
DB_USERNAME=root
DB_PASSWORD=

# 5. تشغيل الـ Migrations والـ Seeders
php artisan migrate --seed

# 6. إنشاء رابط التخزين
php artisan storage:link

# 7. تشغيل الـ Server
php artisan serve

```

---

## 📬 توثيق الـ API

مجموعة Insomnia جاهزة للاستخدام:

1. حمّل الملف: [`api-docs/HireHub_API.yaml`](./api-docs/HireHub_API.yaml)
2. افتح Insomnia → **Create** → **Import** → اختر الملف

---

## 🌐 API Endpoints

### Auth
| Method | Endpoint | الوصف |
|---|---|---|
| POST | `/api/register` | تسجيل مستخدم جديد |
| POST | `/api/login` | تسجيل الدخول |
| POST | `/api/logout` | تسجيل الخروج |
| POST | `/api/email/verify` | تفعيل الحساب بالـ OTP |
| POST | `/api/email/resend` | إعادة إرسال كود التفعيل |

### Projects
| Method | Endpoint | الوصف |
|---|---|---|
| GET | `/api/projects` | قائمة المشاريع المفتوحة |
| POST | `/api/projects` | إنشاء مشروع جديد |
| GET | `/api/projects/{id}` | تفاصيل مشروع |
| PUT | `/api/projects/{id}` | تعديل مشروع |
| DELETE | `/api/projects/{id}` | حذف مشروع |
| POST | `/api/projects/{id}/review` | إضافة review للمشروع |
| POST | `/api/projects/{id}/review-freelancer` | إضافة review للفريلانسر |

### Freelancers
| Method | Endpoint | الوصف |
|---|---|---|
| GET | `/api/freelancers` | قائمة المستقلين المتاحين |
| GET | `/api/freelancers/{id}` | تفاصيل مستقل |
| POST | `/api/freelancers/profile` | إنشاء profile |
| PUT | `/api/freelancers/profile` | تعديل profile |

### Offers
| Method | Endpoint | الوصف |
|---|---|---|
| POST | `/api/offers` | تقديم عرض |
| GET | `/api/offers/{id}` | تفاصيل عرض |
| PATCH | `/api/offers/{id}/status` | تغيير حالة العرض |

### Stats (Admin only)
| Method | Endpoint | الوصف |
|---|---|---|
| GET | `/api/stats` | إحصائيات المنصة |

---

## 📂 هيكل المشروع

```
app/
├── Http/
│   ├── Controllers/     ← استقبال الـ requests فقط
│   ├── Services/        ← كل الـ business logic
│   ├── Requests/        ← validation وauthorization
│   ├── Resources/       ← تنسيق الـ JSON responses
│   └── Middleware/      ← حماية الـ routes
├── Models/              ← Eloquent models + relations
└── Notifications/       ← Email notifications
```

---

## 🏗 القرارات المعمارية

### 1. Service Pattern
فصل الـ business logic عن الـ Controller — كل Controller يفوّض للـ Service المختص. هاد يجعل الكود قابلاً للاختبار والتوسعة.

### 2. Polymorphic Relations
استُخدمت للـ Attachments (مشاريع وعروض) — بدل جدولين منفصلين، جدول واحد يخدم الاثنين.

### 3. Global Scopes
- `Project` → يعرض `open` فقط افتراضياً
- `Freelancer` → يعرض `verified + available` فقط افتراضياً

### 4. Email Verification (OTP)
بدل الـ Laravel built-in (رابط)، استُخدم OTP مخصص أنسب للـ Mobile API.

---

## ⚡ Phase 3: الأداء — N+1 Problem

### المشكلة
بدون Eager Loading، كل مشروع يحتاج query منفصلة:

| عدد المشاريع | عدد الـ Queries |
|---|---|
| 5 | 6 |
| 50 | 51 |
| 100 | 101 |

### الإثبات
```php
// تفعيل الحماية في AppServiceProvider
Model::preventLazyLoading(!app()->isProduction());

// محاولة Lazy Loading → Exception فوري
Project::limit(5)->get()->each(fn($p) => $p->user->name);
// LazyLoadingViolationException: Attempted to lazy load [user]
```

### الحل
```php
// Eager Loading → 2 queries ثابتة
Project::with('user')->limit(5)->get();
count(DB::getQueryLog()); // = 2 ✅
```

### النتيجة
```
قبل: 51 query لـ 50 مشروع
بعد: 2 queries ثابتة بغض النظر عن العدد
التحسن: 96%
```

### أدوات إضافية
- `withCount()` بدل تحميل العلاقة كاملة لعدّها

---

## 🔐 الأمان

- كلمات المرور مشفرة دائماً بـ Mutator — بغض النظر عمن كتب الكود
- `is_verified` — الفريلانسر لا يتفاعل بالمنصة قبل التفعيل
- Form Requests — الـ authorization والـ validation معزولان عن الـ Controller
- Sanctum Tokens — كل طلب يحتاج Bearer token

---

## 🌍 Environment Variables المهمة

```env
# Database
DB_CONNECTION=mysql
DB_DATABASE=hirehub_db

# Mail (Mailtrap للتطوير)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@hirehub.com

```
---

## 👨‍💻 المطور

**Haedara deeb**
> Built with ❤️ for the HireHub challenge
