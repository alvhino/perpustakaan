{{-- resources/views/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .floating-label {
            position: absolute;
            pointer-events: none;
            left: 12px;
            top: 8px;
            transition: 0.2s ease all;
            color: #9CA3AF;
        }

        .input-field:focus ~ .floating-label,
        .input-field:not(:placeholder-shown) ~ .floating-label {
            transform: translateY(-20px) scale(0.85);
            color: #3B82F6;
            background-color: white;
            padding: 0 4px;
        }

        .login-card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .wave {
            animation: wave 8s linear infinite;
            opacity: 0.4;
        }

        .wave:nth-child(2) {
            animation-delay: -2s;
        }

        @keyframes wave {
            0% { transform: translateX(0); }
            50% { transform: translateX(-25%); }
            100% { transform: translateX(-50%); }
        }

        .hover-3d {
            transition: transform 0.3s ease-out;
        }

        .hover-3d:hover {
            transform: translateY(-5px) scale(1.005);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 relative overflow-hidden">
    <!-- Animated Background Waves -->
    <div class="absolute inset-0 overflow-hidden opacity-30">
        <div class="wave absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent"></div>
        <div class="wave absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        <div class="login-card p-8 rounded-2xl shadow-2xl w-full max-w-md animate__animated animate__fadeIn hover-3d">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Welcome Back!
                </h1>
                <p class="text-gray-600 mt-2">Enter your credentials to continue</p>
            </div>

            <form method="POST" action="{{url('/login')}}" id="loginForm" class="space-y-6">
                @csrf

                @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate__animated animate__shakeX" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                <div class="space-y-1">
                    <div class="relative">
                        <input type="text" 
                               name="username" 
                               id="username"
                               class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 placeholder-transparent"
                               required 
                               autocomplete="username"
                               placeholder="Username">
                        <label for="username" class="floating-label">Username</label>
                        <div class="absolute right-3 top-3 text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 placeholder-transparent"
                               required
                               placeholder="Password">
                        <label for="password" class="floating-label">Password</label>
                        <button type="button" 
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 transition-colors duration-200 toggle-password">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <span class="flex items-center justify-center">
                        <span>Sign in</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('.toggle-password').click(function() {
                const passwordInput = $('#password');
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                
                const icon = $(this).find('svg');
                if (type === 'password') {
                    icon.html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />');
                } else {
                    icon.html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />');
                }
            });

            // Form validation with animation
            $('#loginForm').on('submit', function(e) {
                const username = $('#username').val();
                const password = $('#password').val();
                
                if (!username || !password) {
                    e.preventDefault();
                    $(this).addClass('animate__animated animate__shakeX');
                    setTimeout(() => {
                        $(this).removeClass('animate__animated animate__shakeX');
                    }, 1000);
                }
            });

            // Floating label animation
            $('.input-field').on('focus blur', function(e) {
                $(this).parent().toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
            }).trigger('blur');
        });
    </script>
</body>
</html>