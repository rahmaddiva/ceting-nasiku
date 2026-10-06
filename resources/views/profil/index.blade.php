@extends('layouts.public')
@section('body_class', 'page-inner')
@section('title', 'Pantau Tumbuh Kembang — CETING NASIKU')
@section('meta_description', 'Pantau tumbuh kembang anak Anda: catat berat dan tinggi badan, bandingkan dengan standar WHO, dan deteksi dini risiko stunting.')

@section('content')
<div style="padding-top: 6rem;">
    <div class="container">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
            <div>
                <div class="section-badge" style="background: var(--primary-100, #cffafe); color: var(--primary-800, #155e75);"><i class="fas fa-child"></i> KMS Digital</div>
                <h1 style="color: var(--primary-900); margin-top: 0.75rem;">Pantau Tumbuh Kembang</h1>
                <p style="color: var(--text-muted); max-width: 640px;">Catat berat dan tinggi badan anak secara rutin, lalu bandingkan dengan standar pertumbuhan WHO untuk deteksi dini stunting.</p>
            </div>
            <a href="{{ route('profil.children.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Anak</a>
        </div>

        @if($children->isEmpty())
        <div style="background: #fff; border: 1.5px dashed var(--primary-100); border-radius: 16px; padding: 3rem 2rem; text-align: center;">
            <div style="width: 72px; height: 72px; border-radius: 50%; background: var(--primary-50); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--primary-600); font-size: 1.8rem;">
                <i class="fas fa-baby"></i>
            </div>
            <h3 style="color: var(--primary-900);">Belum ada data anak</h3>
            <p style="color: var(--text-muted); max-width: 420px; margin: 0.5rem auto 1.25rem;">Tambahkan data anak Anda untuk mulai memantau pertumbuhan dan status gizinya.</p>
            <a href="{{ route('profil.children.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Anak</a>
        </div>
        @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.25rem; margin-top: 1rem;">
            @foreach($children as $item)
            @php
                $latest = $item['latest'];
                $badge = $latest && $latest['height'] && $latest['height']['classify']
                    ? $latest['height']['classify'] : null;
                $level = $badge['level'] ?? 'normal';
                $colors = [
                    'normal' => ['bg' => '#ecfdf5', 'text' => 'var(--accent-700)'],
                    'stunting' => ['bg' => '#fffbeb', 'text' => '#92400e'],
                    'severe' => ['bg' => '#fef2f2', 'text' => '#991b1b'],
                ];
                $c = $colors[$level] ?? $colors['normal'];
                $umur = $item['child']->ageInMonths();
            @endphp
            <a href="{{ route('profil.children.show', $item['child']) }}" style="text-decoration: none; color: inherit; display: block;">
                <div style="background: #fff; border: 1px solid var(--primary-100); border-radius: 16px; padding: 1.4rem 1.5rem; box-shadow: 0 2px 12px rgba(8,145,178,.07); transition: transform .15s, box-shadow .15s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(8,145,178,.14)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <div style="display: flex; align-items: center; gap: 0.9rem; margin-bottom: 0.8rem;">
                        <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--primary-50); color: var(--primary-700); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex: none;">
                            <i class="fas fa-{{ $item['child']->gender === 'female' ? 'person-dress' : 'person' }}"></i>
                        </div>
                        <div>
                            <h3 style="color: var(--primary-900); margin: 0;">{{ $item['child']->name }}</h3>
                            <span style="color: var(--text-muted); font-size: 0.85rem;">{{ $item['child']->gender === 'female' ? 'Perempuan' : 'Laki-laki' }} • {{ $umur }} bulan</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        @if($badge)
                        <span style="background: {{ $c['bg'] }}; color: {{ $c['text'] }}; font-weight: 700; font-size: 0.78rem; padding: 0.35rem 0.8rem; border-radius: 999px;"><i class="fas fa-{{ $level === 'normal' ? 'check-circle' : 'triangle-exclamation' }}"></i> {{ $badge['status'] }}</span>
                        @else
                        <span style="color: var(--text-muted); font-size: 0.8rem;">Belum ada pengukuran</span>
                        @endif
                        <span style="color: var(--primary-600); font-weight: 600; font-size: 0.85rem;">Lihat <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
