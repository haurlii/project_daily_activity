<h1 align="center" style="font-size: 1.875rem; font-weight: 700;">{{ $title }}</h1>
<h3 align="center"> Hari, Tanggal : {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</h3>
<hr>
<table width="100%" border='1px'
    style="border-collapse: collapse; font-size: 0.875rem; table-layout: auto; margin-bottom: 32px;">
    <thead>
        <tr>
            <th align="center" style="padding-left: 8px; padding-right: 8px; padding-top: 8px; padding-bottom: 8px;">No
            </th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Nama Ketua</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Tugas</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Detail Tugas</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Tanggal Pengerjaan</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Batas Pengerjaan</th>
            <th align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td align="center" style="padding-left: 8px; padding-right: 8px; padding-top: 8px; padding-bottom: 8px;">
                {{ $loop->iteration }}
            </td>
            <td align="left" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $task->leaderTask->name }}
            </td>
            <td align="justify" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $task->title ?? "Tidak ada" }}
            </td>
            <td align="justify" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $task->description ?? "Tidak ada" }}
            </td>
            <td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $task->start_date->translatedFormat('d F Y') }}
            </td>
            <td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $task->end_date->translatedFormat('d F Y') }}
            </td>
            <td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 6px; padding-bottom: 6px;">
                {{ $task->status ?? "Tidak ada" }}
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

<table width="100%" style="margin-top: 32px; font-size: 1rem; border-collapse: collapse;">
    <tr>
        <!-- Kolom Kiri -->
        <td align="left" style="vertical-align: top;">
            <p><strong>Total Tugas:</strong> 5</p>
            <p><strong>Dikerjakan:</strong> 4</p>
            <p><strong>Tertunda:</strong> 1</p>
            <p><strong>Selesai:</strong> 1</p>
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