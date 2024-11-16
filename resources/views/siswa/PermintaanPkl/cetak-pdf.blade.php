<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Cetak PDF</title>
        <!-- Bootstrap CSS -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
            crossorigin="anonymous"
        />
        <style>
          * {
            font-family: Arial, sans-serif;
            font-size: 11px;
          }
          img {
                height: 140px;
            }

            .ISO {
                height: 65px;
                margin-left: 10rem;
                margin-top: 2rem;
              }
            
              p {
                font-size: 11px;
                margin: 2px 0.2rem 0 0;
              }
              
              .sub-header {
                margin-left: 4.9rem;
                /* margin-left: 4.9px; */
                /* margin: 0; Menghilangkan margin jika ada */
              }

              .colon-space {
              letter-spacing: 2rem;
            }
              .colon-space-one {
              letter-spacing: 30px;
            }

            .text-justify {
              text-align: justify;
            }


h1 {
    text-align: center;
    color: #333;
}

/* Tabel */
.border-table {
  width: 100%;
  border: 1px solid black;
  border-collapse: collapse; /* Menggabungkan border antar cell */
}
            th,  td {
    padding: 10px 12px;
    text-align: center;
    border: 1px solid #000;
  } 
        
  tr:nth-child(even) {
    border: 1px solid black; /* Menambahkan border pada th dan td */
  }
  th:nth-child(even) {
    border: 1px solid black; /* Menambahkan border pada th dan td */
  }
  td:nth-child(even) {
    border: 1px solid black; /* Menambahkan border pada th dan td */
  }
        
  /* gambar tanda tangan */
  .Tdd {
                height: 180px;
                margin-left: 20rem;
                margin-top: 5rem;
              }

              /* style halaman dua */
              .margin-top {
                margin-top: 3rem;
              }
              .p-margin-top {
                margin-top: 2.5rem;
              }
              .margin-bottom {
                margin-bottom: 2rem;
              }

              b {
                font-weight: bold;
              }

              .margin-end {
                margin-right: 10.2rem;
              }
              .p-margin-end {
                margin-right: 5.8rem;
                margin-bottom: 4rem;
              }
              .margin-top-p {
                margin-top: 7rem;
                margin-bottom: 5rem;
              }
            </style>
    </head>
    <body>
      <div class="halaman-pertama">
        <div class="d-flex">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" />
          <img src="{{ asset('assets/img/ISO.JPG') }}" alt="ISO" class="ISO" />
        </div>
        
        @php
            $tanggal_Sekarang = Carbon\Carbon::now()->format('d F Y');
        @endphp
        <p class="text-end">{{ $kota }}, {{ $tanggal_Sekarang }}</p>

        <div class="ms-4">

          <p>Nome<span class="colon-space-one">r</span>: 038/102.16/SMK.PTW/HM/2024</p>
          <p>
            Periha<span class="colon-space">l</span>: Permohonan Kerjasama Pelaksanaan <br>
            <p class="sub-header">Praktik Kerja Lapangan (PKL)</p>
          </p>
          <p class="mt-3">Kepada :</p>
          @foreach ($pengajuan as $pengajuanPKL)
          <p>Yth. Kepala Pimpinan {{ $pengajuanPKL->perusahaan->nm_perusahaan }}</p>
          @php
          $alamat = $pengajuanPKL->perusahaan->alamat;
          $words = explode(' ', $alamat);
          $maxWords = 8;
        @endphp
        
        <p class="text-justify">
          @if (count($words) > $maxWords)
            {{ implode(' ', array_slice($words, 0, $maxWords)) }}
          @else
            {{ $alamat }}
          @endif
        </p>
        
        @if (count($words) > $maxWords)
          <p class="text-justify">
            {{ implode(' ', array_slice($words, $maxWords)) }}
          </p>
        @endif
        @endforeach
        
<p class="mt-3">Dengan hormat.</p>
<p class="text-justify mt-3">Untuk menghasilkan tenaga kerja yang siap pakai, yaitu tenaga kerja yang memiliki tingkat pengetahuan, keterampilan serta etos kerja yang sesuai dengan tuntutan lapangan kerja, SMK Pertiwi Kuningan menyelenggarakan Praktik Kerja Lapangan (PKL) sebagai pelaksanaan Keputusan Menteri Pendidikan dan Kebudayaan (Sekarang Pendidikan Nasional) Nomor : 050/U/2020 tentang Praktik Kerja Lapangan bagi Peserta Didik.</p>
<p class="text-justify mt-3">Praktik Kerja Lapangan (PKL) adalah suatu bentuk penyelenggaraan pendidikan keahlian Industry yang memadukan secara sistematik dan sinkron program pendidikan di sekolah dan program penguasaan keahlian yang diperoleh melalui kegiatan bekerja langsung di dunia usaha/ Industry, terarah untuk mencapai suatu tingkatan tertentu.</p>
@foreach ($pengajuan as $DataPengajuan)
@php
    $tanggalMasuk = \Carbon\Carbon::parse($DataPengajuan->bulan_masuk);
    $tanggalKeluar = \Carbon\Carbon::parse($DataPengajuan->bulan_keluar);

    // Hitung selisih bulan
    $selisihBulan = $tanggalMasuk->diffInMonths($tanggalKeluar);
@endphp
<p class="text-justify mt-3">Sehubungan dengan hal tersebut, kami mohon kesediaan Bapak / Ibu kiranya dapat menerima siswa kami untuk melaksanakan Praktik Kerja Lapangan (PKL) di Perusahaan / Instansi yang Bapak/ Ibu pimpin selama 
  {{ $selisihBulan }} bulan, yaitu mulai tanggal {{ $tanggalMasuk->format('d F') . ' s.d. ' .  $tanggalKeluar->format('d F Y') }}.</p>
@endforeach
 <p class="mt-3 mb-4">Adapun daftar calon peserta Praktek Kerja Lapangan (PKL) sebagai berikut :</p>

        <table class="border-table">
              <tr>
                <th>No</th>
                <th>Nomer Induk</th>
                <th>Nama Siswa</th>
                <th>Kompetensi Keahlian</th>
              </tr>
              @foreach ($pengajuan as $index => $DataPengajuan)
              <tr>
                  <td scope="row">{{ $index + 1 }}</td>
                  <td>{{ $DataPengajuan->nis }}</td>
                  <td>{{ $nm_lengkap }}</td>
                  <td>{{ $nm_jurusan }}</td>
              </tr>
              @endforeach
        </table>

        <p class="mt-3">Apabila permohonan kami di atas dikabulkan / tidak dikabulkan, kami mohon pemberitahuan lebih lanjut.</p>
        <p class="mt-2">Demikian mohon menjadi maklum, atas perhatiannya kami sampaikan terima kasih.</p>

        <div class="img-center">
          <img src="{{ asset('assets/img/ttd-kp.png') }}" alt="ISO" class="Tdd" />
        </div>
        
        </div>
        
      </div>

      <div class="halaman-kedua mt-5">
        <p class="fst-italic text-decoration-underline mb-3">Lampiran</p>

        <p class="text-decoration-underline text-end">.............................................</p>

        <div class="margin-top">

          <p>Nome<span class="colon-space-one">r</span>: ..............................................</p>
          <p>
            Periha<span class="colon-space">l</span>: Praktik Kerja Lapangan (PKL) 
          </p>
        </div>
        <p class="p-margin-top">Kepada Yth,</p>
        <p>Kepala {{ $nm_sekolah }}</p>
        <p>di</p>
        <p class="ms-3">Kuningan</p>
        <p class="mt-3 mb-3">Dengan hormat,</p>
        <p class="mb-3">Menunjuk Surat Saudara nomer 038/102.16/SMK.PTW/HM/2024 {{ $tanggal_Sekarang }} Perihal Permohonan Kerjasama Pelaksanaan Praktik Kerja Lapangan (PKL).</p>
        <p class="mb-4">Dengan ini kami beritahukan bahwa pada prinsipnya <b>Tidak Keberatan / Keberatan *</b> atas permohonan Saudara permohonan Praktik Kerja Lapangan (PKL) bagi siswa/siswi {{ $nm_sekolah }} sebagai berikut :</p>
        
        <table class="border-table">
          <tr>
            <th>No</th>
            <th>Nomer Induk</th>
            <th>Nama Siswa</th>
            <th>Kompetensi Keahlian</th>
          </tr>
          @foreach ($pengajuan as $index => $DataPengajuan)
          <tr>
              <td scope="row">{{ $index + 1 }}</td>
              <td>{{ $DataPengajuan->nis }}</td>
              <td>{{ $nm_lengkap }}</td>
              <td>{{ $nm_jurusan }}</td>
          </tr>
          @endforeach
        </table>

        <p class="margin-bottom mt-4">Adapun waktu pelaksanaan mulai tanggal : {{ $tanggalMasuk->format('d F') . ' s.d. ' .  $tanggalKeluar->format('d F Y') }}</p>
        <p>Demekian pembritahuaan ini kami sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.</p>
        <p class="mt-5 mb-3 text-end margin-end">Hormat kami,</p>
        <p class="mt-3 margin-bottom-p text-end p-margin-end">Pimpinan ...........................</p>
        <p class="text-decoration-underline text-end margin-top-p">......................................................................</p>
        <p class="mt-5">Catatan :</p>

        <ul>
          <p>- *Coret yang tidak perlu</p>
        </ul>
      </div>

        <!-- jQuery (necessary for DataTables plugin) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap Bundle JS -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
