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
