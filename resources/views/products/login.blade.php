<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - B-DEAMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --navy: #0d1b2a;
            --navy-mid: #1b2e42;
            --navy-light: #243447;
            --teal: #0ea5a0;
            --teal-light: #e0f7f6;
            --amber: #f59e0b;
            --amber-light: #fef3c7;
            --rose: #f43f5e;
            --rose-light: #ffe4e6;
            --green: #10b981;
            --green-light: #d1fae5;
            --blue: #3b82f6;
            --blue-light: #dbeafe;
            --slate-light: #f1f5f9;
            --white: #ffffff;
            --border: #e2e8f0;
            --text-dark: #0f172a;
            --text-mid: #475569;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #1a1f2e;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:%230d1b2a;stop-opacity:0.1"/><stop offset="100%" style="stop-color:%230ea5a0;stop-opacity:0.05"/></linearGradient></defs><circle cx="100" cy="60" r="25" fill="%23dc2626" opacity="0.1"/><path d="M75 85 Q100 70 125 85 Q100 100 75 85" fill="%231e40af" opacity="0.1"/><path d="M60 120 Q60 100 75 85 L125 85 Q140 100 140 120 Q140 140 125 155 L75 155 Q60 140 60 120" fill="url(%23grad)" stroke="%230ea5a0" stroke-width="0.5" opacity="0.15"/><text x="100" y="180" text-anchor="middle" font-family="Arial" font-size="8" fill="%23e2e8f0" opacity="0.3">DSWD</text></svg>');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.08;
            z-index: -1;
            animation: float 30s ease-in-out infinite;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .login-wrapper {
            display: flex;
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(13, 27, 42, 0.4), 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 900px;
            min-height: 500px;
        }

        .login-left {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 40px;
        }

        .brand-badge {
            width: 38px;
            height: 38px;
            background: transparent;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: white;
            flex-shrink: 0;
            transition: transform 0.6s ease;
            cursor: pointer;
        }

        .brand-badge:hover {
            transform: rotate(360deg);
        }

        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: 0.02em;
        }

        .brand-sub {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 300;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-top: 1px;
        }

        h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 40px;
            line-height: 1.2;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--text-muted);
            margin-bottom: 7px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--slate-light);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0 13px;
            transition: all 0.2s;
        }

        .input-wrapper:focus-within {
            background: var(--white);
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14, 165, 160, 0.12);
        }

        .input-icon {
            color: var(--text-muted);
            margin-right: 10px;
            font-size: 14px;
            transition: color 0.2s;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--teal);
        }

        input {
            width: 100%;
            padding: 10px 0;
            border: none;
            background: transparent;
            font-size: 13.5px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            outline: none;
        }

        input::placeholder {
            color: var(--text-muted);
        }

        .eye-icon {
            color: var(--text-muted);
            cursor: pointer;
            font-size: 14px;
            padding: 5px;
            transition: color 0.2s;
        }

        .eye-icon:hover {
            color: var(--teal);
        }

        button {
            width: 100%;
            background: var(--navy);
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            background: var(--navy-mid);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 27, 42, 0.15);
        }

        .login-right {
            flex: 1;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-right::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 140%;
            background: radial-gradient(circle, rgba(14, 165, 160, 0.1) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        .login-right-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            padding: 40px;
        }

        .login-right-icon {
            width: 80px;
            height: 80px;
            background: transparent;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: var(--teal);
            margin: 0 auto 30px;
            transition: transform 0.8s ease;
            cursor: pointer;
        }

        .login-right-icon:hover {
            transform: rotate(360deg) scale(1.1);
        }

        .dswd-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
        }

        .brand-badge .dswd-logo {
            width: 30px;
            height: 30px;
            border-radius: 6px;
        }

        .login-right-title {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .login-right-sub {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
        }

        .flash-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 22px;
            animation: fadeUp 0.3s ease both;
        }

        .flash-alert.success { 
            background: var(--green-light); 
            color: #065f46; 
        }
        
        .flash-alert.error { 
            background: var(--rose-light);  
            color: #9f1239; 
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .shake {
            animation: shake 0.3s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 100%;
            }
            
            .login-right {
                min-height: 150px;
            }

            .login-left {
                padding: 40px 30px;
            }

            .login-right-content {
                padding: 30px 20px;
            }

            .login-right-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper {{ $errors->any() ? 'shake' : '' }}">
        <div class="login-left">
            <div class="brand-section">
                <div class="brand-badge">
                    <img src="{{ asset('images/dswd_logo.png') }}" alt="DSWD Logo" class="dswd-logo">
                </div>
                <div>
                    <div class="brand-name">MSWD Information System With Intellegent Decision Support</div> <br>
                    <div class="brand-sub">Barangay Gargato</div>
                </div>
            </div>
            

            {{-- Success message --}}
            @if(session('Success'))
                <div class="flash-alert success">
                    <i class="fas fa-circle-check"></i>
                    <span>{{ session('Success') }}</span>
                </div>
            @endif

            {{-- Error message --}}
            @if($errors->any())
                <div class="flash-alert error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="input-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                        <i class="fas fa-eye eye-icon" onclick="togglePassword()"></i>
                    </div>
                </div>

                <button type="submit">
                    <i class="fas fa-right-to-bracket"></i>
                    Login
                </button>
            </form>
        </div>

        <div class="login-right">
            <div class="login-right-content">
                <div class="login-right-icon">
                    <img src="{{ asset('images/dswd_logo.png') }}" alt="DSWD Logo" class="dswd-logo">
                </div>
                <div class="login-right-title">Municipal Social Welfare and Development</div>
                <div class="login-right-sub">
                    Barangay Disaster Evacuation and Management System<br>
                    Secure access to emergency response coordination
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>