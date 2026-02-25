<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Invoice — Centra Telemedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
        }

        /* ── HEADER ── */
        .header-bar {
            background: linear-gradient(135deg, #111 0%, #1f1f1f 50%, #111 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        /* ── CARD ANIMASI ── */
        .form-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .form-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.1);
        }

        /* ── INPUT FOCUS ANIMASI ── */
        .animated-input {
            transition: all 0.25s ease;
            border: 1.5px solid #e2e8f0;
        }
        .animated-input:focus {
            outline: none;
            border-color: #c9a227;
            box-shadow: 0 0 0 3px rgba(201,162,39,0.15);
            transform: scale(1.01);
        }

        /* ── LABEL FLOAT ── */
        .input-group {
            position: relative;
        }

        /* ── ITEM ROW ANIMASI ── */
        .item-row {
            animation: slideInRow 0.3s ease forwards;
            background: #f8fafc;
            border-radius: 0.75rem;
            padding: 0.75rem;
            border: 1px solid transparent;
            transition: border-color 0.2s ease, background 0.2s ease;
        }
        .item-row:hover {
            border-color: #e8d99a;
            background: #fffdf0;
        }
        @keyframes slideInRow {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ── GRAND TOTAL ANIMASI ── */
        .total-box {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            border-radius: 0.875rem;
            padding: 1rem 1.5rem;
            text-align: right;
            min-width: 220px;
            transition: box-shadow 0.3s ease;
        }
        .total-box:hover {
            box-shadow: 0 8px 24px rgba(201,162,39,0.25);
        }
        .total-amount {
            font-size: 1.5rem;
            font-weight: 800;
            color: #f5c518;
            transition: all 0.4s ease;
        }
        .total-amount.bump {
            transform: scale(1.15);
            color: #fff;
        }

        /* ── TOMBOL SUBMIT ── */
        .btn-submit {
            background: linear-gradient(135deg, #c9a227, #f5c518, #c9a227);
            background-size: 200% auto;
            color: #000;
            font-weight: 800;
            padding: 0.875rem 2.5rem;
            border-radius: 0.875rem;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: rgba(255,255,255,0.35);
            transform: skewX(-20deg);
            animation: btnShine 2.5s ease-in-out infinite;
        }
        @keyframes btnShine {
            0%   { left: -60%; }
            100% { left: 160%; }
        }
        .btn-submit:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(201,162,39,0.4);
        }
        .btn-submit:active {
            transform: translateY(0px) scale(0.98);
        }

        /* ── TOMBOL TAMBAH ITEM ── */
        .btn-add {
            background: #1a1a1a;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-add:hover {
            background: #000;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        /* ── TOMBOL HAPUS ── */
        .btn-remove {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            padding: 4px;
            border-radius: 6px;
        }
        .btn-remove:hover {
            background: #fee2e2;
            transform: scale(1.2) rotate(10deg);
        }

        /* ── FADE IN CARDS ── */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.5s ease forwards;
        }
        .fade-up-1 { animation-delay: 0.05s; }
        .fade-up-2 { animation-delay: 0.15s; }
        .fade-up-3 { animation-delay: 0.25s; }
        .fade-up-4 { animation-delay: 0.35s; }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── ERROR ── */
        .error-box {
            animation: shakeError 0.4s ease;
        }
        @keyframes shakeError {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-8px); }
            40%       { transform: translateX(8px); }
            60%       { transform: translateX(-5px); }
            80%       { transform: translateX(5px); }
        }

        /* ── LOADING OVERLAY ── */
        #loadingOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 16px;
        }
        #loadingOverlay.show {
            display: flex;
        }
        .spinner {
            width: 52px;
            height: 52px;
            border: 4px solid rgba(255,255,255,0.1);
            border-top-color: #f5c518;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ── PROGRESS BAR ── */
        .progress-bar-wrap {
            width: 100%;
            height: 3px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #c9a227, #f5c518);
            width: 0%;
            border-radius: 2px;
            transition: width 0.4s ease;
        }
    </style>
</head>
<body>

    {{-- LOADING OVERLAY --}}
    <div id="loadingOverlay">
        <div class="spinner"></div>
        <p class="text-white font-semibold text-sm tracking-wide">Sedang membuat PDF...</p>
    </div>

    {{-- HEADER --}}
    <div class="header-bar">
        <div class="max-w-4xl mx-auto px-6 py-5 flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto">
            <div>
                <h1 class="text-white text-xl font-bold tracking-wide">CENTRA TELEMEDIA</h1>
                <p class="text-yellow-400 text-sm">Generator Invoice GPS Server</p>
            </div>
            <div class="ml-auto">
                <a href="{{ route('welcome') }}"
                   class="text-gray-400 hover:text-yellow-400 text-sm transition flex items-center gap-1">
                    ← Kembali
                </a>
            </div>
        </div>

        {{-- PROGRESS BAR --}}
        <div class="progress-bar-wrap rounded-none">
            <div class="progress-bar-fill" id="progressBar"></div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-8">

        {{-- VALIDASI ERROR --}}
        @if ($errors->any())
            <div class="error-box bg-red-50 border border-red-300 rounded-xl p-4 mb-6">
                <p class="font-semibold text-red-700 mb-2">⚠️ Ada kesalahan input:</p>
                <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('invoice.generate') }}" method="POST" id="invoiceForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- KOLOM KIRI: Info Penerima --}}
                <div class="form-card p-6 space-y-4 fade-up fade-up-1">
                    <h2 class="text-base font-bold text-gray-800 border-b border-gray-100 pb-3">
                        📋 Info Penerima
                    </h2>
                    <div class="input-group">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Kepada Yth. <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kepada" value="{{ old('kepada') }}"
                               placeholder="cth: Bpk Khoirul (PAS GPS)"
                               class="animated-input w-full rounded-lg px-4 py-2.5 text-sm">
                    </div>
                    <div class="input-group">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Username Customer <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" value="{{ old('username') }}"
                               placeholder="cth: PAS GPS"
                               class="animated-input w-full rounded-lg px-4 py-2.5 text-sm">
                    </div>
                    <div class="input-group">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                               placeholder="cth: Jl. Sidoarjo"
                               class="animated-input w-full rounded-lg px-4 py-2.5 text-sm">
                    </div>
                </div>

                {{-- KOLOM KANAN: Info Invoice --}}
                <div class="form-card p-6 space-y-4 fade-up fade-up-2">
                    <h2 class="text-base font-bold text-gray-800 border-b border-gray-100 pb-3">
                        🧾 Info Invoice
                    </h2>
                    <div class="input-group">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Keterangan Invoice <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keterangan" rows="2"
                                placeholder="cth: Bersama ini kami sampaikan invoice biaya sewa server GPS Periode Februari 2026"
                                class="animated-input w-full rounded-lg px-4 py-2.5 text-sm resize-none">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class="input-group">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor Invoice</label>
                        <input type="text" name="invoice_no" value="{{ $invoiceNo }}" readonly
                               class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1">✨ Nomor generate otomatis</p>
                    </div>
                    <div class="input-group">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Tanggal Invoice <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                               class="animated-input w-full rounded-lg px-4 py-2.5 text-sm">
                    </div>
                    <div class="input-group">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Jatuh Tempo <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}"
                               class="animated-input w-full rounded-lg px-4 py-2.5 text-sm">
                    </div>
                    <div class="input-group">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Pembayaran ke Rekening <span class="text-red-500">*</span>
                        </label>
                        <select name="rekening" class="animated-input w-full rounded-lg px-4 py-2.5 text-sm">
                            <option value="joko">BCA — Joko Pitoyo (6720449321)</option>
                            <option value="lilis">BCA — Lilis Sugijanti (2710795471)</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ITEM INVOICE --}}
            <div class="form-card p-6 mt-6 fade-up fade-up-3">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-5">
                    <h2 class="text-base font-bold text-gray-800">📦 Item / Layanan</h2>
                    <button type="button" onclick="addItem()" class="btn-add">
                        + Tambah Item
                    </button>
                </div>

                {{-- Header kolom --}}
                <div class="hidden lg:grid grid-cols-12 gap-3 text-xs font-bold text-gray-400 uppercase mb-2 px-3">
                    <div class="col-span-4">Nama Layanan</div>
                    <div class="col-span-2 text-right">QTY</div>
                    <div class="col-span-2">Satuan</div>
                    <div class="col-span-2 text-right">Harga/Satuan</div>
                    <div class="col-span-1 text-right">Total</div>
                    <div class="col-span-1"></div>
                </div>

                <div id="itemsContainer" class="space-y-3">
                    @php $oldItems = old('items', [['nama'=>'','qty'=>'','satuan'=>'Unit','harga'=>'']]) @endphp
                    @foreach ($oldItems as $i => $item)
                        <div class="item-row grid grid-cols-12 gap-3 items-center">
                            <div class="col-span-12 lg:col-span-4">
                                <input type="text" name="items[{{ $i }}][nama]" value="{{ $item['nama'] }}"
                                       placeholder="cth: PAS Monitoring 1"
                                       class="animated-input w-full rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div class="col-span-6 lg:col-span-2">
                                <input type="number" name="items[{{ $i }}][qty]" value="{{ $item['qty'] }}"
                                       placeholder="0" min="0" step="any"
                                       class="qty-input animated-input w-full rounded-lg px-3 py-2 text-sm text-right"
                                       oninput="recalcRow(this)">
                            </div>
                            <div class="col-span-6 lg:col-span-2">
                                <input type="text" name="items[{{ $i }}][satuan]" value="{{ $item['satuan'] ?? 'Unit' }}"
                                       placeholder="Unit"
                                       class="animated-input w-full rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div class="col-span-6 lg:col-span-2">
                                <input type="number" name="items[{{ $i }}][harga]" value="{{ $item['harga'] }}"
                                       placeholder="0" min="0" step="any"
                                       class="harga-input animated-input w-full rounded-lg px-3 py-2 text-sm text-right"
                                       oninput="recalcRow(this)">
                            </div>
                            <div class="col-span-5 lg:col-span-1 text-right">
                                <span class="row-total text-sm font-bold text-gray-700">Rp 0</span>
                            </div>
                            <div class="col-span-1 flex justify-end">
                                <button type="button" onclick="removeItem(this)" class="btn-remove">🗑</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Grand Total --}}
                <div class="mt-5 flex justify-end">
                    <div class="total-box">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Grand Total</p>
                        <p id="grandTotal" class="total-amount">Rp 0</p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div class="mt-6 flex justify-end fade-up fade-up-4">
                <button type="submit" class="btn-submit" id="submitBtn">
                    ⬇️ Generate & Download PDF
                </button>
            </div>

        </form>
    </div>

    <script>
        let itemIndex = {{ count(old('items', [[]])) }};

        // ── FORMAT RUPIAH ──
        function formatRupiah(angka) {
            if (!angka || isNaN(angka)) return 'Rp 0';
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        // ── RECALC ROW ──
        function recalcRow(input) {
            const row   = input.closest('.item-row');
            const qty   = parseFloat(row.querySelector('.qty-input').value)   || 0;
            const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
            row.querySelector('.row-total').textContent = formatRupiah(qty * harga);
            recalcGrand();
        }

        // ── RECALC GRAND TOTAL dengan animasi bump ──
        function recalcGrand() {
            let grand = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const qty   = parseFloat(row.querySelector('.qty-input').value)   || 0;
                const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
                grand += qty * harga;
            });
            const el = document.getElementById('grandTotal');
            el.textContent = formatRupiah(grand);
            el.classList.add('bump');
            setTimeout(() => el.classList.remove('bump'), 400);
        }

        // ── TAMBAH ITEM ──
        function addItem() {
            const container = document.getElementById('itemsContainer');
            const div = document.createElement('div');
            div.className = 'item-row grid grid-cols-12 gap-3 items-center';
            div.innerHTML = `
                <div class="col-span-12 lg:col-span-4">
                    <input type="text" name="items[${itemIndex}][nama]" placeholder="cth: PAS Monitoring 2"
                           class="animated-input w-full rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="col-span-6 lg:col-span-2">
                    <input type="number" name="items[${itemIndex}][qty]" placeholder="0" min="0" step="any"
                           class="qty-input animated-input w-full rounded-lg px-3 py-2 text-sm text-right"
                           oninput="recalcRow(this)">
                </div>
                <div class="col-span-6 lg:col-span-2">
                    <input type="text" name="items[${itemIndex}][satuan]" placeholder="Unit" value="Unit"
                           class="animated-input w-full rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="col-span-6 lg:col-span-2">
                    <input type="number" name="items[${itemIndex}][harga]" placeholder="0" min="0" step="any"
                           class="harga-input animated-input w-full rounded-lg px-3 py-2 text-sm text-right"
                           oninput="recalcRow(this)">
                </div>
                <div class="col-span-5 lg:col-span-1 text-right">
                    <span class="row-total text-sm font-bold text-gray-700">Rp 0</span>
                </div>
                <div class="col-span-1 flex justify-end">
                    <button type="button" onclick="removeItem(this)" class="btn-remove">🗑</button>
                </div>
            `;
            container.appendChild(div);
            itemIndex++;
        }

        // ── HAPUS ITEM ──
        function removeItem(btn) {
            if (document.querySelectorAll('.item-row').length <= 1) {
                // Shake animasi kalau cuma 1 item
                const row = btn.closest('.item-row');
                row.style.animation = 'none';
                row.style.border = '1.5px solid #fca5a5';
                setTimeout(() => row.style.border = '1px solid transparent', 800);
                return;
            }
            const row = btn.closest('.item-row');
            row.style.transition = 'all 0.25s ease';
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            setTimeout(() => { row.remove(); recalcGrand(); }, 250);
        }

        // ── LOADING SAAT SUBMIT ──
        document.getElementById('invoiceForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').classList.add('show');
        });

        // ── PROGRESS BAR berdasarkan scroll ──
        window.addEventListener('scroll', () => {
            const scrollTop    = window.scrollY;
            const docHeight    = document.documentElement.scrollHeight - window.innerHeight;
            const scrolled     = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            document.getElementById('progressBar').style.width = scrolled + '%';
        });

        // ── HITUNG ULANG SAAT LOAD ──
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.qty-input').forEach(input => {
                if (input.value) recalcRow(input);
            });
        });
    </script>

</body>
</html>