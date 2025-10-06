<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Po Depo</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-neutral-900 via-gray-800 to-black text-gray-100 font-[Poppins] overflow-hidden">

    {{-- Partikel latar belakang --}}
    <canvas id="particles" class="absolute inset-0 w-full h-full"></canvas>

    {{-- Box login --}}
    <div class="relative z-10 w-full max-w-md bg-gray-900/70 backdrop-blur-md rounded-2xl shadow-2xl p-8 animate-fadeInUp">
        <div class="text-center mb-6">
            <a href="/" class="text-4xl font-bold tracking-wide text-white">
                <b>Po</b><span class="text-gray-400">Depo</span>
            </a>
            <p class="mt-2 text-gray-400">Sign in to start your session</p>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="bg-red-600 bg-opacity-70 text-white p-3 rounded-md mb-4 animate-pulse">
                <ul class="mb-0 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="input-email" class="block mb-1 text-sm text-gray-300">Email</label>
                <div class="relative">
                    <input id="input-email" type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:ring-2 focus:ring-gray-400 focus:outline-none"
                        placeholder="Enter your email" required autofocus>
                    <span class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-envelope"></i></span>
                </div>
            </div>

            <div>
                <label for="input-password" class="block mb-1 text-sm text-gray-300">Password</label>
                <div class="relative">
                    <input id="input-password" type="password" name="password"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:ring-2 focus:ring-gray-400 focus:outline-none"
                        placeholder="Enter your password" required>
                    <span class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-lock"></i></span>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="accent-gray-500">
                    <span class="text-sm text-gray-400">Remember Me</span>
                </label>
            </div>

            <button id="button-login"
                type="submit"
                class="w-full bg-gray-100 hover:bg-white text-black font-semibold py-2 rounded-lg mt-3 shadow-md transform transition hover:scale-105 hover:shadow-gray-300">
                Sign In
            </button>
        </form>
    </div>

    {{-- Tailwind animation keyframes via CDN config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                    animation: {
                        fadeInUp: 'fadeInUp 1s ease-out',
                    },
                }
            }
        }
    </script>

    {{-- Partikel JS --}}
    <script>
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        let particles = [];

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.radius = Math.random() * 2.2;
                this.speedX = (Math.random() - 0.5) * 0.3;
                this.speedY = (Math.random() - 0.5) * 0.3;
                this.opacity = Math.random() * 0.6 + 0.2;
            }
            move() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(255,255,255,${this.opacity})`;
                ctx.fill();
            }
        }

        function initParticles() {
            particles = [];
            for (let i = 0; i < 100; i++) {
                particles.push(new Particle());
            }
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.move();
                p.draw();
            });
            requestAnimationFrame(animateParticles);
        }

        initParticles();
        animateParticles();
    </script>

</body>
</html>
