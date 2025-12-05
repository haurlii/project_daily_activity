{{--
<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Daftar Hadir - Contoh Absensi</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Outfit:wght@100..900&display=swap"
            rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="max-w-auto mx-auto bg-white p-8">
        <!-- Header Daftar Hadir -->
        <header align="center" style="margin-bottom: 32px;">
            <h1 style="font-size: 1.875rem; font-weight: 700;">Data Karyawan
            </h1>
        </header>

        <!-- Tabel Daftar Hadir -->
        <section class="mb-8">
            <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-2 py-2 text-center">No</th>
                        <th class="border border-gray-300 px-2.5 py-1.5 text-left">Nama</th>
                        <th class="border border-gray-300 px-2.5 py-1.5 text-center">Email</th>
                        <th class="border border-gray-300 px-2.5 py-1.5 text-center">Alamat</th>
                        <th class="border border-gray-300 px-2.5 py-1.5 text-center">Kontak</th>
                        <th class="border border-gray-300 px-2.5 py-1.5 text-center">Posisi</th>
                        <th class="border border-gray-300 px-2.5 py-1.5 text-center">Divisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="border border-gray-300 px-2 py-2 text-center">{{ $loop->iteration }}

                        </td>
                        <td class="border border-gray-300 px-2 py-2">{{ $user->name }}

                        </td>
                        <td class="border border-gray-300 px-2 py-2">{{ $user->email ?? "Belum tercantum" }}

                        </td>
                        <td class="border border-gray-300 px-2 py-2 text-center">{{ $user->address ?? "Belum tercantum"
                            }}
                        </td>
                        <td class="border border-gray-300 px-2 py-2 text-center">{{ $user->contact ?? "Belum tercantum"
                            }}
                        </td>
                        <td class="border border-gray-300 px-2 py-2 text-center">{{ $user->role }}

                        </td>
                        <td class="border border-gray-300 px-2 py-2 text-center">{{ $user->division }}

                        </td>
                    </tr>
                    @endforeach
                    <!-- Tambahkan baris lebih banyak jika diperlukan -->
                </tbody>
            </table>
        </section>

        <!-- Ringkasan -->
        <section class="mb-8">
            <div class="flex justify-between text-md">
                <div>
                    <p class="text-gray-700"><strong>Total Peserta:</strong> 5</p>
                    <p class="text-gray-700"><strong>Hadir:</strong> 4</p>
                    <p class="text-gray-700"><strong>Tidak Hadir:</strong> 1</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-700 mb-24">Cirebon, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                    <p class="text-gray-700">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </section>
    </body>

</html> --}}


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