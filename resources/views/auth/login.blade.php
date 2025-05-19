<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - SIAGOSIS</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('template/public/assets') }}/css/tailwind.output.css" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="{{ asset('template/public/assets')}}/js/init-alpine.js"></script>
  </head>
  <body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden"
              src="{{ asset('template/public/assets')}}/img/login-office.jpeg"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="{{ asset('template/public/assets')}}/img/login-office-dark.jpeg"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1
                class="mb-4 text-xl font-semibold text-center text-gray-700 dark:text-gray-200"
              >
                SIAGOSIS | LOGIN
              </h1>

              <!-- Session Status -->
              <x-auth-session-status class="px-4 py-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-200"
                                   :status="session('status')" />

              <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Email</span>
                  <x-text-input id="email"
                              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                              type="email"
                              name="email"
                              :value="old('email')"
                              required
                              autofocus
                              autocomplete="username"
                              placeholder="user@siagosis.com" />
                  <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </label>

                <!-- Password -->
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Password</span>
                  <div class="relative">
                    <x-text-input id="password"
                                class="block w-full pr-10 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="password/+-" />
                    <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 px-3 py-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                      <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                    </button>
                  </div>
                  <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </label>

                <!-- Remember Me -->
                <div class="block mt-4">
                  <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                          class="text-purple-600 border-gray-300 rounded shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700"
                          name="remember">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                  </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                  @if (Route::has('password.request'))
                    <a class="text-sm text-purple-600 hover:text-purple-500 dark:text-purple-400 dark:hover:text-purple-300 hover:underline"
                      href="{{ route('password.request') }}">
                      {{ __('Forgot your password?') }}
                    </a>
                  @endif

                  <x-primary-button class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    {{ __('Log in') }}
                  </x-primary-button>
                </div>
              </form>

              <script>
                function togglePassword() {
                  const passwordInput = document.getElementById('password');
                  const eyeIcon = document.getElementById('eyeIcon');

                  const isPassword = passwordInput.type === 'password';
                  passwordInput.type = isPassword ? 'text' : 'password';

                  eyeIcon.innerHTML = isPassword
                    ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.052 10.052 0 012.303-3.568M6.343 6.343A10.05 10.05 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.052 10.052 0 01-4.132 5.17M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />`
                    : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                }
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>