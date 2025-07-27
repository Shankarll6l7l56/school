<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                School Management System
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Sign in to your account
            </p>
        </div>
        
        <div class="bg-white py-8 px-6 shadow rounded-lg">
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="login_id" class="block text-sm font-medium text-gray-700">
                        Email or Student/Teacher ID
                    </label>
                    <div class="mt-1">
                        <input id="login_id" name="login_id" type="text" autocomplete="off" required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="Enter your email or Student/Teacher ID"
                               value="{{ old('login_id') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Demo Accounts</span>
                    </div>
                </div>
                
                <div class="mt-4 space-y-2 text-xs text-gray-600">
                    <div class="bg-gray-50 p-3 rounded">
                        <strong>Admin:</strong> admin@school.com / admin123
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <strong>Teacher:</strong> Use Teacher ID (TCH...) / password123
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <strong>Student:</strong> Use Student ID (STU...) / password123
                    </div>
                    <div class="bg-blue-50 p-3 rounded text-blue-700">
                        <strong>Note:</strong> Admin can use email, Students and Teachers should use their assigned ID
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 