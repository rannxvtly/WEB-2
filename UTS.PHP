<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Nilai Akhir Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            width: 60%;
            background: #fff;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            margin-top: 20px;
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        .hasil {
            margin-top: 30px;
            background: #eafaf1;
            padding: 20px;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #66bb6a;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Perhitungan Nilai Akhir Kuliah</h1>
    <p><strong>Nama:</strong>Kirana Larasati Dewi</p>
        <p><strong>NIM:</strong> 202404009 </p>
        <p><strong>Prodi:</strong> Teknologi Rekayasa Perangkat Lunak </p><br>

    <?php
    // ===== Ambil list mahasiswa bila dikirim ulang dari hidden input =====
    if (isset($_POST['list_mhs'])) {
        $mahasiswa = explode("|", $_POST['list_mhs']);
    } else {
        $mahasiswa = array("Kirana Larasati Dewi", "Zahra Ayu Trisna", "Intan Sri Dayanti", "Al Amani Abas");
    }

    // ===== Tambah mahasiswa baru =====
    if (isset($_POST['tambah_mhs'])) {
        $baru = trim($_POST['nama_baru']);
        if ($baru !== "" && !in_array($baru, $mahasiswa)) {
            $mahasiswa[] = $baru;
        }
    }

    // Komponen penilaian
    $komponen = array(
        "kehadiran" => 0.10,
        "tugas" => 0.20,
        "uts" => 0.30,
        "uas" => 0.40
    );
    ?>

    <!-- FORM TAMBAH MAHASISWA -->
    <h2>Tambah Mahasiswa</h2>
    <form method="POST">
        <label>Nama Mahasiswa Baru:</label>
        <input type="text" name="nama_baru" required>

        <!-- Kirim ulang daftar mahasiswa -->
        <input type="hidden" name="list_mhs" value="<?php echo implode('|', $mahasiswa); ?>">

        <input type="submit" name="tambah_mhs" value="Tambah">
    </form>

    <hr><br>

    <!-- FORM HITUNG NILAI -->
    <form method="POST">
        <label>Nama Mahasiswa:</label>
        <select name="nama" required>
            <option value="" disabled selected>Pilih Nama Mahasiswa</option>
            <?php
            foreach ($mahasiswa as $nama) {
                echo "<option value='$nama'>$nama</option>";
            }
            ?>
        </select>

        <?php
        foreach ($komponen as $key => $value) {
            echo "<label>Nilai " . ucfirst($key) . " (0-100):</label>";
            echo "<input type='number' name='$key' min='0' max='100' step='0.1' required>";
        }
        ?>

        <!-- Kirim ulang daftar mahasiswa ke form -->
        <input type="hidden" name="list_mhs" value="<?php echo implode('|', $mahasiswa); ?>">

        <input type="submit" name="proses" value="Hitung Nilai">
    </form>

    <?php
    // fungsi menghitung nilai akhir
    function hitungNilaiAkhir($nilai, $persentase) {
        $total = 0;
        foreach ($nilai as $k => $v) {
            $total += $v * $persentase[$k];
        }
        return $total;
    }

    // fungsi nilai huruf
    function nilaiHuruf($angka) {
        if ($angka >= 90) return "A";
        elseif ($angka >= 80) return "AB";
        elseif ($angka >= 70) return "B";
        elseif ($angka >= 60) return "BC";
        elseif ($angka >= 50) return "C";
        elseif ($angka >= 40) return "D";
        else return "E";
    }

    // Jika tombol proses ditekan
    if (isset($_POST['proses'])) {
        $nama = $_POST['nama'];
        $nilai_array = array(
            "kehadiran" => $_POST['kehadiran'],
            "tugas" => $_POST['tugas'],
            "uts" => $_POST['uts'],
            "uas" => $_POST['uas']
        );

        $nilai_akhir = hitungNilaiAkhir($nilai_array, $komponen);
        $huruf = nilaiHuruf($nilai_akhir);

        echo "<div class='hasil'>
            <h2>Hasil Perhitungan Nilai</h2>

            <table>
                <tr>
                    <th>Komponen</th>
                    <th>Nilai</th>
                    <th>Bobot (%)</th>
                    <th>Kontribusi</th>
                </tr>";

                foreach ($nilai_array as $k => $v) {
                    $persen = $komponen[$k] * 100;
                    $kontribusi = $v * $komponen[$k];

                    echo "<tr>
                            <td>" . ucfirst($k) . "</td>
                            <td>$v</td>
                            <td>$persen%</td>
                            <td>" . number_format($kontribusi, 2) . "</td>
                        </tr>";
                }

        echo "
                <tr style='background:#f0f0f0; font-weight:bold;'>
                    <td colspan='3'>Total Nilai Akhir</td>
                    <td>" . number_format($nilai_akhir, 2) . "</td>
                </tr>

                <tr style='background:#fde2e4; font-weight:bold;'>
                    <td colspan='3'>Nilai Huruf</td>
                    <td>$huruf</td>
                </tr>
            </table>
        </div>";
    }
    ?>
</div>
</body>
</html>
