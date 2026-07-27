@extends('layouts.public')
@section('title', $recipe->title)

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
                <span><i class="fas fa-fire-flame-curved"></i> {{ $recipe->per_serving_nutrition['calories'] ?? 0 }} kkal/porsi</span>
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
                    <div class="ingredient-item">
                        <span class="ingredient-name">{{ $ingredient->name }}</span>
                        <span class="ingredient-qty">{{ $ingredient->pivot->quantity_grams }} {{ $ingredient->unit }}</span>
                    </div>
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
                <div class="nutrition-panel">
                    <h3><i class="fas fa-chart-pie" style="color: var(--primary-600);"></i> Informasi Gizi</h3>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">Per porsi ({{ $recipe->servings }} porsi total)</p>

                    @php $nutrition = $recipe->per_serving_nutrition; @endphp

                    <div class="nutrition-item">
                        <span class="nutrition-label">Kalori</span>
                        <span class="nutrition-value">{{ $nutrition['calories'] ?? 0 }} kkal</span>
                    </div>
                    <div class="nutrition-bar">
                        <div class="nutrition-bar-fill" style="width: {{ min(($nutrition['calories'] ?? 0) / 5, 100) }}%;"></div>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Protein</span>
                        <span class="nutrition-value">{{ $nutrition['protein'] ?? 0 }} g</span>
                    </div>
                    <div class="nutrition-bar">
                        <div class="nutrition-bar-fill" style="width: {{ min(($nutrition['protein'] ?? 0) / 0.5, 100) }}%; background: var(--gradient-accent);"></div>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Lemak</span>
                        <span class="nutrition-value">{{ $nutrition['fat'] ?? 0 }} g</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Karbohidrat</span>
                        <span class="nutrition-value">{{ $nutrition['carbohydrates'] ?? 0 }} g</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Serat</span>
                        <span class="nutrition-value">{{ $nutrition['fiber'] ?? 0 }} g</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Kalsium</span>
                        <span class="nutrition-value">{{ $nutrition['calcium'] ?? 0 }} mg</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Zat Besi</span>
                        <span class="nutrition-value">{{ $nutrition['iron'] ?? 0 }} mg</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Vitamin A</span>
                        <span class="nutrition-value">{{ $nutrition['vitamin_a'] ?? 0 }} mcg</span>
                    </div>

                    <div class="nutrition-item">
                        <span class="nutrition-label">Vitamin C</span>
                        <span class="nutrition-value">{{ $nutrition['vitamin_c'] ?? 0 }} mg</span>
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
@endsection
