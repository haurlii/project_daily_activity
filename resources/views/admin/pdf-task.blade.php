<h1 align="center" style="font-size: 1.875rem; font-weight: 700;">Data Karyawan</h1>
<h3 align="center"> Hari, Tanggal : {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</h3>
<hr>
<table width="100%" border='1px'
    style="border-collapse: collapse; font-size: 0.875rem; table-layout: auto; margin-bottom: 32px;">
    <thead>
        <tr>
            <th align="center" style="padding-left: 8px; padding-right: 8px; padding-top: 8px; padding-bottom: 8px;">No
            </th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Nama</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Email</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Alamat</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Kontak</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Posisi</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Divisi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td align="center" style="padding-left: 8px; padding-right: 8px; padding-top: 8px; padding-bottom: 8px;">
                {{ $loop->iteration }}
            </td>
            <td align="left" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $user->name }}
            </td>
            <td align="left" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $user->email ?? "Tidak ada" }}
            </td>
            <td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $user->address ?? "Tidak ada" }}
            </td>
            <td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $user->contact ?? "Tidak ada" }}
            </td>
            <td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $user->role }}
            </td>
            <td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $user->division }}
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

<table width="100%" style="margin-top: 32px; font-size: 1rem; border-collapse: collapse;">
    <tr>
        <!-- Kolom Kiri -->
        <td align="left" style="vertical-align: top;">
            <p><strong>Total Peserta:</strong> 5</p>
            <p><strong>Hadir:</strong> 4</p>
            <p><strong>Tidak Hadir:</strong> 1</p>
        </td>

        <!-- Kolom Kanan -->
        <td align="right" style="vertical-align: top;">
            <p style="margin-bottom: 96px;">
                Cirebon, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>
            <p>{{ Auth::user()->name }}</p>
        </td>
    </tr>
</table>