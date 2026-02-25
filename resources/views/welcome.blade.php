<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centra Telemedia — Invoice Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0a0a0a;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── CANVAS BACKGROUND ── */
        #bgCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        /* ── SEMUA KONTEN DI ATAS CANVAS ── */
        nav, main, footer {
            position: relative;
            z-index: 1;
        }

        /* ── GLOW BULATAN EMAS ── */
        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.12;
            z-index: 0;
            animation: floatOrb 8s ease-in-out infinite;
        }
        .glow-orb-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #c9a227, transparent);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }
        .glow-orb-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #c9a227, transparent);
            bottom: -100px;
            left: -100px;
            animation-delay: 4s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        /* ── GOLD TEXT ── */
        .gold-text {
            background: linear-gradient(135deg, #f5c518, #c9a227, #f5c518);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shineText 3s linear infinite;
        }
        @keyframes shineText {
            0%   { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* ── TOMBOL ── */
        .btn-gold {
            background: linear-gradient(135deg, #c9a227, #f5c518, #c9a227);
            background-size: 200% auto;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-gold::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: rgba(255,255,255,0.3);
            transform: skewX(-20deg);
            animation: btnShine 3s ease-in-out infinite;
        }
        @keyframes btnShine {
            0%   { left: -60%; }
            100% { left: 160%; }
        }
        .btn-gold:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(201, 162, 39, 0.5);
        }

        /* ── CARD ── */
        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            background: rgba(201, 162, 39, 0.05);
            border-color: rgba(201, 162, 39, 0.3);
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(201, 162, 39, 0.1);
        }

        /* ── BADGE ── */
        .badge {
            background: rgba(201, 162, 39, 0.1);
            border: 1px solid rgba(201, 162, 39, 0.3);
            animation: pulseBadge 2s ease-in-out infinite;
        }
        @keyframes pulseBadge {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201, 162, 39, 0.2); }
            50%       { box-shadow: 0 0 0 8px rgba(201, 162, 39, 0); }
        }

        /* ── FADE IN ── */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }
        .fade-in-1 { animation-delay: 0.1s; }
        .fade-in-2 { animation-delay: 0.3s; }
        .fade-in-3 { animation-delay: 0.5s; }
        .fade-in-4 { animation-delay: 0.7s; }
        .fade-in-5 { animation-delay: 0.9s; }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    {{-- CANVAS ANIMASI PARTIKEL --}}
    <canvas id="bgCanvas"></canvas>

    {{-- GLOW ORB --}}
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>

    {{-- NAVBAR --}}
    <nav class="border-b border-yellow-900/20 px-8 py-4">
        <div class="max-w-6xl mx-auto flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            <div>
                <p class="text-white font-bold text-lg leading-none">CENTRA TELEMEDIA</p>
                <p class="text-yellow-400 text-xs">The Best GPS Tracking Innovation</p>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <main class="flex-1 flex items-center justify-center px-6 py-16 min-h-screen">
        <div class="max-w-4xl w-full text-center">

            {{-- Badge --}}
            <div class="fade-in fade-in-1 inline-block badge rounded-full px-4 py-1.5 mb-8">
                <span class="text-yellow-400 text-sm font-semibold">⚡ Sistem Invoice Otomatis</span>
            </div>

            {{-- Judul --}}
            <h1 class="fade-in fade-in-2 text-5xl md:text-6xl font-extrabold text-white leading-tight mb-4">
                Generate Invoice
                <span class="gold-text block mt-2">Lebih Cepat & Rapi</span>
            </h1>

            {{-- Deskripsi --}}
            <p class="fade-in fade-in-3 text-gray-400 text-lg max-w-xl mx-auto mb-12 leading-relaxed">
                Buat invoice profesional untuk layanan GPS server hanya dalam hitungan detik.
                Isi data, klik generate, langsung download PDF.
            </p>

            {{-- Tombol --}}
            <div class="fade-in fade-in-4">
                <a href="{{ route('invoice.create') }}">
                    <button class="btn-gold text-black font-extrabold text-lg px-10 py-4 rounded-2xl inline-flex items-center gap-3 shadow-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Start Generate
                    </button>
                </a>
            </div>

            {{-- Info Cards --}}
            <div class="fade-in fade-in-5 grid grid-cols-1 md:grid-cols-3 gap-4 mt-16">
                <div class="feature-card rounded-2xl p-6 text-left">
                    <div class="w-10 h-10 bg-yellow-400/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-bold mb-1">Cepat</h3>
                    <p class="text-gray-400 text-sm">Invoice siap dalam hitungan detik tanpa perlu edit manual.</p>
                </div>

                <div class="feature-card rounded-2xl p-6 text-left">
                    <div class="w-10 h-10 bg-yellow-400/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-bold mb-1">Akurat</h3>
                    <p class="text-gray-400 text-sm">Total dihitung otomatis, tidak ada risiko salah hitung.</p>
                </div>

                <div class="feature-card rounded-2xl p-6 text-left">
                    <div class="w-10 h-10 bg-yellow-400/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-bold mb-1">Profesional</h3>
                    <p class="text-gray-400 text-sm">Output PDF rapi siap dikirim langsung ke customer.</p>
                </div>
            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-yellow-900/20 py-5 text-center" style="position:relative; z-index:1;">
        <p class="text-gray-600 text-xs">
            © {{ date('Y') }} Centra Telemedia — Sistem Invoice GPS Server
        </p>
    </footer>

    {{-- SCRIPT ANIMASI PARTIKEL --}}
    <script>
        const canvas  = document.getElementById('bgCanvas');
        const ctx     = canvas.getContext('2d');
        let particles = [];

        function resize() {
            canvas.width  = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resize();
        window.addEventListener('resize', resize);

        // Buat partikel
        function createParticle() {
            return {
                x:       Math.random() * canvas.width,
                y:       Math.random() * canvas.height,
                size:    Math.random() * 2 + 0.5,
                speedX:  (Math.random() - 0.5) * 0.4,
                speedY:  (Math.random() - 0.5) * 0.4,
                opacity: Math.random() * 0.6 + 0.1,
                gold:    Math.random() > 0.6, // 40% partikel warna emas
            };
        }

        // Inisialisasi 120 partikel
        for (let i = 0; i < 120; i++) {
            particles.push(createParticle());
        }

        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fillStyle = p.gold
                    ? `rgba(201, 162, 39, ${p.opacity})`
                    : `rgba(255, 255, 255, ${p.opacity * 0.4})`;
                ctx.fill();

                // Gerakkan partikel
                p.x += p.speedX;
                p.y += p.speedY;

                // Kalau keluar layar, reset posisi
                if (p.x < 0 || p.x > canvas.width)  p.speedX *= -1;
                if (p.y < 0 || p.y > canvas.height)  p.speedY *= -1;
            });

            // Hubungkan partikel yang berdekatan dengan garis
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx   = particles[i].x - particles[j].x;
                    const dy   = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 100) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(201, 162, 39, ${0.08 * (1 - dist / 100)})`;
                        ctx.lineWidth   = 0.5;
                        ctx.stroke();
                    }
                }
            }

            requestAnimationFrame(drawParticles);
        }

        drawParticles();
    </script>

</body>
</html>