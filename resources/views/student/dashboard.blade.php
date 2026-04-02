@extends('layouts.app')
@section('title', 'Dasbor Siswa - Pengaduan Prasarana Sekolah')

@section('content')
    <div class="grid grid-cols-3">
        <!-- Form Pengaduan -->
        <div class="card glass" style="grid-column: span 1;">
            <h2 style="font-size: 1.25rem;"><i class="bi bi-pencil-square"></i> Buat Pengaduan Baru</h2>
            <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 1.5rem;">Sampaikan laporan Anda dengan
                detail dan jelas.</p>

            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="title">Judul Laporan</label>
                    <input type="text" id="title" name="title" class="form-control" required
                        placeholder="Contoh: Fasilitas Kelas Rusak">
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Isi Laporan / Detail</label>
                    <textarea id="description" name="description" class="form-control" rows="5" required
                        placeholder="Tuliskan detail kejadian atau keluhan Anda..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="photo">Lampiran Foto (Opsional)</label>
                    <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg,image/png,image/jpg">
                    <small
                        style="color: var(--text-muted); font-size: 0.75rem; display: block; margin-top: 0.25rem;">Maksimal
                        2MB (JPG/PNG).</small>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Kirim Pengaduan</button>
            </form>
        </div>

        <!-- Riwayat Pengaduan -->
        <div class="card" style="grid-column: span 2;">
            <h2 style="font-size: 1.25rem; margin-bottom: 1.5rem;"><i class="bi bi-clock-history"></i> Riwayat Pengaduan
                Anda</h2>

            @if($complaints->isEmpty())
                <div
                    style="text-align: center; padding: 3rem; background: #F9FAFB; border-radius: 8px; border: 1px dashed var(--border);">
                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p style="margin-top: 1rem; color: var(--text-muted);">Anda belum pernah membuat pengaduan.</p>
                </div>
            @else
                <div class="grid grid-cols-2" style="gap: 1rem;">
                    @foreach($complaints as $c)
                        <div
                            style="padding: 1.5rem; border: 1px solid var(--border); border-radius: 8px; background: var(--surface); box-shadow: var(--shadow-soft);">
                            <div
                                style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                <h3 style="font-size: 1.1rem; margin: 0;">{{ $c->title }}</h3>
                                <span class="badge {{ $c->status }}">
                                    {{ $c->status == 'pending' ? 'Menunggu' : ($c->status == 'processing' ? 'Diproses' : 'Selesai') }}
                                </span>
                            </div>
                            <div style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                                <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($c->date)->translatedFormat('d F Y') }}
                            </div>

                            <p style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--text);">
                                {{ Str::limit($c->description, 80) }}</p>

                            @if($c->photo)
                                <div style="margin-bottom: 1rem;">
                                    <img src="{{ asset($c->photo) }}" alt="Bukti"
                                        style="max-width:100%; height:120px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
                                </div>
                            @endif

                            @if($c->responses->count() > 0)
                                <div
                                    style="background: white; border-left: 3px solid var(--status-processing); padding: 0.75rem; font-size: 0.875rem; border-radius: 4px;">
                                    <strong>Tanggapan Petugas:</strong><br>
                                    {{ $c->responses->last()->response }}
                                </div>
                            @else
                                <div style="font-size: 0.875rem; color: var(--text-muted); font-style: italic;">
                                    Belum ada tanggapan.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection