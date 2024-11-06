


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #ffffff, #c9c9c9);
            color: #333;
        }
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h2 {
            font-size: 24px;
            font-weight: 600;
            color: #6e8efb;
            margin-bottom: 10px;
        }
        p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }
        input[type="email"]:focus {
            border-color: #6e8efb;
            outline: none;
            box-shadow: 0 0 5px rgba(110, 142, 251, 0.4);
        }
        button {
            width: 100%;
            background: #6e8efb;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #5a7be3;
        }
        .back-link {
            margin-top: 20px;
            font-size: 14px;
            display: block;
            color: #6e8efb;
            text-decoration: none;
            transition: 0.3s;
        }
        .back-link:hover {
            color: #5a7be3;
        }
    </style>
</head>
<body data-bg="img/bg/bg.png">
    <div class="container" >
        <h2>Forgot Your Password?</h2>
        <p>Enter your email address below, and we’ll send you a link to reset your password.</p>

        @if (session('status'))
            <div style="color: green; margin-bottom: 15px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required autofocus>
                @error('email')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Send Reset Link</button>
        </form>

        <a href="/login" class="back-link">Back to Login</a>
    </div>
</body>
</html>
