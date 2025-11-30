<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div style="padding: var(--spacing-sm); background: var(--color-success); color: white; border-radius: var(--border-radius); margin-bottom: var(--spacing-md); font-size: 14px;">
            {{ session('status') }}
        </div>
    @endif

    @if (session('success'))
        <div style="padding: var(--spacing-sm); background: var(--color-success); color: white; border-radius: var(--border-radius); margin-bottom: var(--spacing-md); font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="padding: var(--spacing-sm); background: var(--color-error); color: white; border-radius: var(--border-radius); margin-bottom: var(--spacing-md); font-size: 14px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Title -->
    <h2 style="font-size: 24px; font-weight: 600; margin: 0 0 var(--spacing-md) 0; color: var(--color-text-primary);">
        Login
    </h2>

    <!-- Social Login Buttons -->
    <div style="margin-bottom: var(--spacing-lg);">
        <a href="{{ route('social.redirect', 'google') }}" class="btn" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: var(--spacing-sm); background: white; color: var(--color-text-primary); border: 1px solid var(--border-color);">
            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
                <path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z" fill="#34A853"/>
                <path d="M3.964 10.707c-.18-.54-.282-1.117-.282-1.707s.102-1.167.282-1.707V4.961H.957C.347 6.175 0 7.55 0 9s.348 2.825.957 4.039l3.007-2.332z" fill="#FBBC05"/>
                <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.961L3.964 7.293C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
            </svg>
            Continue with Google
        </a>

        <a href="{{ route('social.redirect', 'facebook') }}" class="btn" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 12px; background: white; color: var(--color-text-primary); border: 1px solid var(--border-color);">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            Continue with Facebook
        </a>
    </div>

    <!-- Divider -->
    <div style="display: flex; align-items: center; margin: var(--spacing-lg) 0;">
        <div style="flex: 1; height: 1px; background: var(--border-color);"></div>
        <span style="padding: 0 var(--spacing-md); font-size: 14px; color: var(--color-text-tertiary);">or</span>
        <div style="flex: 1; height: 1px; background: var(--border-color);"></div>
    </div>

    <!-- Email/Password Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div style="margin-bottom: var(--spacing-md);">
            <label for="email" style="display: block; font-size: 14px; font-weight: 500; color: var(--color-text-secondary); margin-bottom: 8px;">
                Email
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--border-radius); font-size: 14px; transition: var(--transition-base); background: white;"
                onfocus="this.style.borderColor='var(--color-text-primary)'; this.style.outline='none';"
                onblur="this.style.borderColor='var(--border-color)';"
            />
            @error('email')
                <p style="color: var(--color-error); font-size: 13px; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div style="margin-bottom: var(--spacing-md);">
            <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: var(--color-text-secondary); margin-bottom: 8px;">
                Password
            </label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--border-radius); font-size: 14px; transition: var(--transition-base); background: white;"
                onfocus="this.style.borderColor='var(--color-text-primary)'; this.style.outline='none';"
                onblur="this.style.borderColor='var(--border-color)';"
            />
            @error('password')
                <p style="color: var(--color-error); font-size: 13px; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div style="display: flex; align-items: center; margin-bottom: var(--spacing-md);">
            <input 
                id="remember_me" 
                type="checkbox" 
                name="remember"
                style="width: 16px; height: 16px; border: 1px solid var(--border-color); border-radius: 3px; cursor: pointer;"
            />
            <label for="remember_me" style="margin-left: 8px; font-size: 14px; color: var(--color-text-secondary); cursor: pointer;">
                Remember me
            </label>
        </div>

        <!-- Actions -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: var(--spacing-sm);">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link-subtle" style="font-size: 14px;">
                    Forgot password?
                </a>
            @endif

            <button type="submit" class="btn" style="margin-left: auto;">
                Sign in
            </button>
        </div>
    </form>

    <!-- Register Link -->
    <div style="margin-top: var(--spacing-lg); padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); text-align: center;">
        <p style="font-size: 14px; color: var(--color-text-secondary); margin: 0;">
            Don't have an account?
            <a href="{{ route('register') }}" class="link-subtle" style="font-weight: 500; color: var(--color-text-primary);">
                Sign up
            </a>
        </p>
    </div>
</x-guest-layout>
