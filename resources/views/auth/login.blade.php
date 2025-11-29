<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProsharPOS - Login</title>
    <style>
        /* ===== Reset & Global ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background: url('{{ asset('uploads/images/login_page/wallpaper.jpg') }}') center/cover no-repeat fixed;
            color: #212529;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== Container ===== */
        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* ===== Card ===== */
        .login-card {
            background-color: rgba(255, 255, 255, 0.96);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            flex-direction: row;
        }

        /* ===== Left Panel ===== */
        .login-left {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
            padding: 40px 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin: 0 auto 10px;
            transition: transform 0.3s ease;
        }

        .login-left img:hover {
            transform: scale(1.08);
        }

        .login-left h2 {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-left p {
            font-size: 1rem;
            font-weight: 400;
        }

        /* ===== Right Panel ===== */
        .login-right {
            padding: 40px 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: 600;
            color: #0d6efd;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .login-form label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            font-size: 1rem;
            outline: none;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .login-form input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.25);
        }

        .btn-login {
            padding: 12px;
            border: none;
            border-radius: 50px;
            background-color: #0d6efd;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.35);
        }

        .forgot-link {
            text-align: right;
            font-size: 0.9rem;
            color: #0d6efd;
            cursor: pointer;
        }

        /* ===== Footer ===== */
        .login-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            color: #495057;
            flex-wrap: wrap;
        }

        .login-bottom a {
            color: #0d6efd;
            font-weight: 500;
            text-decoration: none;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }

            .login-left {
                padding: 20px;
            }

            .login-bottom {
                flex-direction: column;
                text-align: center;
            }

            .footer-left,
            .footer-right {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Left Side -->
            <div class="login-left">
                <img src="{{ asset('uploads/images/logor.png') }}" alt="Logo">
                <h2>Welcome to ProsharPOS</h2>
                <p>Smart. Simple. Secure.<br> Your business at your fingertips!</p>
            </div>

            <!-- Right Side -->
            <div class="login-right">
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    <div>
                        <label for="login">Email or Username</label>
                        <input id="login" type="text" name="login" value="{{ old('login') }}"
                            placeholder="Enter your email or username" required autofocus>
                        @error('login')
                            <div style="color:#dc3545; font-size:0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Enter your password"
                            required>
                        @error('password')
                            <div style="color:#dc3545; font-size:0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="forgot-link" id="forgotPasswordLink">Forgot Password?</div>

                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="login-bottom">
        <div class="footer-left">
            <p>
                Need Help?
                <a href="#" id="callHelpdesk">09643 111 222</a> |
                <a href="#" id="emailHelpdesk">developers@totalofftec.com</a>
            </p>
        </div>
        <div class="footer-right">
            <p>Powered by <a href="#" id="visitDeveloper">TOTALOFFTEC</a></p>
        </div>
    </div>


    <!-- SweetAlert & Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("forgotPasswordLink").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Forgot Password?",
                text: "We'll help you recover it.",
                icon: "info",
                confirmButtonText: "Go to Reset Page"
            }).then(() => {
                window.location.href = "{{ route('password.request') }}";
            });
        });

        document.getElementById("callHelpdesk").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Call Helpdesk",
                text: "Do you want to call 09643 111 222?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Call Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "tel:09643111222";
                }
            });
        });

        document.getElementById("emailHelpdesk").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Email Helpdesk",
                text: "Do you want to email us?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Email Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "mailto:developers@totalofftec.com";
                }
            });
        });

        document.getElementById("visitDeveloper").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Visit TOTALOFFTEC?",
                text: "You are about to leave the page.",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Visit"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open("https://totalofftec.com", "_blank");
                }
            });
        });
    </script>
</body>

</html>
