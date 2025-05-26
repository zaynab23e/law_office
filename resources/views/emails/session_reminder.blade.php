<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تذكير بالجلسة</title>
</head>
<body>
    <h1>تذكير بالجلسة</h1>
    <p>مرحبًا {{ $session->case->customer->user->name }},</p>
    <p>لديك جلسة مجدولة غدًا بتاريخ {{ $session->date }}.</p>
    <p>مع أطيب التحيات،</p>
</body>
</html>
