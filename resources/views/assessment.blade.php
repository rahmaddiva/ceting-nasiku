@extends('layouts.public')
@section('body_class', 'page-inner')
@section('title', 'Cek Risiko Stunting — Self Assessment — CETING NASIKU')
@section('meta_description', 'Evaluasi mandiri risiko stunting pada anak Anda melalui kuis singkat seputar pola asuh, gizi, dan kebersihan lingkungan keluarga.')
@section('og_title', 'Cek Risiko Stunting — Self Assessment — CETING NASIKU')
@section('og_description', 'Evaluasi mandiri risiko stunting pada anak Anda melalui kuis singkat seputar pola asuh, gizi, dan kebersihan lingkungan keluarga.')
@section('og_type', 'article')

@section('content')
<!-- Hero -->
<section class="edu-hero edu-hero--compact" style="min-height: 40vh;">
    <div class="edu-hero__bg">
        <img src="{{ asset('images/cek-risiko-hero.png') }}" alt="Ibu mengisi asesmen kesehatan anak" style="object-position: center 30%;">
        <div class="edu-hero__overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="section-badge section-badge-hero" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4);">
            <i class="fas fa-clipboard-list"></i> Self-Assessment
        </div>
        <h1>Cek Risiko <span>Stunting</span></h1>
        <p>Jawab 10 pertanyaan singkat ini untuk mengetahui perkiraan tingkat risiko stunting pada anak Anda berdasarkan kebiasaan sehari-hari.</p>
    </div>
</section>

<!-- Assessment App -->
<section class="section">
    <div class="container" style="max-width: 800px;">

        <!-- Quiz Container -->
        <div id="quizContainer" class="assessment-card">
            <div class="assessment-header">
                <div>
                    <h3 id="questionTitle" class="assessment-title">Pertanyaan 1</h3>
                    <div class="assessment-progress-text"><span id="currentQText">1</span> dari <span id="totalQText">10</span></div>
                </div>
                <div class="assessment-progress-bar">
                    <div id="progressBar" class="assessment-progress-fill" style="width: 10%;"></div>
                </div>
            </div>

            <div class="assessment-body">
                <p id="questionText" class="assessment-question-text">Loading...</p>

                <div id="optionsContainer" class="assessment-options">
                    <!-- Options injected via JS -->
                </div>
            </div>

            <div class="assessment-footer">
                <button id="btnPrev" class="btn btn-outline" style="visibility: hidden;">
                    <i class="fas fa-arrow-left"></i> Sebelumnya
                </button>
                <div style="flex-grow: 1;"></div>
                <button id="btnNext" class="btn btn-primary" disabled>
                    Selanjutnya <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Result Container -->
        <div id="resultContainer" class="assessment-card" style="display: none; text-align: center; padding: 3rem 2rem;">
            <div id="resultIcon" class="assessment-result-icon">
                <i class="fas fa-shield-cat"></i>
            </div>
            <h2 id="resultTitle" style="margin-bottom: 0.5rem; font-size: 2rem;">Risiko Rendah</h2>
            <p id="resultDesc" style="color: var(--text-secondary); margin-bottom: 2rem; font-size: 1.1rem; max-width: 600px; margin-left: auto; margin-right: auto;">Pola asuh dan kebiasaan keluarga Anda sudah sangat baik dalam mencegah stunting.</p>

            <div id="resultAlert" class="assessment-result-alert">
                <!-- Recommendations based on wrong answers -->
            </div>

            <div class="assessment-actions" style="margin-top: 2.5rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <button id="btnRestart" class="btn btn-outline"><i class="fas fa-redo"></i> Ulangi Tes</button>
                <a href="/edukasi/pola-asuh" class="btn btn-accent"><i class="fas fa-book-open"></i> Pelajari Pola Asuh</a>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // --- Data Kuis ---
        const quizData = [{
                id: 1,
                question: "Apakah Ibu memberikan ASI eksklusif (hanya ASI tanpa makanan/minuman lain) selama 6 bulan pertama kehidupan anak?",
                category: "Gizi & ASI",
                options: [{
                        text: "Ya, saya memberikan ASI eksklusif",
                        score: 0
                    },
                    {
                        text: "Tidak, saya memberikan susu formula atau makanan lain sebelum 6 bulan",
                        score: 2
                    }
                ]
            },
            {
                id: 2,
                question: "Kapan Anda mulai memberikan Makanan Pendamping ASI (MPASI) kepada anak?",
                category: "MPASI",
                options: [{
                        text: "Tepat pada usia 6 bulan",
                        score: 0
                    },
                    {
                        text: "Sebelum usia 6 bulan",
                        score: 1
                    },
                    {
                        text: "Setelah usia 6 bulan berlalu cukup lama",
                        score: 1
                    }
                ]
            },
            {
                id: 3,
                question: "Apakah menu harian anak Anda selalu mengandung protein hewani (seperti telur, ikan, hati ayam, daging)?",
                category: "Gizi",
                options: [{
                        text: "Ya, hampir setiap kali makan ada protein hewani",
                        score: 0
                    },
                    {
                        text: "Kadang-kadang saja (1-2 kali seminggu)",
                        score: 1
                    },
                    {
                        text: "Tidak, anak saya jarang/tidak pernah makan protein hewani",
                        score: 2
                    }
                ]
            },
            {
                id: 4,
                question: "Apakah anak Anda selalu mencuci tangan dengan sabun dan air mengalir sebelum makan?",
                category: "PHBS",
                options: [{
                        text: "Ya, selalu dibiasakan cuci tangan pakai sabun",
                        score: 0
                    },
                    {
                        text: "Kadang-kadang, sering lupa",
                        score: 1
                    },
                    {
                        text: "Tidak, biasanya hanya dibilas air atau dilengser lap",
                        score: 2
                    }
                ]
            },
            {
                id: 5,
                question: "Apakah keluarga Anda memiliki dan menggunakan jamban sehat (toilet/WC) di dalam rumah?",
                category: "Sanitasi",
                options: [{
                        text: "Ya, menggunakan jamban sehat milik sendiri",
                        score: 0
                    },
                    {
                        text: "Menggunakan jamban umum/bersama",
                        score: 1
                    },
                    {
                        text: "Tidak, keluarga masih BAB sembarangan (di sungai, kebun, dll)",
                        score: 2
                    }
                ]
            },
            {
                id: 6,
                question: "Seberapa sering Anda memberikan makanan atau minuman manis kemasan/snack pabrikan kepada anak?",
                category: "Gizi",
                options: [{
                        text: "Sama sekali tidak atau sangat jarang (1-2 kali sebulan)",
                        score: 0
                    },
                    {
                        text: "Kadang-kadang (1-2 kali seminggu)",
                        score: 1
                    },
                    {
                        text: "Setiap hari anak makan snack kemasan / makanan manis",
                        score: 2
                    }
                ]
            },
            {
                id: 7,
                question: "Apakah keluarga Anda merebus air minum hingga mendidih sebelum dikonsumsi?",
                category: "Sanitasi",
                options: [{
                        text: "Ya, selalu dimasak hingga mendidih atau minum dari galon bersegel",
                        score: 0
                    },
                    {
                        text: "Kadang-kadang airnya tidak sampai mendidih betul",
                        score: 1
                    },
                    {
                        text: "Tidak, keluarga minum air mentah langsung",
                        score: 2
                    }
                ]
            },
            {
                id: 8,
                question: "Selama masa kehamilan, apakah Ibu rutin mengonsumsi Tablet Tambah Darah (Fe) minimal 90 butir?",
                category: "Kesehatan Ibu",
                options: [{
                        text: "Ya, saya rutin minum minimal 90 tablet",
                        score: 0
                    },
                    {
                        text: "Ya tapi tidak rutin / kurang dari 90 tablet",
                        score: 1
                    },
                    {
                        text: "Tidak, saya tidak minum tablet tambah darah sama sekali",
                        score: 2
                    }
                ]
            },
            {
                id: 9,
                question: "Apakah anak Anda mendapatkan imunisasi dasar lengkap sesuai usianya?",
                category: "Kesehatan Anak",
                options: [{
                        text: "Ya, jadwal imunisasi lengkap dan selalu ditepati",
                        score: 0
                    },
                    {
                        text: "Ada beberapa jadwal yang terlewat",
                        score: 1
                    },
                    {
                        text: "Tidak, anak saya jarang/tidak pernah imunisasi",
                        score: 2
                    }
                ]
            },
            {
                id: 10,
                question: "Apakah Anda rutin membawa anak ke Posyandu setiap bulan untuk menimbang berat badan dan mengukur tinggi badan?",
                category: "Pemantauan Tumbuh Kembang",
                options: [{
                        text: "Ya, rutin setiap bulan ke Posyandu",
                        score: 0
                    },
                    {
                        text: "Kadang-kadang (jika sempat saja)",
                        score: 1
                    },
                    {
                        text: "Sangat jarang atau tidak pernah ke Posyandu",
                        score: 2
                    }
                ]
            }
        ];

        // --- State Variables ---
        let currentQuestionIndex = 0;
        const userAnswers = new Array(quizData.length).fill(null);
        const totalQuestions = quizData.length;

        // --- DOM Elements ---
        const ui = {
            quizContainer: document.getElementById('quizContainer'),
            resultContainer: document.getElementById('resultContainer'),
            questionTitle: document.getElementById('questionTitle'),
            currentQText: document.getElementById('currentQText'),
            totalQText: document.getElementById('totalQText'),
            progressBar: document.getElementById('progressBar'),
            questionText: document.getElementById('questionText'),
            optionsContainer: document.getElementById('optionsContainer'),
            btnPrev: document.getElementById('btnPrev'),
            btnNext: document.getElementById('btnNext'),
            btnRestart: document.getElementById('btnRestart'),
            resultIcon: document.getElementById('resultIcon'),
            resultTitle: document.getElementById('resultTitle'),
            resultDesc: document.getElementById('resultDesc'),
            resultAlert: document.getElementById('resultAlert')
        };

        // --- Core Logic ---
        function initQuiz() {
            ui.totalQText.textContent = totalQuestions;
            currentQuestionIndex = 0;
            userAnswers.fill(null);
            showQuestion(currentQuestionIndex);
            ui.resultContainer.style.display = 'none';
            ui.quizContainer.style.display = 'block';
        }

        function showQuestion(index) {
            const q = quizData[index];
            const currentQNum = index + 1;

            // Update header
            ui.questionTitle.innerHTML = `Pertanyaan <span style="color: var(--primary-600);">${currentQNum}</span>`;
            ui.currentQText.textContent = currentQNum;
            ui.progressBar.style.width = `${(currentQNum / totalQuestions) * 100}%`;

            // Update question text
            ui.questionText.innerHTML = `<span class="assessment-q-badge">${q.category}</span><br>${q.question}`;

            // Render options
            ui.optionsContainer.innerHTML = '';
            q.options.forEach((opt, optIndex) => {
                const isSelected = userAnswers[index] === optIndex;
                const optionEl = document.createElement('div');
                optionEl.className = `assessment-option ${isSelected ? 'selected' : ''}`;
                optionEl.innerHTML = `
                <div class="assessment-option-radio">
                    ${isSelected ? '<div class="assessment-option-radio-dot"></div>' : ''}
                </div>
                <div class="assessment-option-text">${opt.text}</div>
            `;
                optionEl.addEventListener('click', () => selectOption(optIndex));
                ui.optionsContainer.appendChild(optionEl);
            });

            // Navigation state
            ui.btnPrev.style.visibility = index === 0 ? 'hidden' : 'visible';

            if (userAnswers[index] !== null) {
                ui.btnNext.disabled = false;
            } else {
                ui.btnNext.disabled = true;
            }

            if (index === totalQuestions - 1) {
                ui.btnNext.innerHTML = 'Lihat Hasil <i class="fas fa-check"></i>';
                ui.btnNext.className = 'btn btn-accent';
            } else {
                ui.btnNext.innerHTML = 'Selanjutnya <i class="fas fa-arrow-right"></i>';
                ui.btnNext.className = 'btn btn-primary';
            }
        }

        function selectOption(optIndex) {
            userAnswers[currentQuestionIndex] = optIndex;
            // Re-render current question to reflect selected state
            showQuestion(currentQuestionIndex);

            // Auto advance after short delay if not the last question
            if (currentQuestionIndex < totalQuestions - 1) {
                setTimeout(() => {
                    navigate(1);
                }, 400); // 400ms delay for visual feedback
            }
        }

        function navigate(direction) {
            const newIndex = currentQuestionIndex + direction;
            if (newIndex >= 0 && newIndex < totalQuestions) {
                currentQuestionIndex = newIndex;
                showQuestion(currentQuestionIndex);
            } else if (newIndex >= totalQuestions) {
                calculateResult();
            }
        }

        function calculateResult() {
            let totalScore = 0;
            let risks = [];

            // Sum scores and identify bad practices
            userAnswers.forEach((answerIndex, qIndex) => {
                if (answerIndex !== null) {
                    const score = quizData[qIndex].options[answerIndex].score;
                    totalScore += score;

                    // If a high risk option was chosen (score > 0), record the category for recommendations
                    if (score > 0) {
                        risks.push({
                            category: quizData[qIndex].category,
                            severity: score === 2 ? 'high' : 'medium'
                        });
                    }
                }
            });

            // Determine Risk Level (Max possible score is 20)
            let riskLevelStr = "";
            let riskColor = "";
            let riskIcon = "";
            let riskDesc = "";

            // Tembakan threshold
            // 0-4   : Rendah
            // 5-9   : Sedang
            // 10-20 : Tinggi
            if (totalScore <= 4) {
                riskLevelStr = "Risiko Rendah";
                riskColor = "var(--accent-600)"; // green-600
                riskIcon = "fa-shield-check";
                riskDesc = "Hebat! Kebiasaan asuh, pemenuhan gizi, dan kebersihan yang Anda terapkan sudah sangat baik. Terus pertahankan untuk mendukung tumbuh kembang optimal anak Anda.";
                ui.resultIcon.style.background = "var(--accent-100)";
                ui.resultIcon.style.color = "var(--accent-600)";
            } else if (totalScore <= 9) {
                riskLevelStr = "Risiko Sedang";
                riskColor = "var(--warning)"; // orange-600
                riskIcon = "fa-triangle-exclamation";
                riskDesc = "Kebiasaan Anda sudah cukup baik, namun ada beberapa area yang berpotensi menghambat pertumbuhan anak. Perhatikan rekomendasi di bawah ini untuk menurunkan risiko stunting.";
                ui.resultIcon.style.background = "#fef3c7";
                ui.resultIcon.style.color = "var(--warning)";
            } else {
                riskLevelStr = "Risiko Tinggi";
                riskColor = "#dc2626"; // red-600
                riskIcon = "fa-circle-exclamation";
                riskDesc = "Perhatian! Praktik pengasuhan saat ini menunjukkan risiko tinggi terhadap stunting. Anak Anda mungkin tidak mendapatkan nutrisi atau lingkungan sehat yang cukup. Sangat disarankan untuk segera berkonsultasi dengan bidan atau petugas Posyandu terdekat.";
                ui.resultIcon.style.background = "#fee2e2";
                ui.resultIcon.style.color = "#dc2626";
            }

            // Generate Recommendations based on specific failed questions
            let recHTML = "<h4>Rekomendasi Perbaikan:</h4><ul style='text-align: left; margin-bottom: 0; padding-left: 1.25rem; font-size: 0.95rem; line-height: 1.6;'>";

            const categoriesFailed = new Set(risks.map(r => r.category));

            if (categoriesFailed.size === 0) {
                recHTML = `<div style="display: flex; align-items: center; gap: 0.75rem; justify-content: center; color: var(--primary-700);">
                <i class="fas fa-star" style="color: var(--accent-500); font-size: 1.5rem;"></i> 
                <strong>Pola asuh Anda sudah menjadi teladan yang baik!</strong></div>`;
            } else {
                if (categoriesFailed.has('Gizi & ASI') || categoriesFailed.has('MPASI')) {
                    recHTML += "<li><strong>Perbaiki Praktik ASI & MPASI:</strong> Kunjungi menu Edukasi Pola Asuh untuk mempelajari cara pemberian makan bayi yang tepat.</li>";
                }
                if (categoriesFailed.has('Gizi')) {
                    recHTML += "<li><strong>Tingkatkan Asupan Gizi:</strong> Pastikan selalu ada protein hewani di setiap jadwal makan anak. Kurangi snack manis/kemasan.</li>";
                }
                if (categoriesFailed.has('PHBS') || categoriesFailed.has('Sanitasi')) {
                    recHTML += "<li><strong>Benahi Sanitasi (PHBS):</strong> Biasakan cuci tangan pakai sabun, masak air hingga mendidih, dan gunakan jamban sehat untuk memutus rantai infeksi cacing/diare.</li>";
                }
                if (categoriesFailed.has('Kesehatan Ibu')) {
                    recHTML += "<li><strong>Perhatian pada Kesehatan Ibu:</strong> Anemia pada ibu bisa berdampak panjang. Pastikan asupan zat besi tercukupi.</li>";
                }
                if (categoriesFailed.has('Kesehatan Anak') || categoriesFailed.has('Pemantauan Tumbuh Kembang')) {
                    recHTML += "<li><strong>Aktif ke Posyandu:</strong> Segera lengkapi imunisasi yang tertinggal dan jangan lewatkan penimbangan balita rutin setiap bulan.</li>";
                }
                recHTML += "</ul>";
            }

            ui.resultAlert.innerHTML = recHTML;
            ui.resultAlert.style.borderLeftColor = riskColor;
            if (riskLevelStr === "Risiko Rendah") {
                ui.resultAlert.style.background = "var(--primary-50)";
                ui.resultAlert.style.borderLeftColor = "var(--primary-500)";
            } else if (riskLevelStr === "Risiko Sedang") {
                ui.resultAlert.style.background = "#fef3c7";
            } else {
                ui.resultAlert.style.background = "#fef2f2";
            }

            // Update UI Result
            ui.resultIcon.innerHTML = `<i class="fas ${riskIcon}"></i>`;
            ui.resultTitle.textContent = riskLevelStr;
            ui.resultTitle.style.color = riskColor;
            ui.resultDesc.textContent = riskDesc;

            // Switch View
            ui.quizContainer.style.display = 'none';
            ui.resultContainer.style.display = 'block';

            // Scroll to top of section
            ui.resultContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        // --- Event Listeners ---
        ui.btnNext.addEventListener('click', () => navigate(1));
        ui.btnPrev.addEventListener('click', () => navigate(-1));
        ui.btnRestart.addEventListener('click', () => {
            ui.resultContainer.style.display = 'none';
            initQuiz();
            ui.quizContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        });

        // --- Start ---
        initQuiz();
    });
</script>
@endpush