<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SI UNIVERSE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-[#0f172a] min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/20 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-2xl shadow-blue-500/40 mx-auto mb-4 scale-110">
                <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">SIU Admin</h1>
            <p class="text-slate-400 mt-2 text-sm font-medium">Command Center Authentication</p>
        </div>

        <!-- Login Card -->
        <div class="glass-panel p-8 rounded-[2rem] shadow-2xl">
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-center space-x-3 text-red-500 text-sm animate-shake">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-500 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-widest mb-2 ml-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <input type="text" name="username" required 
                            class="block w-full pl-11 pr-4 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl text-slate-800 placeholder-slate-400 transition-all outline-none font-medium" 
                            placeholder="admin@2026" value="{{ old('username') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-widest mb-2 ml-1">Secret Key</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <i class="fas fa-key"></i>
                        </div>
                        <input type="password" name="password" required 
                            class="block w-full pl-11 pr-4 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl text-slate-800 placeholder-slate-400 transition-all outline-none font-medium" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-4 rounded-2xl shadow-xl shadow-blue-500/25 transition-all active:scale-[0.98] flex items-center justify-center space-x-2">
                        <span>Initialize Session</span>
                        <i class="fas fa-arrow-right text-xs opacity-70"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center mt-8 text-slate-500 text-xs font-medium tracking-wide italic">
            &copy; {{ date('Y') }} SI UNIVERSE Security Protocols v2.4
        </p>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .animate-shake { animation: shake 0.3s cubic-bezier(.36,.07,.19,.97) both; }
    </style>
</body>
</html>
