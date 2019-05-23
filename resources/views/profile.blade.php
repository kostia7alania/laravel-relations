<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MY PROFILLEEE!!!</title>
</head>
<body>
    @foreach ($posts as $post)
        <h2>{{ $post->title }}</h2>

        <h5>$posts[3]</h5>
    @endforeach

</body>
</html>
