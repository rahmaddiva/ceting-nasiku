@extends('layouts.public')
@section('title', 'Kalkulator Gizi & BMI')

@section('content')
<section class="calculator-section">
    <div class="container" style="padding-top: 4rem;">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-calculator"></i> Kalkulator</div>
            <h2>Kalkulator <span>Cek Gizi</span></h2>
            <p>Pilih bahan makanan dan jumlahnya untuk menghitung kandungan gizi secara otomatis</p>
        </div>

        <div class="calculator-container">
            <!-- Form -->
            <div class="calculator-form">
                <h3 style="margin-bottom: 1.5rem;"><i class="fas fa-plus-circle" style="color: var(--primary-600);"></i> Tambahkan Bahan</h3>

                <div id="ingredient-rows">
                    <div class="ingredient-row" data-index="0">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Bahan Makanan</label>
                            <select class="form-control ingredient-select" name="ingredient" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" data-unit="{{ $ingredient->unit }}">{{ $ingredient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Jumlah (gram)</label>
                            <input type="number" class="form-control ingredient-qty" placeholder="100" min="1" step="0.1" value="100">
                        </div>
                        <button type="button" class="btn-remove" onclick="removeRow(this)" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="button" class="btn btn-outline" onclick="addRow()" style="flex: 1;">
                        <i class="fas fa-plus"></i> Tambah Bahan
                    </button>
                    <button type="button" class="btn btn-primary" onclick="calculateNutrition()" style="flex: 1;">
                        <i class="fas fa-calculator"></i> Hitung Gizi
                    </button>
                </div>
            </div>

            <!-- Results -->
            <div class="calculator-results">
                <h3 style="margin-bottom: 1.5rem;"><i class="fas fa-chart-pie" style="color: var(--primary-600);"></i> Hasil Perhitungan</h3>

                <div id="results-placeholder" style="text-align: center; padding: 3rem 0; color: var(--text-muted);">
                    <i class="fas fa-arrow-left" style="font-size: 2rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                    <p>Pilih bahan makanan dan klik <strong>"Hitung Gizi"</strong> untuk melihat hasil</p>
                </div>

                <div id="results-content" style="display: none;">
                    <div id="results-items"></div>
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid var(--gray-200);">
                        <h4 style="margin-bottom: 1rem; color: var(--primary-700);"><i class="fas fa-sigma"></i> Total Nutrisi</h4>
                        <div id="results-totals"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- KALKULATOR BMI --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="calculator-section" style="padding-top: 0;">
    <div class="container">
        <div class="section-header">
            <div class="section-badge" style="background: linear-gradient(135deg, #059669, #10b981); color: #fff;">
                <i class="fas fa-weight-scale"></i> BMI
            </div>
            <h2>Kalkulator <span>Indeks Massa Tubuh</span></h2>
            <p>Hitung BMI untuk mengetahui status gizi berdasarkan berat dan tinggi badan</p>

            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1.5rem; margin-top: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.2rem; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-radius: 50px; font-size: 0.9rem; font-weight: 600; color: #065f46;">
                    <i class="fas fa-circle-check" style="color: #059669; font-size: 1.1rem;"></i> Menghitung berat badan
                </div>
                <div style="display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.2rem; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-radius: 50px; font-size: 0.9rem; font-weight: 600; color: #065f46;">
                    <i class="fas fa-circle-check" style="color: #059669; font-size: 1.1rem;"></i> Menentukan kategori berat badan ideal atau tidak
                </div>
                <div style="display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.2rem; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-radius: 50px; font-size: 0.9rem; font-weight: 600; color: #065f46;">
                    <i class="fas fa-circle-check" style="color: #059669; font-size: 1.1rem;"></i> Mempersiapkan program penurunan berat badan
                </div>
            </div>
        </div>

        <div class="calculator-container">
            <!-- BMI Form -->
            <div class="calculator-form">
                <h3 style="margin-bottom: 1.5rem;"><i class="fas fa-user" style="color: #059669;"></i> Data Diri</h3>

                <div class="form-group">
                    <label><i class="fas fa-users" style="color: #059669;"></i> Kategori Usia</label>
                    <select class="form-control" id="bmi-category" onchange="toggleBmiFields()">
                        <option value="anak">Anak (0–18 tahun)</option>
                        <option value="dewasa">Dewasa (>18 tahun)</option>
                        <option value="bumil">Ibu Hamil</option>
                    </select>
                </div>

                <div class="form-group" id="bmi-age-group">
                    <label><i class="fas fa-cake-candles" style="color: #059669;"></i> Usia Anak</label>
                    <div style="display: flex; gap: 0.75rem;">
                        <div style="flex: 1;">
                            <input type="number" class="form-control" id="bmi-age-years" placeholder="Tahun" min="0" max="18" value="2">
                            <small style="color: var(--text-muted); font-size: 0.75rem;">Tahun</small>
                        </div>
                        <div style="flex: 1;">
                            <input type="number" class="form-control" id="bmi-age-months" placeholder="Bulan" min="0" max="11" value="0">
                            <small style="color: var(--text-muted); font-size: 0.75rem;">Bulan</small>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="bmi-gender-group">
                    <label><i class="fas fa-venus-mars" style="color: #059669;"></i> Jenis Kelamin</label>
                    <div style="display: flex; gap: 0.75rem;">
                        <label class="bmi-radio-label" style="flex:1; display:flex; align-items:center; gap:0.5rem; padding:0.65rem 1rem; border:2px solid var(--gray-200); border-radius:var(--radius-sm); cursor:pointer;">
                            <input type="radio" name="bmi-gender" value="L" checked style="accent-color:#059669;"> <i class="fas fa-mars" style="color:#3b82f6;"></i> Laki-laki
                        </label>
                        <label class="bmi-radio-label" style="flex:1; display:flex; align-items:center; gap:0.5rem; padding:0.65rem 1rem; border:2px solid var(--gray-200); border-radius:var(--radius-sm); cursor:pointer;">
                            <input type="radio" name="bmi-gender" value="P" style="accent-color:#059669;"> <i class="fas fa-venus" style="color:#ec4899;"></i> Perempuan
                        </label>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label><i class="fas fa-weight-scale" style="color: #059669;"></i> Berat Badan (kg)</label>
                        <input type="number" class="form-control" id="bmi-weight" placeholder="12" min="1" max="300" step="0.1">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label><i class="fas fa-ruler-vertical" style="color: #059669;"></i> Tinggi Badan (cm)</label>
                        <input type="number" class="form-control" id="bmi-height" placeholder="85" min="30" max="250" step="0.1">
                    </div>
                </div>

                <button type="button" class="btn btn-primary" onclick="calculateBMI()" style="width: 100%; margin-top: 1.5rem; background: linear-gradient(135deg, #059669, #10b981);">
                    <i class="fas fa-calculator"></i> Hitung BMI
                </button>
            </div>

            <!-- BMI Results -->
            <div class="calculator-results">
                <h3 style="margin-bottom: 1.5rem;"><i class="fas fa-heartbeat" style="color: #059669;"></i> Hasil BMI</h3>

                <div id="bmi-placeholder" style="text-align: center; padding: 3rem 0; color: var(--text-muted);">
                    <i class="fas fa-weight-scale" style="font-size: 2rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                    <p>Masukkan data diri dan klik <strong>"Hitung BMI"</strong> untuk melihat hasil</p>
                </div>

                <div id="bmi-result" style="display: none;">
                    <!-- Score Card -->
                    <div id="bmi-score-card" style="text-align: center; padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 1.5rem;">
                        <div style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; margin-bottom: 0.25rem;" id="bmi-result-label">Indeks Massa Tubuh</div>
                        <div style="font-size: 3rem; font-weight: 800; line-height: 1;" id="bmi-score-value">0.0</div>
                        <div style="font-size: 1.1rem; font-weight: 600; margin-top: 0.5rem;" id="bmi-status-text">-</div>
                    </div>

                    <!-- Gauge -->
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; height: 10px; border-radius: 5px; overflow: hidden; margin-bottom: 0.5rem;">
                            <div style="flex: 18.5; background: #3b82f6;"></div>
                            <div style="flex: 6.5; background: #10b981;"></div>
                            <div style="flex: 5; background: #f59e0b;"></div>
                            <div style="flex: 10; background: #ef4444;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.7rem; color: var(--text-muted);">
                            <span>Kurus</span><span>Normal</span><span>Gemuk</span><span>Obesitas</span>
                        </div>
                        <div style="position: relative; height: 20px; margin-top: -2px;">
                            <div id="bmi-gauge-marker" style="position: absolute; left: 50%; transform: translateX(-50%); transition: left 0.6s ease;">
                                <i class="fas fa-caret-up" style="font-size: 1rem; color: var(--gray-800);"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Interpretation & Tips -->
                    <div id="bmi-interpretation" style="padding: 1rem 1.25rem; border-radius: var(--radius-sm); margin-bottom: 1rem; font-size: 0.9rem; line-height: 1.6;"></div>
                    <div id="bmi-tips" style="padding: 1rem 1.25rem; background: var(--gray-50); border-radius: var(--radius-sm); font-size: 0.85rem;"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    /* ═══════ NUTRITION CALCULATOR ═══════ */
    let rowIndex = 1;

    function addRow() {
        const container = document.getElementById('ingredient-rows');
        const template = container.querySelector('.ingredient-row').cloneNode(true);
        template.dataset.index = rowIndex++;
        template.querySelector('.ingredient-select').value = '';
        template.querySelector('.ingredient-qty').value = '100';
        container.appendChild(template);
    }

    function removeRow(btn) {
        const rows = document.querySelectorAll('.ingredient-row');
        if (rows.length > 1) btn.closest('.ingredient-row').remove();
    }

    async function calculateNutrition() {
        const rows = document.querySelectorAll('.ingredient-row');
        const items = [];
        rows.forEach(row => {
            const id = row.querySelector('.ingredient-select').value;
            const qty = row.querySelector('.ingredient-qty').value;
            if (id && qty) items.push({ ingredient_id: parseInt(id), quantity: parseFloat(qty) });
        });
        if (items.length === 0) { alert('Silakan pilih minimal satu bahan makanan!'); return; }
        try {
            const res = await fetch('/kalkulator/hitung', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                body: JSON.stringify({ items }),
            });
            displayResults(await res.json());
        } catch (e) { console.error(e); alert('Terjadi kesalahan.'); }
    }

    function displayResults(data) {
        document.getElementById('results-placeholder').style.display = 'none';
        document.getElementById('results-content').style.display = 'block';
        let html = '';
        data.items.forEach(item => {
            html += `<div style="padding:.75rem;background:var(--gray-50);border-radius:var(--radius-sm);margin-bottom:.5rem">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <strong style="color:var(--gray-700)">${item.name}</strong>
                    <span style="font-size:.85rem;color:var(--primary-600);font-weight:600">${item.quantity} ${item.unit}</span>
                </div>
                <div style="font-size:.8rem;color:var(--text-muted);margin-top:.25rem">
                    ${item.nutrition.calories} kkal | ${item.nutrition.protein}g protein | ${item.nutrition.fat}g lemak | ${item.nutrition.carbohydrates}g karbo
                </div></div>`;
        });
        document.getElementById('results-items').innerHTML = html;

        const labels = {
            calories:{label:'Kalori',unit:'kkal',icon:'🔥'},protein:{label:'Protein',unit:'g',icon:'🥩'},
            fat:{label:'Lemak',unit:'g',icon:'🧈'},carbohydrates:{label:'Karbohidrat',unit:'g',icon:'🌾'},
            fiber:{label:'Serat',unit:'g',icon:'🥬'},calcium:{label:'Kalsium',unit:'mg',icon:'🦴'},
            iron:{label:'Zat Besi',unit:'mg',icon:'🔴'},vitamin_a:{label:'Vitamin A',unit:'mcg',icon:'👁️'},
            vitamin_c:{label:'Vitamin C',unit:'mg',icon:'🍊'},
        };
        let t = '';
        for (const [k,m] of Object.entries(labels)) {
            t += `<div class="nutrition-item"><span class="nutrition-label">${m.icon} ${m.label}</span><span class="nutrition-value">${data.totals[k]} ${m.unit}</span></div>`;
        }
        document.getElementById('results-totals').innerHTML = t;
    }

    /* ═══════ BMI CALCULATOR ═══════ */
    function toggleBmiFields() {
        const cat = document.getElementById('bmi-category').value;
        document.getElementById('bmi-age-group').style.display = cat === 'anak' ? 'block' : 'none';
        document.getElementById('bmi-gender-group').style.display = cat !== 'dewasa' ? 'block' : 'none';
    }

    function calculateBMI() {
        const w = parseFloat(document.getElementById('bmi-weight').value);
        const h = parseFloat(document.getElementById('bmi-height').value);
        const cat = document.getElementById('bmi-category').value;
        if (!w || !h || w <= 0 || h <= 0) { alert('Silakan masukkan berat dan tinggi badan yang valid!'); return; }
        const bmi = w / ((h/100) * (h/100));
        const bmiR = Math.round(bmi * 10) / 10;
        let result = cat === 'anak' ? interpretChildBMI(bmi) : cat === 'bumil' ? interpretPregnantBMI(bmi) : interpretAdultBMI(bmi);
        displayBMIResult(bmiR, result);
    }

    function interpretAdultBMI(bmi) {
        if (bmi < 17) return { status:'Kurus Berat', color:'#1d4ed8', bg:'linear-gradient(135deg,#dbeafe,#bfdbfe)', gaugePos:5,
            interpretation:'⚠️ <strong>Berat Badan Kurang (Berat)</strong><br>BMI Anda menunjukkan kekurangan gizi serius. Berisiko gangguan imunitas, anemia, dan masalah kesehatan lainnya.',
            tips:'<strong>💡 Saran:</strong><br>• Segera konsultasi ke dokter/ahli gizi<br>• Tingkatkan asupan kalori bertahap<br>• Makan tinggi protein dan lemak sehat<br>• Makan 5-6x sehari porsi kecil' };
        if (bmi < 18.5) return { status:'Kurus Ringan', color:'#2563eb', bg:'linear-gradient(135deg,#dbeafe,#bfdbfe)', gaugePos:15,
            interpretation:'📉 <strong>Berat Badan Kurang (Ringan)</strong><br>BMI sedikit di bawah normal. Bisa memengaruhi daya tahan tubuh dan energi.',
            tips:'<strong>💡 Saran:</strong><br>• Tingkatkan porsi makanan bergizi<br>• Perbanyak protein (telur, ikan, daging, tempe)<br>• Camilan sehat antara waktu makan<br>• Olahraga ringan untuk nafsu makan' };
        if (bmi < 25) return { status:'Normal', color:'#059669', bg:'linear-gradient(135deg,#d1fae5,#a7f3d0)', gaugePos:25+((bmi-18.5)/6.5)*12,
            interpretation:'✅ <strong>Berat Badan Normal</strong><br>Selamat! BMI Anda dalam rentang normal. Pertahankan pola makan seimbang.',
            tips:'<strong>💡 Tips Menjaga:</strong><br>• Pertahankan pola makan "Isi Piringku"<br>• Olahraga teratur 30 menit/hari<br>• Minum air 8 gelas/hari<br>• Tidur cukup 7-8 jam/malam' };
        if (bmi < 27) return { status:'Gemuk Ringan', color:'#d97706', bg:'linear-gradient(135deg,#fef3c7,#fde68a)', gaugePos:55,
            interpretation:'⚡ <strong>Berat Badan Berlebih (Pre-Obesitas)</strong><br>BMI sedikit di atas normal. Meningkatkan risiko penyakit degeneratif.',
            tips:'<strong>💡 Saran:</strong><br>• Kurangi makanan tinggi gula dan lemak<br>• Perbanyak sayur dan buah<br>• Olahraga cardio 30-45 menit, 4-5x/minggu<br>• Kurangi porsi karbohidrat berlebih' };
        if (bmi < 30) return { status:'Gemuk Berat', color:'#ea580c', bg:'linear-gradient(135deg,#fed7aa,#fdba74)', gaugePos:65,
            interpretation:'⚠️ <strong>Kelebihan Berat Badan</strong><br>BMI menunjukkan BB berlebih signifikan. Perlu perubahan pola hidup.',
            tips:'<strong>💡 Saran:</strong><br>• Konsultasi ke ahli gizi<br>• Kurangi makanan olahan dan fast food<br>• Olahraga rutin cardio + kekuatan<br>• Perbanyak serat dari sayur dan buah' };
        return { status:'Obesitas', color:'#dc2626', bg:'linear-gradient(135deg,#fecaca,#fca5a5)', gaugePos:85,
            interpretation:'🚨 <strong>Obesitas</strong><br>Risiko tinggi diabetes, hipertensi, penyakit jantung, dan stroke.',
            tips:'<strong>💡 Saran Penting:</strong><br>• Segera konsultasi ke dokter<br>• Program diet terstruktur dengan ahli gizi<br>• Aktivitas fisik bertahap<br>• Periksa gula darah dan tekanan darah rutin' };
    }

    function interpretChildBMI(bmi) {
        const yr = parseInt(document.getElementById('bmi-age-years').value)||0;
        const mo = parseInt(document.getElementById('bmi-age-months').value)||0;
        const tot = yr*12+mo;
        const g = document.querySelector('input[name="bmi-gender"]:checked').value;
        let uw,nw,ow;
        if (tot<=24)      { uw=g==='L'?14.5:14.0; nw=g==='L'?18.5:18.0; ow=g==='L'?19.5:19.0; }
        else if (tot<=60)  { uw=g==='L'?14.0:13.5; nw=g==='L'?17.0:17.0; ow=g==='L'?18.0:18.0; }
        else if (tot<=120) { uw=g==='L'?13.5:13.0; nw=g==='L'?18.5:18.5; ow=g==='L'?20.0:20.0; }
        else               { uw=g==='L'?14.5:14.5; nw=g==='L'?23.0:23.0; ow=g==='L'?25.0:25.0; }
        const age = yr>0 ? `${yr} tahun${mo>0?' '+mo+' bulan':''}` : `${mo} bulan`;
        const jk = g==='L'?'laki-laki':'perempuan';
        const b = Math.round(bmi*10)/10;

        if (bmi<uw) return { status:'Gizi Kurang', color:'#2563eb', bg:'linear-gradient(135deg,#dbeafe,#bfdbfe)', gaugePos:10,
            interpretation:`⚠️ <strong>Gizi Kurang</strong><br>Anak ${jk} usia ${age} dengan BMI ${b} menunjukkan gizi kurang. Berisiko <strong>stunting</strong>.`,
            tips:`<strong>💡 Saran:</strong><br>• Segera ke Posyandu/Puskesmas<br>• Makanan tinggi protein dan energi<br>• Makan 3x utama + 2x camilan sehat<br>• Ikuti prinsip "Isi Piringku"<br>• Pantau BB setiap bulan` };
        if (bmi<nw) return { status:'Gizi Baik (Normal)', color:'#059669', bg:'linear-gradient(135deg,#d1fae5,#a7f3d0)', gaugePos:30,
            interpretation:`✅ <strong>Gizi Baik</strong><br>Anak ${jk} usia ${age} dengan BMI ${b} menunjukkan gizi baik. Tumbuh kembang normal.`,
            tips:`<strong>💡 Tips:</strong><br>• Pertahankan pola makan "Isi Piringku"<br>• ASI eksklusif / MPASI sesuai usia<br>• Imunisasi lengkap<br>• Stimulasi tumbuh kembang<br>• Pantau pertumbuhan rutin` };
        if (bmi<ow) return { status:'Risiko Gizi Lebih', color:'#d97706', bg:'linear-gradient(135deg,#fef3c7,#fde68a)', gaugePos:60,
            interpretation:`⚡ <strong>Risiko Gizi Lebih</strong><br>Anak ${jk} usia ${age} dengan BMI ${b} menunjukkan risiko gizi lebih.`,
            tips:`<strong>💡 Saran:</strong><br>• Kurangi makanan manis dan gorengan<br>• Perbanyak sayur dan buah<br>• Ajak bermain aktif / olahraga<br>• Batasi screen time (max 2 jam/hari)` };
        return { status:'Obesitas Anak', color:'#dc2626', bg:'linear-gradient(135deg,#fecaca,#fca5a5)', gaugePos:85,
            interpretation:`🚨 <strong>Obesitas</strong><br>Anak ${jk} usia ${age} dengan BMI ${b}. Risiko diabetes dan gangguan metabolik dini.`,
            tips:`<strong>💡 Saran Penting:</strong><br>• Konsultasi ke dokter anak<br>• Ubah pola makan keluarga<br>• Tingkatkan aktivitas fisik<br>• Hindari minuman manis<br>• Makanan rumahan bergizi seimbang` };
    }

    function interpretPregnantBMI(bmi) {
        if (bmi<18.5) return { status:'BB Kurang (Bumil)', color:'#2563eb', bg:'linear-gradient(135deg,#dbeafe,#bfdbfe)', gaugePos:10,
            interpretation:'⚠️ <strong>BB Kurang untuk Ibu Hamil</strong><br>Risiko bayi BBLR dan stunting meningkat.',
            tips:'<strong>💡 Saran:</strong><br>• Kenaikan BB ideal: 12,5–18 kg<br>• Makan 3x + 2-3x camilan bergizi<br>• Suplemen zat besi dan asam folat<br>• Makanan tinggi protein dan kalsium<br>• Rutin ANC sesuai jadwal' };
        if (bmi<25) return { status:'Normal (Bumil)', color:'#059669', bg:'linear-gradient(135deg,#d1fae5,#a7f3d0)', gaugePos:30,
            interpretation:'✅ <strong>BMI Normal untuk Ibu Hamil</strong><br>Status gizi baik. Pertahankan untuk pertumbuhan janin optimal.',
            tips:'<strong>💡 Tips:</strong><br>• Kenaikan BB ideal: 11,5–16 kg<br>• Ikuti "Isi Piringku" untuk bumil<br>• Suplemen Fe + asam folat<br>• Makanan tinggi kalsium<br>• Rutin ANC minimal 6x' };
        if (bmi<30) return { status:'BB Lebih (Bumil)', color:'#d97706', bg:'linear-gradient(135deg,#fef3c7,#fde68a)', gaugePos:60,
            interpretation:'⚡ <strong>BB Berlebih untuk Ibu Hamil</strong><br>Risiko preeklampsia dan diabetes gestasional meningkat.',
            tips:'<strong>💡 Saran:</strong><br>• Kenaikan BB ideal: 7–11,5 kg<br>• Kurangi makanan manis dan berlemak<br>• Perbanyak sayur, buah, protein sehat<br>• Jalan kaki 30 menit/hari<br>• Periksa gula darah dan TD rutin' };
        return { status:'Obesitas (Bumil)', color:'#dc2626', bg:'linear-gradient(135deg,#fecaca,#fca5a5)', gaugePos:85,
            interpretation:'🚨 <strong>Obesitas pada Ibu Hamil</strong><br>Risiko tinggi komplikasi kehamilan.',
            tips:'<strong>💡 Saran Penting:</strong><br>• Kenaikan BB ideal: 5–9 kg saja<br>• Konsultasi intensif dokter kandungan<br>• Diet khusus dari ahli gizi<br>• Monitor gula darah dan TD ketat<br>• Aktivitas ringan sesuai kondisi' };
    }

    function displayBMIResult(bmi, r) {
        document.getElementById('bmi-placeholder').style.display = 'none';
        document.getElementById('bmi-result').style.display = 'block';
        const card = document.getElementById('bmi-score-card');
        card.style.background = r.bg; card.style.color = r.color;
        document.getElementById('bmi-score-value').textContent = bmi;
        document.getElementById('bmi-status-text').textContent = r.status;
        document.getElementById('bmi-gauge-marker').style.left = Math.max(2,Math.min(98,r.gaugePos)) + '%';
        const interp = document.getElementById('bmi-interpretation');
        interp.style.background = r.bg; interp.style.borderLeft = `4px solid ${r.color}`;
        interp.innerHTML = r.interpretation;
        document.getElementById('bmi-tips').innerHTML = r.tips;
        document.getElementById('bmi-result').scrollIntoView({ behavior:'smooth', block:'center' });
    }
</script>
@endpush
