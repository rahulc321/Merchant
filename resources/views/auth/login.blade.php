<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LMS Merchant Login</title>
    <link rel="icon" href="{{env('LOGO')}}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-[#0c0c0e] to-[#151518] min-h-screen flex items-center justify-center text-white"
    style="background: linear-gradient(to right, #071217, #16292f, #071820);">
    @include('not')
    <div class="flex flex-col md:flex-row items-center justify-center gap-10 w-full max-w-6xl p-6">

        <!-- Left Section -->
        <div class="text-center md:text-left">
            <div class="flex items-center justify-center mb-6">
                <div
                    class="h-20 w-20 bg-gradient-to-tr from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-10 text-white" viewBox="0 0 24 24"
                        stroke-width="2.2" stroke="currentColor" fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A8.001 8.001 0 0112 15a8.001 8.001 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl font-bold mb-4">Welcome to <span class="text-cyan-400">LMS Merchant</span></h1>
            <p class="text-gray-400 mb-6 max-w-md">
                A powerful merchant CRM designed to manage leads, monitor devices, track installations,
                and streamline operations — all from one secure dashboard.
            </p>

        </div>

        <!-- Right Section (Login Form) -->
        <div class="bg-[#1f1f23] p-8 rounded-xl shadow-xl w-full max-w-md" style="background-color: rgb(11 22 25);">
            <div class="flex justify-center mb-6">
                <div
                    class="bg-gradient-to-tr from-blue-500 to-cyan-400 h-12 w-12 flex items-center justify-center rounded-xl">
                    <span class="text-white font-bold text-lg">LMS</span>
                </div>
            </div>
            <h2 class="text-2xl font-semibold mb-6 text-center">Sign In</h2>
            <form action="{{ route('customLogin') }}" method="POST" class=" dz-form pb-3">
                @csrf
                <label class="block mb-4">
                    <span class="block text-gray-400 mb-1">Email Address</span>
                    <input type="email" required name="email" placeholder="Email Address"
                        class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                </label>
                <label class="block mb-4">
                    <span class="block text-gray-400 mb-1">Password</span>
                    <input type="password" required name="password" placeholder="Enter your password"
                        class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                </label>
                <div class="flex justify-between items-center mb-4 text-sm text-gray-400">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Remember me
                    </label>
                    <a href="#" class="text-cyan-400 hover:underline"></a>
                </div>
                <button class="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-2 rounded-md transition">Sign In to
                LMS Merchant</button>
            </form>
            <!-- <p class="text-center mt-6 text-sm text-gray-400">Need access? <span class="text-cyan-400">Contact your
                    administrator</span></p> -->
        </div>
    </div>

</body>

</html>