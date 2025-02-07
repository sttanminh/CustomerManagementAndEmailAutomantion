<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Notifications</h2>
        <ul class="list-group">
            @foreach(auth()->user()->notifications as $notification)
                <li class="list-group-item">
                    <strong>{{ $notification->data['title'] }}</strong> <br>
                    {{ $notification->data['message'] }} <br>
                    <small>Received: {{ $notification->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
