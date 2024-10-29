<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f7fafc;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .message {
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: #4a5568;
            text-align: center;
        }
        .status-message {
            margin-bottom: 1rem;
            font-weight: medium;
            font-size: 0.875rem;
            color: #38a169;
            text-align: center;
        }
        .button {
            background-color: #4299e1;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            width: 100%;
            margin-bottom: 1rem;
        }
        .logout-button {
            background: none;
            color: #2d3748;
            padding: 0;
            border: none;
            text-decoration: underline;
            cursor: pointer;
            width: 100%;
        }
        .logo-login-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            text-align-last: center;
            padding-bottom: 27px;
            border-bottom: 1px solid #d1d1d1;
        }
        .logo-login {
            width: 54%;
        }
        .alert {
            text-align: center;
            background-color: #ebebeb;
            padding: 18px 8px;
            margin-bottom: 27px;
            border-radius: 8px;
            color: #9b9b9b;
        }
        .button-text{
            width: 100%;
            text-align: center;
        }
        .button-text a{
            color: #008cff;
            text-decoration: none;
            font-weight: 600;
        }
        .button-text a:hover{
            color: #005aa3;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="logo-login-container">
            <img class="logo-login" src="{{ asset('logo/logo-kami-sewain-caption-color.png') }}" alt="Logo Kami Sewain PNG">
        </div>
        <h2>Email Verification</h2>
        <div class="message">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="status-message">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                <script>
                    // Mulai countdown jika link verifikasi telah dikirim
                    startCountdown(60);
                </script>
            </div>
        @endif

        <form id="resendVerificationForm" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="button" class="button" id="resendButton">
                {{ __('Resend Verification Email') }}
            </button>
        </form>
        
    </div>

    <script>
        $(document).ready(function() {
            const resendButton = $('#resendButton');
            const form = $('#resendVerificationForm');

            resendButton.on('click', function() {
                startCountdown(60); // Mulai countdown
                sendVerificationEmail(); // Kirim email verifikasi
            });

            function startCountdown(seconds) {
                const startTime = Date.now();
                const endTime = startTime + seconds * 1000;
                localStorage.setItem('countdownEndTime', endTime); // Simpan waktu berakhir ke localStorage

                resendButton.prop('disabled', true); // Nonaktifkan tombol
                updateButtonText(seconds); // Ubah teks tombol

                const countdownInterval = setInterval(() => {
                    const timeRemaining = Math.ceil((endTime - Date.now()) / 1000);

                    if (timeRemaining <= 0) {
                        clearInterval(countdownInterval); // Hentikan countdown
                        resendButton.prop('disabled', false); // Aktifkan tombol
                        resendButton.text('{{ __('Resend Verification Email') }}'); // Reset teks tombol
                        localStorage.removeItem('countdownEndTime'); // Hapus item dari localStorage
                    } else {
                        updateButtonText(timeRemaining); // Update teks tombol
                    }
                }, 1000); // Update setiap detik
            }

            function updateButtonText(seconds) {
                resendButton.text(`Resend in ${seconds} seconds`); // Update teks tombol
            }

            function sendVerificationEmail() {
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        $('.container').prepend('<div class="alert alert-success">Verification email has been sent successfully!</div>');
                    },
                    error: function(xhr) {
                        // Tangani error jika perlu
                    }
                });
            }

            // Cek apakah ada countdown yang tersimpan di localStorage saat halaman dimuat
            const countdownEndTime = localStorage.getItem('countdownEndTime');
            if (countdownEndTime) {
                const remainingTime = Math.ceil((countdownEndTime - Date.now()) / 1000);
                if (remainingTime > 0) {
                    startCountdown(remainingTime); // Mulai countdown dari waktu yang tersisa
                }
            }
        });
    </script>
</body>
</html>
