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

                {{-- Disclaimer Medis --}}
                <div style="margin-top:1rem; padding:0.75rem 1rem; background:linear-gradient(135deg,#fffbeb,#fef3c7); border:1px solid #fcd34d; border-radius:var(--radius-sm); font-size:0.8rem; color:#78350f; line-height:1.5;">
                    <i class="fas fa-circle-info" style="color:#d97706;"></i>
                    <strong>Catatan:</strong> Hasil perhitungan ini bersifat <strong>referensi umum</strong> dan tidak menggantikan konsultasi langsung dengan dokter atau ahli gizi terdaftar.
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

                {{-- Disclaimer Medis BMI --}}
                <div style="margin-top:1rem; padding:0.75rem 1rem; background:linear-gradient(135deg,#fffbeb,#fef3c7); border:1px solid #fcd34d; border-radius:var(--radius-sm); font-size:0.8rem; color:#78350f; line-height:1.5;">
                    <i class="fas fa-circle-info" style="color:#d97706;"></i>
                    <strong>Catatan:</strong> BMI adalah <strong>alat skrining</strong>, bukan diagnosis. Untuk anak, interpretasi tepat memerlukan pemantauan kurva pertumbuhan WHO oleh tenaga kesehatan.
                </div>
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
        // Usia anak hanya tampil untuk kategori 'anak'
        document.getElementById('bmi-age-group').style.display = cat === 'anak' ? 'block' : 'none';
        // Gender hanya relevan untuk anak (bumil selalu perempuan, dewasa tidak gender-specific pada BMI umum)
        document.getElementById('bmi-gender-group').style.display = cat === 'anak' ? 'block' : 'none';
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
        /**
         * Standar WHO 2006 (usia 0-5 thn) & WHO 2007 (usia 5-18 thn)
         * Ambang batas BMI-for-age: [-3SD, -2SD, +1SD, +2SD]
         * Kategori (Kemenkes PMK No.2/2020):
         *   < -3 SD  → Gizi Buruk
         *   -3 s/d -2 SD → Gizi Kurang
         *   -2 s/d +1 SD → Gizi Baik
         *   +1 s/d +2 SD → Risiko Gizi Lebih
         *   > +2 SD  → Gizi Lebih / Obesitas
         */
        const whoRef = {
            L: {
                 0: [11.5, 12.9, 16.0, 17.6],  1: [13.7, 15.0, 18.3, 19.7],
                 2: [13.3, 14.7, 18.1, 19.4],  3: [12.6, 13.9, 17.2, 18.5],
                 4: [12.1, 13.4, 16.7, 18.0],  5: [11.8, 13.1, 16.6, 17.9],
                 6: [11.7, 13.0, 16.7, 18.2],  7: [11.8, 13.1, 17.2, 19.0],
                 8: [11.9, 13.3, 18.0, 20.0],  9: [12.1, 13.6, 18.8, 21.1],
                10: [12.3, 13.9, 19.7, 22.4], 11: [12.6, 14.2, 20.6, 23.6],
                12: [13.0, 14.7, 21.5, 24.7], 13: [13.4, 15.2, 22.2, 25.6],
                14: [13.9, 15.8, 22.8, 26.3], 15: [14.4, 16.3, 23.3, 26.9],
                16: [14.8, 16.8, 23.7, 27.3], 17: [15.2, 17.2, 24.0, 27.6],
                18: [15.5, 17.5, 24.3, 27.8],
            },
            P: {
                 0: [11.1, 12.5, 15.7, 17.2],  1: [13.2, 14.5, 17.8, 19.2],
                 2: [13.0, 14.3, 17.7, 19.2],  3: [12.2, 13.5, 17.0, 18.4],
                 4: [11.8, 13.1, 16.7, 18.1],  5: [11.6, 12.9, 16.7, 18.2],
                 6: [11.6, 12.9, 17.0, 18.8],  7: [11.7, 13.0, 17.6, 19.7],
                 8: [11.8, 13.2, 18.3, 20.7],  9: [12.0, 13.5, 19.2, 21.9],
                10: [12.2, 13.8, 20.2, 23.2], 11: [12.6, 14.2, 21.2, 24.5],
                12: [13.1, 14.8, 22.1, 25.5], 13: [13.7, 15.4, 22.8, 26.3],
                14: [14.2, 16.0, 23.4, 26.9], 15: [14.6, 16.4, 23.8, 27.3],
                16: [14.9, 16.8, 24.2, 27.7], 17: [15.2, 17.0, 24.5, 27.9],
                18: [15.4, 17.2, 24.7, 28.1],
            }
        };

        const yr  = parseInt(document.getElementById('bmi-age-years').value)  || 0;
        const mo  = parseInt(document.getElementById('bmi-age-months').value) || 0;
        const g   = document.querySelector('input[name="bmi-gender"]:checked').value;
        const b   = Math.round(bmi * 10) / 10;
        const age = yr > 0 ? `${yr} tahun${mo > 0 ? ' ' + mo + ' bulan' : ''}` : `${mo} bulan`;
        const jk  = g === 'L' ? 'laki-laki' : 'perempuan';

        // Gunakan usia dalam tahun (max 18)
        const refAge = Math.min(Math.max(yr, 0), 18);
        const [sd3n, sd2n, sd1p, sd2p] = whoRef[g][refAge];

        // Catatan khusus untuk bayi < 2 tahun
        const infoBalita = yr < 2
            ? '<br><small style="opacity:0.85;">⚠️ <em>Untuk usia &lt; 2 tahun, indeks BB/PB lebih dianjurkan WHO. Pantau di Posyandu.</em></small>'
            : '';

        if (bmi < sd3n) return {
            status: 'Gizi Buruk',
            color: '#1e40af', bg: 'linear-gradient(135deg,#dbeafe,#93c5fd)', gaugePos: 5,
            interpretation: `🚨 <strong>Gizi Buruk</strong><br>Anak ${jk} usia ${age} dengan BMI ${b} (di bawah -3 SD WHO). Memerlukan penanganan segera.${infoBalita}`,
            tips: `<strong>💡 Tindakan Segera:</strong><br>• Segera rujuk ke Puskesmas / RS<br>• Pemberian makanan terapeutik (F-75/F-100)<br>• Pemantauan ketat oleh tenaga kesehatan<br>• Ikuti program Therapeutic Feeding Center`
        };
        if (bmi < sd2n) return {
            status: 'Gizi Kurang',
            color: '#2563eb', bg: 'linear-gradient(135deg,#dbeafe,#bfdbfe)', gaugePos: 15,
            interpretation: `⚠️ <strong>Gizi Kurang</strong><br>Anak ${jk} usia ${age} dengan BMI ${b} (antara -3 SD dan -2 SD WHO). Berisiko <strong>stunting</strong>.${infoBalita}`,
            tips: `<strong>💡 Saran:</strong><br>• Segera ke Posyandu / Puskesmas<br>• Makanan tinggi protein dan energi<br>• Makan 3× utama + 2× camilan sehat<br>• Ikuti prinsip "Isi Piringku"<br>• Pantau BB/TB setiap bulan`
        };
        if (bmi < sd1p) return {
            status: 'Gizi Baik (Normal)',
            color: '#059669', bg: 'linear-gradient(135deg,#d1fae5,#a7f3d0)', gaugePos: 35,
            interpretation: `✅ <strong>Gizi Baik</strong><br>Anak ${jk} usia ${age} dengan BMI ${b} (antara -2 SD dan +1 SD WHO). Tumbuh kembang normal.${infoBalita}`,
            tips: `<strong>💡 Tips:</strong><br>• Pertahankan pola makan "Isi Piringku"<br>• ASI eksklusif / MPASI sesuai usia<br>• Imunisasi lengkap sesuai jadwal<br>• Stimulasi tumbuh kembang<br>• Pantau pertumbuhan rutin di Posyandu`
        };
        if (bmi < sd2p) return {
            status: 'Risiko Gizi Lebih',
            color: '#d97706', bg: 'linear-gradient(135deg,#fef3c7,#fde68a)', gaugePos: 60,
            interpretation: `⚡ <strong>Risiko Gizi Lebih</strong><br>Anak ${jk} usia ${age} dengan BMI ${b} (antara +1 SD dan +2 SD WHO). Perlu perhatian khusus.${infoBalita}`,
            tips: `<strong>💡 Saran:</strong><br>• Kurangi makanan manis dan gorengan<br>• Perbanyak sayur dan buah segar<br>• Ajak bermain aktif / olahraga rutin<br>• Batasi screen time (maks 2 jam/hari)<br>• Konsultasi ke Puskesmas`
        };
        return {
            status: 'Gizi Lebih / Obesitas',
            color: '#dc2626', bg: 'linear-gradient(135deg,#fecaca,#fca5a5)', gaugePos: 85,
            interpretation: `🚨 <strong>Gizi Lebih / Obesitas</strong><br>Anak ${jk} usia ${age} dengan BMI ${b} (di atas +2 SD WHO). Risiko penyakit metabolik dini.${infoBalita}`,
            tips: `<strong>💡 Saran Penting:</strong><br>• Konsultasi ke dokter anak / ahli gizi<br>• Ubah pola makan seluruh keluarga<br>• Tingkatkan aktivitas fisik bertahap<br>• Hindari minuman manis dan ultra-proses<br>• Utamakan makanan rumahan bergizi`
        };
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
