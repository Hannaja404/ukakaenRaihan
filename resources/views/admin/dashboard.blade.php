@extends('layouts.app')
@section('title', 'Dasbor Admin - Pengaduan Prasarana Sekolah')

@section('content')
    <div style="margin-bottom: 2rem;">
        <h1 style="margin-bottom: 0.5rem;">Dasboard Admin</h1>
        <p style="color: var(--text-muted);">Gambaran umum pengaduan yang masuk dari seluruh siswa.</p>
    </div>

    <div class="grid grid-cols-3" style="margin-bottom: 2rem;">
        <div class="card glass" style="border-left: 4px solid var(--status-pending);">
            <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">Menunggu Validasi</h3>
            <p style="font-size: 2.5rem; font-weight: 800; color: var(--text);">{{ $pending }}</p>
        </div>
        <div class="card glass" style="border-left: 4px solid var(--status-processing);">
            <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">Sedang Diproses</h3>
            <p style="font-size: 2.5rem; font-weight: 800; color: var(--text);">{{ $processing }}</p>
        </div>
        <div class="card glass" style="border-left: 4px solid var(--status-resolved);">
            <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">Selesai Ditangani</h3>
            <p style="font-size: 2.5rem; font-weight: 800; color: var(--text);">{{ $resolved }}</p>
        </div>
    </div>

    <div class="card glass" style="padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; margin: 0;">Daftar Pengaduan Siswa</h2>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.report') }}" target="_blank" class="btn btn-outline"
                    style="font-size: 0.875rem; padding: 0.5rem 1rem;">🖨️ Cetak Laporan LENGKAP</a>
            @endif
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelapor</th>
                        <th>Judul & Laporan</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $c)
                        <tr>
                            <td style="font-weight: 600;">
                                #{{ str_pad($c->id, 4, '0', STR_PAD_LEFT) }}
                                <form action="{{ route('complaints.destroy', $c->id) }}" method="POST"
                                    style="display:inline-block; margin-left: 5px;">
                                    @csrf
                                    <button type="submit" class="btn"
                                        style="background: #E10600; color: #FFFFFF; font-size: 0.7rem; padding: 2px 6px; cursor: pointer; border: none; border-radius: 3px; font-weight: 800; text-transform: uppercase;"
                                        title="Hapus Pengaduan" onclick="return confirm('Hapus seluruh pengaduan ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                            <td>
                                {{ $c->user->name }}<br>
                                <small style="color: var(--text-muted);">NIS/NIK: {{ $c->user->nik }}</small>
                            </td>
                            <td style="max-width: 300px;">
                                <strong>{{ $c->title }}</strong><br>
                                <span
                                    style="font-size:0.875rem; color:var(--text-muted);">{{ Str::limit($c->description, 50) }}</span>
                            </td>
                            <td>
                                @if($c->photo)
                                    <a href="{{ asset($c->photo) }}" target="_blank">
                                        <img src="{{ asset($c->photo) }}" alt="Bukti"
                                            style="width:70px; height:60px; object-fit:cover; border-radius:6px; border:1px solid var(--border); cursor:pointer;">
                                    </a>
                                @else
                                    <span style="color:var(--text-muted); font-size:0.8rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = $c->status;
                                    $badgeText = $c->status == 'pending' ? 'Menunggu' : ($c->status == 'processing' ? 'Diproses' : 'Selesai');
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                            </td>
                            <td>
                                <!-- Daftar Tanggapan & Aksi -->
                                <div
                                    style="display:flex; flex-direction:column; gap:0.5rem; justify-content:flex-start; align-items:flex-start;">
                                    <!-- List Tanggapan -->
                                    @if($c->responses->count() > 0)
                                        <div style="width: 100%; margin-bottom: 0.5rem;">
                                            @foreach($c->responses as $resp)
                                                <div
                                                    style="background: #fdfdfd; border-left: 3px solid var(--primary); padding: 0.5rem; margin-bottom: 0.25rem; font-size: 0.8rem; border-radius: 4px; position: relative;">
                                                    <strong>{{ $resp->user->username }}:</strong> {{ $resp->response }}
                                                    <form action="{{ route('responses.destroy', $resp->id) }}" method="POST"
                                                        style="display:inline; margin-left: 5px;">
                                                        @csrf
                                                        <button type="submit" class="btn"
                                                            style="background: #E10600; color: #FFFFFF; font-size: 0.65rem; padding: 1px 4px; border: none; border-radius: 2px; cursor: pointer; font-weight: 800; text-transform: uppercase;"
                                                            onclick="return confirm('Hapus tanggapan ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Form Tanggapan & Perubahan Status -->
                                    <div style="display:flex; gap:0.5rem; align-items:center; width: 100%;">
                                        @if($c->status != 'resolved')
                                            <form action="{{ route('responses.store') }}" method="POST"
                                                style="display:flex; gap:0.25rem; flex: 1;">
                                                @csrf
                                                <input type="hidden" name="complaint_id" value="{{ $c->id }}">
                                                <input type="text" name="response" placeholder="Balas..." class="form-control"
                                                    style="flex:1; padding:0.4rem; font-size:0.875rem; border-radius:4px;" required>
                                                <button type="submit" class="btn btn-primary"
                                                    style="padding:0.4rem 0.6rem; font-size:0.875rem;">OK</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('complaints.updateStatus', $c->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-control"
                                                style="display:inline; width:auto; padding:0.4rem; font-size:0.875rem; border-radius:4px;"
                                                onchange="this.form.submit()">
                                                <option value="pending" {{ $c->status == 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="processing" {{ $c->status == 'processing' ? 'selected' : '' }}>
                                                    Proses</option>
                                                <option value="resolved" {{ $c->status == 'resolved' ? 'selected' : '' }}>Selesai
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada
                                pengaduan yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection