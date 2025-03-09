
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleDetails(id) {
            document.getElementById(id).classList.toggle("hidden");
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- القوائم الفرعية -->
        <nav class="bg-blue-600 text-white p-4 flex justify-between">
            <h1 class="text-xl font-bold">لوحة التحكم</h1>
            <ul class="flex gap-4">
                <li><a href="#" class="hover:underline">إعدادات</a></li>
                <li><a href="#" class="hover:underline">حسابي</a></li>
            </ul>
        </nav>

        <div class="flex flex-1">
            <!-- القوائم الأساسية (الجانبية) -->
            <aside class="w-1/4 bg-white p-4 shadow-lg">
                <ul class="space-y-4">
                    <li><button onclick="toggleDetails('section1')" class="w-full text-left font-bold">التقارير</button></li>
                    <li><button onclick="toggleDetails('section2')" class="w-full text-left font-bold">الإحصائيات</button></li>
                    <li><button onclick="toggleDetails('section3')" class="w-full text-left font-bold">الإعدادات</button></li>
                </ul>
            </aside>

            <!-- المحتوى الرئيسي -->
            <main class="flex-1 p-6">
                <div id="section1" class="hidden bg-white p-4 rounded-lg shadow-lg">محتوى التقارير</div>
                <div id="section2" class="hidden bg-white p-4 rounded-lg shadow-lg">محتوى الإحصائيات</div>
                <div id="section3" class="hidden bg-white p-4 rounded-lg shadow-lg">محتوى الإعدادات</div>
            </main>
        </div>
    </div>
</body>
</html>
