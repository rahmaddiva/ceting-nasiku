@extends('layouts.public')
@section('body_class', 'page-inner')
@section('title', $recipe->title . ' — CETING NASIKU')
@section('meta_description', Str::limit(strip_tags($recipe->description), 155))
@section('og_title', $recipe->title . ' — CETING NASIKU')
@section('og_description', Str::limit(strip_tags($recipe->description), 155))
@section('og_type', 'article')

@section('og_image')
@if($recipe->image)
<meta property="og:image" content="{{ asset($recipe->image) }}">
@endif
@endsection

@section('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Recipe",
    "name": "{{ $recipe->title }}",
    "description": "{{ Str::limit(strip_tags($recipe->description), 300) }}",
    @if($recipe->image)"image": "{{ asset($recipe->image) }}",@endif
    "recipeCategory": "{{ $recipe->category->name ?? 'Umum' }}",
    "recipeYield": "{{ $recipe->servings }} porsi",
    "author": {
        "@type": "Organization",
        "name": "CETING NASIKU"
    }
}
</script>
@endsection

@section('content')
<div class="recipe-detail">
    <!-- Header -->
    <div class="recipe-detail-header" style="padding-top: 6rem;">
        <div class="container">
            <div class="section-badge" style="background: rgba(255,255,255,0.15); color: white;">
                <i class="fas fa-tag"></i> {{ $recipe->category->name ?? 'Umum' }}
            </div>
            <h1>{{ $recipe->title }}</h1>
            <p style="font-size: 1.1rem; opacity: 0.9; max-width: 700px;">{{ $recipe->description }}</p>
            <div class="recipe-detail-meta">
                <span><i class="fas fa-users"></i> {{ $recipe->servings }} Porsi</span>
                @if($recipe->age_group)
                <span><i class="fas fa-baby"></i> {{ $recipe->age_group }}</span>
                @endif
                <span><i class="fas fa-fire-flame-curved"></i> <span id="meta-calories">{{ $recipe->per_serving_nutrition['calories'] ?? 0 }} kkal/porsi</span></span>
                <span><i class="fas fa-user-pen"></i> {{ $recipe->user->name ?? 'Admin' }}</span>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="container">
        <div class="recipe-detail-body">
            <div>
                <!-- Ingredients -->
                <div class="ingredients-list">
                    <h2><i class="fas fa-carrot" style="color: var(--accent-500);"></i> Bahan-Bahan</h2>
                    @foreach($recipe->ingredients as $ingredient)
                    @php
                        $groupOptions = $substitutionGroups[$ingredient->substitution_group] ?? collect();
                    @endphp
                    <div class="ingredient-item" id="ing-slot-{{ $ingredient->id }}" data-group="{{ $ingredient->substitution_group ?? '' }}" data-current="{{ $ingredient->id }}" data-grams="{{ $ingredient->pivot->quantity_grams }}">
                        <span class="ingredient-name">{{ $ingredient->name }}</span>
                        <span class="ingredient-qty">{{ $ingredient->pivot->quantity_grams }} {{ $ingredient->unit }}</span>
                    </div>
                    @if($groupOptions->count() > 1)
                    <div class="ingredient-substitute" data-slot="ing-slot-{{ $ingredient->id }}" data-group="{{ $ingredient->substitution_group }}">
                        <span class="sub-label">Ganti:</span>
                        @foreach($groupOptions as $option)
                        <button type="button" class="sub-pill{{ $option['id'] === $ingredient->id ? ' active' : '' }}" data-ing="{{ $option['id'] }}" data-name="{{ $option['name'] }}">{{ $option['name'] }}</button>
                        @endforeach
                    </div>
                    @endif
                    @endforeach
                </div>

                <!-- Instructions -->
                <div class="recipe-instructions">
                    <h2><i class="fas fa-list-ol" style="color: var(--primary-600);"></i> Cara Membuat</h2>
                    <ol>
                        @foreach(explode("\n", $recipe->instructions) as $step)
                            @if(trim($step))
                            <li>{{ preg_replace('/^\d+\.\s*/', '', trim($step)) }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>

            <!-- Nutrition Panel -->
            <div>
                <div class="nutrition-panel" id="nutritionPanel" data-servings="{{ $recipe->servings }}">
                    <h3><i class="fas fa-chart-pie" style="color: var(--primary-600);"></i> Informasi Gizi</h3>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">Per porsi ({{ $recipe->servings }} porsi total)</p>

                    @php $nutrition = $recipe->per_serving_nutrition; @endphp

                    <div class="nutrition-item">
                        <span class="nutrition-label">Kalori</span>
                        <span class="nutrition-value" id="nut-calories">{{ $nutrition['calories'] ?? 0 }} kkal</span>
                    </div>
                    <div class="nutrition-bar">
                        <div class="nutrition-bar-fill" id="calorie-bar" style="width: {{ min(($nutrition['calories'] ?? 0) / 5, 100) }}%;"></div>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Protein</span>
                        <span class="nutrition-value" id="nut-protein">{{ $nutrition['protein'] ?? 0 }} g</span>
                    </div>
                    <div class="nutrition-bar">
                        <div class="nutrition-bar-fill" id="protein-bar" style="width: {{ min(($nutrition['protein'] ?? 0) / 0.5, 100) }}%; background: var(--gradient-accent);"></div>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Lemak</span>
                        <span class="nutrition-value" id="nut-fat">{{ $nutrition['fat'] ?? 0 }} g</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Karbohidrat</span>
                        <span class="nutrition-value" id="nut-carbohydrates">{{ $nutrition['carbohydrates'] ?? 0 }} g</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Serat</span>
                        <span class="nutrition-value" id="nut-fiber">{{ $nutrition['fiber'] ?? 0 }} g</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Kalsium</span>
                        <span class="nutrition-value" id="nut-calcium">{{ $nutrition['calcium'] ?? 0 }} mg</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Zat Besi</span>
                        <span class="nutrition-value" id="nut-iron">{{ $nutrition['iron'] ?? 0 }} mg</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Vitamin A</span>
                        <span class="nutrition-value" id="nut-vitamin_a">{{ $nutrition['vitamin_a'] ?? 0 }} mcg</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Vitamin C</span>
                        <span class="nutrition-value" id="nut-vitamin_c">{{ $nutrition['vitamin_c'] ?? 0 }} mg</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Recipes -->
        @if($related->count() > 0)
        <section class="section">
            <div class="section-header">
                <h2>Resep <span>Serupa</span></h2>
            </div>
            <div class="recipes-grid">
                @foreach($related as $rel)
                <div class="recipe-card">
                    <div class="recipe-card-image">
                        @if($rel->image)
                            <img src="{{ asset($rel->image) }}" alt="{{ $rel->title }}">
                        @else
                            <i class="fas fa-utensils"></i>
                        @endif
                        <span class="recipe-card-badge">{{ $rel->category->name ?? 'Umum' }}</span>
                    </div>
                    <div class="recipe-card-body">
                        <h3><a href="/resep/{{ $rel->slug }}">{{ $rel->title }}</a></h3>
                        <p>{{ Str::limit($rel->description, 80) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
<style>
.ingredient-substitute { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin: -2px 0 14px; }
.sub-label { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-right: 2px; }
.sub-pill { border: 1.5px solid var(--primary-200); background: #fff; color: var(--primary-700); font-size: 0.8rem; font-weight: 600; padding: 4px 14px; border-radius: 999px; cursor: pointer; transition: all .15s ease; }
.sub-pill:hover { border-color: var(--primary-500); }
.sub-pill.active { background: var(--primary-600); border-color: var(--primary-600); color: #fff; }
.sub-note { font-size: 0.75rem; color: var(--text-muted); margin: 6px 0 14px; }
</style>

<script>
(function () {
    var SUBSTITUTION = @json($substitutionGroups);
    var NUTRIENTS = ['calories','protein','fat','carbohydrates','fiber','calcium','iron','vitamin_a','vitamin_c'];
    var UNITS = { calories: 'kkal', protein: 'g', fat: 'g', carbohydrates: 'g', fiber: 'g', calcium: 'mg', iron: 'mg', vitamin_a: 'mcg', vitamin_c: 'mg' };

    function round2(v) { return Math.round(v * 100) / 100; }

    function recalc() {
        var panel = document.getElementById('nutritionPanel');
        if (!panel) return;
        var servings = parseFloat(panel.dataset.servings) || 1;
        var totals = {};
        NUTRIENTS.forEach(function (k) { totals[k] = 0; });

        document.querySelectorAll('.ingredient-item[data-group]').forEach(function (item) {
            if (!item.dataset.group) return;
            var grams = parseFloat(item.dataset.grams) || 0;
            var ingId = parseInt(item.dataset.current, 10);
            var group = SUBSTITUTION[item.dataset.group] || [];
            var ing = group.find(function (x) { return x.id === ingId; });
            if (!ing) return;
            var factor = grams / 100;
            NUTRIENTS.forEach(function (k) { totals[k] += ing.per100[k] * factor; });
        });

        NUTRIENTS.forEach(function (k) {
            var el = document.getElementById('nut-' + k);
            if (el) el.textContent = round2(totals[k] / servings) + ' ' + UNITS[k];
        });
        var calBar = document.getElementById('calorie-bar');
        if (calBar) calBar.style.width = Math.min(totals.calories / servings / 5, 100) + '%';
        var protBar = document.getElementById('protein-bar');
        if (protBar) protBar.style.width = Math.min(totals.protein / servings / 0.5, 100) + '%';
        var meta = document.getElementById('meta-calories');
        if (meta) meta.textContent = round2(totals.calories / servings) + ' kkal/porsi';
    }

    document.querySelectorAll('.sub-pill').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var wrap = btn.closest('.ingredient-substitute');
            var slot = document.getElementById(wrap.dataset.slot);
            slot.dataset.current = btn.dataset.ing;
            var nameEl = slot.querySelector('.ingredient-name');
            if (nameEl) nameEl.textContent = btn.dataset.name;
            wrap.querySelectorAll('.sub-pill').forEach(function (b) {
                b.classList.toggle('active', b === btn);
            });
            recalc();
        });
    });

    recalc();
})();
</script>
@endsection
