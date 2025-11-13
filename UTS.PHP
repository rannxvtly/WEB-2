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
            color: #333;
        }
        .info{
            margin-top: 15px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
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
            transition: 0.3s;
            width: 100%;
        }
        input[type="submit"]:hover {
            background: #218838;
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
            background-color: #28a745;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Perhitungan Nilai Akhir Kuliah</h1>
    <div class="info">
        <p><strong>Nama:</strong>Kirana Larasati Dewi</p>
        <p><strong>NIM:</strong> 202404009 </p>
        <p><strong>NIM:</strong> Teknologi Rekayasa Perangkat Lunak </p><br>

    <?php
    $mahasiswa = array("Kirana Larasati Dewi", "Zahra Ayu Trisna", "Intan Sri Dayanti", "Al Amani Abas");
    $komponen = array(
        "kehadiran" => 0.10,
        "tugas" => 0.20,
        "uts" => 0.30,
        "uas" => 0.40
    );
    ?>

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

        <input type="submit" name="proses" value="Hitung Nilai">
    </form>

    <?php
    function hitungNilaiAkhir($nilai, $persentase) {
        $total = 0;
        foreach ($nilai as $komponen => $angka) {
            $total += $angka * $persentase[$komponen];
        }
        return $total;
    }

    function nilaiHuruf($angka) {
        if ($angka >= 90) return "A";
        elseif ($angka >= 80) return "AB";
        elseif ($angka >= 70) return "B";
        elseif ($angka >= 60) return "BC";
        elseif ($angka >= 50) return "C";
        elseif ($angka >= 40) return "D";
        else return "E";
    }

    if (isset($_POST['proses'])) {
        $nama = $_POST['nama'];
        $kehadiran = $_POST['kehadiran'];
        $tugas = $_POST['tugas'];
        $uts = $_POST['uts'];
        $uas = $_POST['uas'];

        
        $nilai_array = array(
            "kehadiran" => $kehadiran,
            "tugas" => $tugas,
            "uts" => $uts,
            "uas" => $uas
        );

        $nilai_akhir = hitungNilaiAkhir($nilai_array, $komponen);
        $huruf = nilaiHuruf($nilai_akhir);

        switch ($huruf) {
            case "A": $keterangan = "Sangat Baik"; break;
            case "AB": $keterangan = "Baik"; break;
            case "B": $keterangan = "Cukup Baik"; break;
            case "BC": $keterangan = "Cukup"; break;
            case "C": $keterangan = "Kurang"; break;
            case "D": $keterangan = "Sangat Kurang"; break;
            case "E": $keterangan = "Gagal"; break;
            default: $keterangan = "Tidak Lulus";
        }

        echo "<div class='hasil'>
            <h2>Hasil Perhitungan Nilai Akhir</h2>
            <table>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Kehadiran</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Nilai Akhir</th>
                    <th>Nilai Huruf</th>
                </tr>
                <tr>
                    <td>$nama</td>
                    <td>$kehadiran</td>
                    <td>$tugas</td>
                    <td>$uts</td>
                    <td>$uas</td>
                    <td>" . number_format($nilai_akhir, 2) . "</td>
                    <td>$huruf</td>
                </tr>
            </table>
            <p><strong>Keterangan:</strong> $keterangan</p>
        </div>";
    }
    ?>
</div>
</body>
</html>

