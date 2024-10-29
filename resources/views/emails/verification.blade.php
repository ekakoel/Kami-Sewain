<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 1px solid #c1c1c1;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 18px;
        }

        .cta-button {
            background-color: #3d3d3d;
            color: #ffffff !important;
            padding: 12px 24px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .cta-button:hover {
            background-color: #444444;
        }

        .url-link {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
            word-wrap: break-word;
        }

        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="email-container">
    <img src="https://www.kamisewain.com/public_folder/logo/logo-kami-sewain-caption-color.png" alt="Logo Kami Sewain PNG" class="logo" width="150">
    <h1>Verify Your Email Address</h1>
    <p>Thank you for registering! To complete the process, please verify your email by clicking the button below:</p>
    
    <a href="{{ $url }}" class="cta-button">Verify Email</a>

    <p>If the button above doesn't work, copy and paste the following link into your browser:</p>
    <a href="{{ $url }}" class="url-link">{{ $url }}</a>
    
    <p class="footer">If you did not create an account, no further action is required.</p>
</div>

</body>
</html>
