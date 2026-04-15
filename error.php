<?php
$availableErrors = [
    400 => ['title' => 'Bad Request', 'message' => 'The request could not be understood by the server due to malformed syntax.'],
    401 => ['title' => 'Unauthorized', 'message' => 'You must be logged in to access this resource. Please sign in and try again.'],
    403 => ['title' => 'Forbidden', 'message' => 'You do not have permission to access this page or resource.'],
    404 => ['title' => 'Not Found', 'message' => 'The page you are looking for may have been moved or does not exist.'],
    405 => ['title' => 'Method Not Allowed', 'message' => 'The request method is not supported for the requested resource.'],
    408 => ['title' => 'Request Timeout', 'message' => 'The server timed out waiting for the request. Please try again.'],
    409 => ['title' => 'Conflict', 'message' => 'There is a conflict with the current state of the resource.'],
    410 => ['title' => 'Gone', 'message' => 'The resource you are trying to access is no longer available.'],
    429 => ['title' => 'Too Many Requests', 'message' => 'You have sent too many requests in a short time. Please wait and try again.'],
];

$code = isset($_GET['code']) ? (int) $_GET['code'] : 500;
if (!array_key_exists($code, $availableErrors)) {
    $code = 500;
    $availableErrors[500] = ['title' => 'Server Error', 'message' => 'An unexpected error occurred. Please try again later.'];
}

http_response_code($code);
$title = $availableErrors[$code]['title'];
$message = $availableErrors[$code]['message'];
$homeUrl = 'index.php';
$loginUrl = 'login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($code . ' ' . $title); ?></title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <style>
        body {
            margin: 0;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f4f6fb;
            color: #212b36;
            display: grid;
            min-height: 100vh;
            place-items: center;
            text-align: center;
            padding: 32px;
        }
        .error-card {
            max-width: 680px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
            padding: 48px 36px;
        }
        .error-code {
            font-size: 5rem;
            font-weight: 800;
            margin: 0;
            color: #1d4ed8;
        }
        .error-title {
            margin: 0.25rem 0 1rem;
            font-size: 1.75rem;
            font-weight: 700;
        }
        .error-message {
            margin: 0 0 1.75rem;
            line-height: 1.8;
            color: #475569;
            font-size: 1.05rem;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 22px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-primary {
            background: #1d4ed8;
            color: #ffffff;
            box-shadow: 0 12px 24px rgba(29, 78, 216, 0.18);
        }
        .btn-secondary {
            background: #eef2ff;
            color: #1d4ed8;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .aux-text {
            margin-top: 2rem;
            color: #64748b;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <p class="error-code"><?php echo htmlspecialchars($code); ?></p>
        <h1 class="error-title"><?php echo htmlspecialchars($title); ?></h1>
        <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <div class="button-group">
            <a class="btn btn-primary" href="<?php echo htmlspecialchars($homeUrl); ?>">Back to Home</a>
            <a class="btn btn-secondary" href="<?php echo htmlspecialchars($loginUrl); ?>">Sign In</a>
        </div>
        <p class="aux-text">If you think this is an error, contact support or try again later.</p>
    </div>
</body>
</html>
