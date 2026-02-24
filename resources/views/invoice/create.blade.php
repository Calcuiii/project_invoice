<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Invoice — Centra Telemedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- HEADER --}}
    <div class="bg-gray-900 shadow-lg">
        <div class="max-w-4xl mx-auto px-6 py-5 flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto">
            <div>
                <h1 class="text-white text-xl font-bold tracking-wide">CENTRA TELEMEDIA</h1>
                <p class="text-yellow-400 text-sm">Generator Invoice GPS Server</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-8">

        {{-- VALIDASI ERROR --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 rounded-xl p-4 mb-6">
                <p class="font-semibold text-red-700 mb-2">⚠️ Ada kesalahan input:</p>
                <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('invoice.generate') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- KOLOM KIRI: Info Penerima --}}
                <div class="bg-white rounded-2xl shadow p-6 space-y-4">
                    <h2 class="text-base font-bold text-gray-800 border-b pb-3">📋 Info Penerima</h2>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Kepada Yth. <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kepada" value="{{ old('kepada') }}"
                               placeholder="cth: Bpk Khoirul (PAS GPS)"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Username Customer <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" value="{{ old('username') }}"
                               placeholder="cth: PAS GPS"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                               placeholder="cth: Jl. Sidoarjo"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
                </div>

                {{-- KOLOM KANAN: Info Invoice --}}
                <div class="bg-white rounded-2xl shadow p-6 space-y-4">
                    <h2 class="text-base font-bold text-gray-800 border-b pb-3">🧾 Info Invoice</h2>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Keterangan Invoice <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keterangan" rows="2"
                                placeholder="cth: Bersama ini kami sampaikan invoice biaya sewa server GPS Periode Februari 2026"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 resize-none">{{ old('keterangan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Nomor Invoice <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="invoice_no" value="{{ old('invoice_no', date('Y/m/d')) }}"
                               placeholder="cth: 2026/02/08"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Tanggal Invoice <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Jatuh Tempo <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">
                            Pembayaran ke Rekening <span class="text-red-500">*</span>
                        </label>
                        <select name="rekening"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="joko">BCA — Joko Pitoyo (6720449321)</option>
                            <option value="lilis">BCA — Lilis Sugijanti (2710795471)</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ITEM INVOICE --}}
            <div class="bg-white rounded-2xl shadow p-6 mt-6">
                <div class="flex items-center justify-between border-b pb-3 mb-5">
                    <h2 class="text-base font-bold text-gray-800">📦 Item / Layanan</h2>
                    <button type="button" onclick="addItem()"
                            class="bg-gray-800 hover:bg-black text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        + Tambah Item
                    </button>
                </div>

                {{-- Header kolom --}}
                <div class="hidden lg:grid grid-cols-12 gap-3 text-xs font-bold text-gray-400 uppercase mb-2">
                    <div class="col-span-4">Nama Layanan</div>
                    <div class="col-span-2 text-right">QTY</div>
                    <div class="col-span-2">Satuan</div>
                    <div class="col-span-2 text-right">Harga/Satuan (Rp)</div>
                    <div class="col-span-1 text-right">Total</div>
                    <div class="col-span-1"></div>
                </div>

                <div id="itemsContainer" class="space-y-3">
                    @php $oldItems = old('items', [['nama'=>'','qty'=>'','satuan'=>'Unit','harga'=>'']]) @endphp
                    @foreach ($oldItems as $i => $item)
                        <div class="item-row grid grid-cols-12 gap-3 items-center bg-gray-50 rounded-xl p-3">
                            <div class="col-span-12 lg:col-span-4">
                                <input type="text" name="items[{{ $i }}][nama]" value="{{ $item['nama'] }}"
                                       placeholder="cth: PAS Monitoring 1"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            </div>
                            <div class="col-span-6 lg:col-span-2">
                                <input type="number" name="items[{{ $i }}][qty]" value="{{ $item['qty'] }}"
                                       placeholder="0" min="0" step="any"
                                       class="qty-input w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                       oninput="recalcRow(this)">
                            </div>
                            <div class="col-span-6 lg:col-span-2">
                                <input type="text" name="items[{{ $i }}][satuan]" value="{{ $item['satuan'] ?? 'Unit' }}"
                                       placeholder="Unit"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            </div>
                            <div class="col-span-6 lg:col-span-2">
                                <input type="number" name="items[{{ $i }}][harga]" value="{{ $item['harga'] }}"
                                       placeholder="0" min="0" step="any"
                                       class="harga-input w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                       oninput="recalcRow(this)">
                            </div>
                            <div class="col-span-5 lg:col-span-1 text-right">
                                <span class="row-total text-sm font-semibold text-gray-700">Rp 0</span>
                            </div>
                            <div class="col-span-1 flex justify-end">
                                <button type="button" onclick="removeItem(this)"
                                        class="text-red-400 hover:text-red-600 transition">
                                    🗑
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Grand Total --}}
                <div class="mt-5 flex justify-end">
                    <div class="bg-gray-900 text-white rounded-xl px-6 py-4 text-right min-w-52">
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Grand Total</p>
                        <p id="grandTotal" class="text-2xl font-bold text-yellow-400 mt-1">Rp 0</p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div class="mt-6 flex justify-end">
                <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold px-8 py-3.5 rounded-xl text-base transition shadow-lg">
                    ⬇️ Generate & Download PDF
                </button>
            </div>

        </form>
    </div>

    <script>
        let itemIndex = {{ count(old('items', [[]])) }};

        function formatRupiah(angka) {
            if (!angka || isNaN(angka)) return 'Rp 0';
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        function recalcRow(input) {
            const row   = input.closest('.item-row');
            const qty   = parseFloat(row.querySelector('.qty-input').value)   || 0;
            const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
            row.querySelector('.row-total').textContent = formatRupiah(qty * harga);
            recalcGrand();
        }

        function recalcGrand() {
            let grand = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const qty   = parseFloat(row.querySelector('.qty-input').value)   || 0;
                const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
                grand += qty * harga;
            });
            document.getElementById('grandTotal').textContent = formatRupiah(grand);
        }

        function addItem() {
            const container = document.getElementById('itemsContainer');
            const div = document.createElement('div');
            div.className = 'item-row grid grid-cols-12 gap-3 items-center bg-gray-50 rounded-xl p-3';
            div.innerHTML = `
                <div class="col-span-12 lg:col-span-4">
                    <input type="text" name="items[${itemIndex}][nama]" placeholder="cth: PAS Monitoring 2"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="col-span-6 lg:col-span-2">
                    <input type="number" name="items[${itemIndex}][qty]" placeholder="0" min="0" step="any"
                           class="qty-input w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           oninput="recalcRow(this)">
                </div>
                <div class="col-span-6 lg:col-span-2">
                    <input type="text" name="items[${itemIndex}][satuan]" placeholder="Unit" value="Unit"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="col-span-6 lg:col-span-2">
                    <input type="number" name="items[${itemIndex}][harga]" placeholder="0" min="0" step="any"
                           class="harga-input w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           oninput="recalcRow(this)">
                </div>
                <div class="col-span-5 lg:col-span-1 text-right">
                    <span class="row-total text-sm font-semibold text-gray-700">Rp 0</span>
                </div>
                <div class="col-span-1 flex justify-end">
                    <button type="button" onclick="removeItem(this)" class="text-red-400 hover:text-red-600">🗑</button>
                </div>
            `;
            container.appendChild(div);
            itemIndex++;
        }

        function removeItem(btn) {
            if (document.querySelectorAll('.item-row').length <= 1) {
                alert('Minimal harus ada 1 item!');
                return;
            }
            btn.closest('.item-row').remove();
            recalcGrand();
        }

        // Hitung ulang saat halaman load (untuk old() values setelah validasi gagal)
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.qty-input').forEach(input => {
                if (input.value) recalcRow(input);
            });
        });
    </script>

</body>
</html>