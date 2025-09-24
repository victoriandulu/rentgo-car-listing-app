@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->

<div class="sell-car-container">
    <div class="sell-car-hero">
        <div class="hero-content">
            <h1>Sell Your Car With Confidence</h1>
            <p>Join thousands of satisfied sellers who found the perfect buyers on our platform</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">50K+</span>
                    <span class="stat-label">Cars Sold</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">4.8</span>
                    <span class="stat-label">User Rating</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">7 Days</span>
                    <span class="stat-label">Avg. Selling Time</span>
                </div>
            </div>
        </div>
        <div class="car-illustration"></div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-section">
            <div class="card">
                @if(session('success'))
                    <div class="success-message show">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="error-message show">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab {{ !session('login_tab') ? 'active' : '' }}" onclick="switchTab('signup')">Sign Up</button>
                    <button class="tab {{ session('login_tab') ? 'active' : '' }}" onclick="switchTab('login')">Log In</button>
                </div>

                <!-- Google Auth Button -->
                <a href="{{ route('auth.google') }}" class="btn btn-google">
                    <i class="fab fa-google"></i>
                    <span id="googleText">Continue with Google</span>
                </a>

                <div class="divider">
                    <span>or</span>
                </div>

                <!-- Sign Up Form -->
                <form class="auth-form {{ !session('login_tab') ? 'active' : '' }}" id="signupForm" method="POST" action="{{ route('auth.register') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstName" value="{{ old('firstName') }}" required
                                   class="{{ $errors->has('firstName') ? 'error' : '' }}">
                            @error('firstName')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}" required
                                   class="{{ $errors->has('lastName') ? 'error' : '' }}">
                            @error('lastName')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="{{ $errors->has('email') ? 'error' : '' }}">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-container">
                            <input type="password" id="password" name="password" required
                                   class="{{ $errors->has('password') ? 'error' : '' }}">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-container">
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Sign Up & Sell Your Car
                    </button>
                </form>

                <!-- Login Form -->
                <form class="auth-form {{ session('login_tab') ? 'active' : '' }}" id="loginForm" method="POST" action="{{ route('auth.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="login_email">Email</label>
                        <input type="email" id="login_email" name="email" value="{{ old('email') }}" required
                               class="{{ $errors->has('email') ? 'error' : '' }}">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="login_password">Password</label>
                        <div class="input-container">
                            <input type="password" id="login_password" name="password" required
                                   class="{{ $errors->has('password') ? 'error' : '' }}">
                            <button type="button" class="password-toggle" onclick="togglePassword('login_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Log In & Start Selling
                    </button>
                </form>

                <!-- Form Footer -->
                <div class="form-footer">
                    <p id="switchText">
                        {{ !session('login_tab') ? 'Already have an account?' : "Don't have an account?" }}
                        <a href="#" class="text-link" onclick="switchTab('{{ !session('login_tab') ? 'login' : 'signup' }}')">
                            {{ !session('login_tab') ? 'Log In' : 'Sign Up' }}
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Benefits Sidebar -->
        <div class="benefits">
            <h3>Why Sell With Us?</h3>
            <ul class="benefits-list">
                <li>
                    <div class="benefit-icon"><i class="fas fa-check"></i></div>
                    Free basic listings with no hidden fees
                </li>
                <li>
                    <div class="benefit-icon"><i class="fas fa-dollar-sign"></i></div>
                    Get up to 15% more than dealer trade-in value
                </li>
                <li>
                    <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                    Verified buyers and secure payment process
                </li>
                <li>
                    <div class="benefit-icon"><i class="fas fa-chart-line"></i></div>
                    Market analysis tools to price your car right
                </li>
                <li>
                    <div class="benefit-icon"><i class="fas fa-star"></i></div>
                    Premium listing options for faster selling
                </li>
            </ul>

            <div class="testimonial">
                <p>"I sold my BMW in just 3 days for 3.5m more than the dealership offered!"</p>
                <div class="user-info">
                    <div class="avatar"></div>
                    <div>
                        <strong>Michael T.</strong>
                        <div class="rating">★★★★★</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --rentgo-red: #e53e3e;
    --rentgo-yellow: #ffd700;
    --rentgo-dark: #4a5568;
    --rentgo-light-red: #fed7d7;
    --rentgo-light-yellow: #fffacd;
    --shadow-soft: 0 10px 30px rgba(229, 62, 62, 0.1);
    --shadow-strong: 0 20px 40px rgba(229, 62, 62, 0.15);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --border-radius: 20px;
}

.sell-car-container {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  color: var(--rentgo-dark);
  max-width: 1400px;
  margin: 0 auto;
}

/* Hero Section */
.sell-car-hero {
  display: flex;
  align-items: center;
  padding: 80px 40px;
  background: linear-gradient(135deg, var(--rentgo-light-red) 0%, var(--rentgo-light-yellow) 100%);
  border-radius: 0 0 50px 50px;
  position: relative;
  overflow: hidden;
}

.sell-car-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill-opacity='0.03' fill='%23e53e3e'%3E%3Cpolygon points='30,0 60,30 30,60 0,30'/%3E%3C/g%3E%3C/svg%3E") center/60px;
}

.hero-content {
  flex: 1;
  max-width: 600px;
  z-index: 2;
}

.hero-content h1 {
  font-size: clamp(36px, 5vw, 48px);
  font-weight: 800;
  margin-bottom: 20px;
  color: var(--rentgo-red);
  line-height: 1.2;
  text-shadow: 0 2px 4px rgba(229, 62, 62, 0.1);
}

.hero-content p {
  font-size: 18px;
  line-height: 1.6;
  color: var(--rentgo-dark);
  margin-bottom: 40px;
  opacity: 0.9;
}

.hero-stats {
  display: flex;
  gap: 40px;
}

.stat-item {
  display: flex;
  flex-direction: column;
  padding: 20px;
  background: rgba(255, 255, 255, 0.8);
  border-radius: 20px;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(229, 62, 62, 0.1);
}

.stat-number {
  font-size: 32px;
  font-weight: 700;
  color: var(--rentgo-red);
  text-shadow: 0 2px 4px rgba(229, 62, 62, 0.1);
}

.stat-label {
  font-size: 14px;
  color: var(--rentgo-dark);
  opacity: 0.8;
}

.car-illustration {
  flex: 1;
  height: 400px;
  background: linear-gradient(135deg, var(--rentgo-red), var(--rentgo-yellow));
  border-radius: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.car-illustration::after {
  content: '🚗';
  font-size: 120px;
  opacity: 0.3;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}
/* SMALL SELL HERO */
/* Responsive for small screens */
@media (max-width: 768px) {
  .sell-car-hero {
    flex-direction: column;
    padding: 40px 20px;
    margin-top: 68px;
    border-radius: 0 0 30px 30px;
  }

  .hero-content {
    max-width: 100%;
    text-align: center;
    margin-bottom: 30px;
  }

  .hero-content h1 {
    font-size: clamp(28px, 6vw, 36px);
  }

  .hero-content p {
    font-size: 16px;
    margin-bottom: 30px;
  }

  .hero-stats {
    flex-direction: column;
    gap: 20px;
    align-items: center;
  }

  .stat-item {
    width: 100%;
    max-width: 280px;
  }

  .car-illustration {
    width: 100%;
    height: 250px;
    border-radius: 20px;
  }

  .car-illustration::after {
    font-size: 80px;
  }
}

@media (max-width: 480px) {
  .sell-car-hero {
    padding: 30px 15px;
  }

  .hero-content h1 {
    font-size: 24px;
  }

  .hero-content p {
    font-size: 14px;
  }

  .stat-number {
    font-size: 24px;
  }

  .stat-label {
    font-size: 12px;
  }
}



.main-content {
    display: flex;
    gap: 40px;
    padding: 60px 0;
}

.form-section {
    flex: 2;
    max-width: 600px;
}

.card {
    background: white;
    border-radius: 30px;
    box-shadow: var(--shadow-strong);
    padding: 40px;
    border: 1px solid rgba(229, 62, 62, 0.05);
}

.tabs {
    display: flex;
    margin-bottom: 30px;
    background: var(--rentgo-light-red);
    border-radius: var(--border-radius);
    padding: 4px;
}

.tab {
    flex: 1;
    background: none;
    border: none;
    padding: 16px 20px;
    font-size: 16px;
    font-weight: 600;
    color: var(--rentgo-dark);
    cursor: pointer;
    border-radius: 16px;
    transition: var(--transition);
}

.tab.active {
    background: var(--rentgo-red);
    color: white;
    box-shadow: var(--shadow-soft);
}

.auth-form {
    display: none;
}

.auth-form.active {
    display: block;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 16px;
    border-radius: var(--border-radius);
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    text-decoration: none;
}

.btn-google {
    background: white;
    color: var(--rentgo-dark);
    border: 2px solid var(--rentgo-light-red);
    margin-bottom: 30px;
    gap: 12px;
}

.btn-google:hover {
    background: var(--rentgo-light-red);
    border-color: var(--rentgo-red);
    transform: translateY(-2px);
    box-shadow: var(--shadow-soft);
    text-decoration: none;
    color: var(--rentgo-dark);
}

.btn-primary {
    background: linear-gradient(135deg, var(--rentgo-red), var(--rentgo-yellow));
    color: white;
    margin-top: 20px;
    box-shadow: var(--shadow-soft);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-strong);
}

.divider {
    position: relative;
    text-align: center;
    margin: 30px 0;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--rentgo-light-red), transparent);
}

.divider span {
    background: white;
    padding: 0 20px;
    color: var(--rentgo-dark);
    font-weight: 500;
}

.form-row {
    display: flex;
    gap: 20px;
}

.form-group {
    margin-bottom: 25px;
    flex: 1;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--rentgo-dark);
    font-size: 14px;
}

.input-container {
    position: relative;
}

input {
    width: 100%;
    padding: 16px 20px;
    border: 2px solid var(--rentgo-light-red);
    border-radius: 15px;
    font-size: 16px;
    transition: var(--transition);
    background: rgba(255, 255, 255, 0.8);
}

input:focus {
    outline: none;
    border-color: var(--rentgo-red);
    box-shadow: 0 0 0 4px rgba(229, 62, 62, 0.1);
    background: white;
}

input.error {
    border-color: var(--rentgo-red);
    background: var(--rentgo-light-red);
}

.password-toggle {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--rentgo-dark);
    opacity: 0.6;
    padding: 8px;
}

.password-toggle:hover {
    opacity: 1;
}

.error-message {
    color: var(--rentgo-red);
    font-size: 14px;
    margin-top: 8px;
    font-weight: 500;
}

.success-message {
    background: var(--rentgo-light-yellow);
    color: var(--rentgo-red);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 30px;
    border: 2px solid var(--rentgo-yellow);
    font-weight: 600;
    display: none;
}

.success-message.show {
    display: block;
}

.form-footer {
    margin-top: 30px;
    text-align: center;
}

.text-link {
    color: var(--rentgo-red);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}

.text-link:hover {
    color: var(--rentgo-yellow);
}

.benefits {
    flex: 1;
    background: linear-gradient(135deg, var(--rentgo-light-yellow) 0%, var(--rentgo-light-red) 100%);
    border-radius: 30px;
    padding: 40px;
    border: 1px solid rgba(255, 215, 0, 0.2);
}

.benefits h3 {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 30px;
    color: var(--rentgo-red);
    text-align: center;
}

.benefits-list {
    list-style: none;
    margin-bottom: 40px;
}

.benefits-list li {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 15px;
    transition: var(--transition);
}

.benefits-list li:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateX(5px);
}

.benefit-icon {
    width: 40px;
    height: 40px;
    margin-right: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--rentgo-red);
    color: white;
    font-size: 16px;
}

.testimonial {
    background: white;
    padding: 30px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    border: 1px solid rgba(229, 62, 62, 0.1);
}

.testimonial p {
    font-style: italic;
    margin-bottom: 20px;
    line-height: 1.6;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--rentgo-red), var(--rentgo-yellow));
}

.rating {
    color: var(--rentgo-yellow);
    font-size: 16px;
}

@media (max-width: 992px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
    }

    .main-content {
        flex-direction: column;
        padding: 40px 0;
    }

    .stats {
        justify-content: center;
        flex-wrap: wrap;
    }
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
    }

    .stats {
        flex-direction: column;
        align-items: center;
    }

    .card, .benefits {
        padding: 25px 20px;
    }
}
</style>

<script>
function switchTab(tab) {
    // Update tabs
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelector(`.tab:nth-child(${tab === 'signup' ? '1' : '2'})`).classList.add('active');

    // Update forms
    document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
    document.getElementById(tab === 'signup' ? 'signupForm' : 'loginForm').classList.add('active');

    // Update footer text and Google text
    const switchText = document.getElementById('switchText');
    const googleText = document.getElementById('googleText');

    if (tab === 'signup') {
        switchText.innerHTML = 'Already have an account? <a href="#" class="text-link" onclick="switchTab(\'login\')">Log In</a>';
        googleText.textContent = 'Sign up with Google';
    } else {
        switchText.innerHTML = 'Don\'t have an account? <a href="#" class="text-link" onclick="switchTab(\'signup\')">Sign Up</a>';
        googleText.textContent = 'Log in with Google';
    }
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
