@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-wrapper">
        <div class="login-header">
            <h1>Admin Login</h1>
            <p>Access your admin dashboard</p>
        </div>

        <form method="POST" action="{{ route('admin.login.submit') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" required autofocus
                       class="form-input {{ $errors->has('email') ? 'error' : '' }}">
                @if ($errors->has('email'))
                    <span class="error-text">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required
                       class="form-input {{ $errors->has('password') ? 'error' : '' }}">
                @if ($errors->has('password'))
                    <span class="error-text">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-options">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                    Remember me
                </label>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="login-btn">
                <span>Login to Admin Panel</span>
            </button>
        </form>
    </div>
</div>

<style>
.login-container {
    min-height: 100vh;
    background: white;
    display: flex;
    margin-top: 70px;
    margin-bottom: 70px;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-wrapper {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    overflow: hidden;
    width: 100%;
    max-width: 400px;
}

.login-header {
    background: linear-gradient(135deg, #333 0%, #555 100%);
    color: white;
    padding: 10px 10px;
    text-align: center;
}

.login-header h1 {
    font-size: 2rem;
    font-weight: 800;
    margin: 0 0 10px 0;
}

.login-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 14px;
}

.login-form {
    padding: 15px 15px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-input {
    width: 100%;
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #fafafa;
}

.form-input:focus {
    outline: none;
    border-color: #ffd700;
    background: white;
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
}

.form-input.error {
    border-color: #ff4444;
    background: #fff5f5;
}

.error-text {
    color: #ff4444;
    font-size: 13px;
    margin-top: 5px;
    display: block;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 14px;
    color: #666;
}

.checkbox-label input {
    display: none;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid #ddd;
    border-radius: 3px;
    margin-right: 8px;
    position: relative;
    transition: all 0.3s ease;
}

.checkbox-label input:checked + .checkmark {
    background: #ffd700;
    border-color: #ffd700;
}

.checkbox-label input:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.forgot-link {
    color: #ff4444;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.forgot-link:hover {
    text-decoration: underline;
}

.login-btn {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #ffd700 0%, #ff4444 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 68, 68, 0.3);
}

.login-btn:active {
    transform: translateY(0);
}

@media (max-width: 480px) {
    .login-container {
        padding: 15px;
    }

    .login-wrapper {
        max-width: 100%;
    }

    .login-header, .login-form {
        padding: 30px 20px;
    }

    .login-header h1 {
        font-size: 1.5rem;
    }
}
</style>
@endsection
