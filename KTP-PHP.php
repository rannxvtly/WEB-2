<?php
$nama = $nik = $tempatLahir = $tanggalLahir = $jenisKelamin = $golonganDarah = $alamat = $rt = $rw = $desa = $kecamatan = $agama = $status = $pekerjaan = $kwn = $berlaku = $kota = $fotoInput = $tanggalCetak = '';

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'] ?? '';
    $nik = $_POST['nik'] ?? '';
    $tempatLahir = $_POST['tempatLahir'] ?? '';
    $tanggalLahir = $_POST['tanggalLahir'] ?? '';
    $jenisKelamin = $_POST['jenisKelamin'] ?? '';
    $golonganDarah = $_POST['golonganDarah'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $rt = $_POST['rt'] ?? '';
    $rw = $_POST['rw'] ?? '';
    $desa = $_POST['desa'] ?? '';
    $kecamatan = $_POST['kecamatan'] ?? '';
    $agama = $_POST['agama'] ?? '';
    $status = $_POST['status'] ?? '';
    $pekerjaan = $_POST['pekerjaan'] ?? '';
    $kwn = $_POST['kwn'] ?? 'WNI';
    $berlaku = $_POST['berlaku'] ?? 'SEUMUR HIDUP';
    $kota = $_POST['kota'] ?? '';
    $tanggalCetak = $_POST['tanggalCetak'] ?? '';

    if (isset($_FILES['fotoInput']) && $_FILES['fotoInput']['error'] == 0) {
        $fotoInput = $_FILES['fotoInput']['name'];
        $fotoTempPath = $_FILES['fotoInput']['tmp_name'];
    
        $uploadDir = 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadFilePath = $uploadDir . basename($fotoInput);

        if (move_uploaded_file($fotoTempPath, $uploadFilePath)) {

            $fotoInput = $uploadFilePath;
        } else {
            $fotoInput = '';
        }
    }
}

function formatDate($date) {
    if (!$date) return '';
    $d = new DateTime($date);
    return $d->format('d-m-Y');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KTP Digital Interaktif</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .form-container {
      margin-bottom: 30px;
      width: 100%;
      max-width: 400px;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-container label {
      display: block;
      margin-top: 10px;
      font-size: 14px;
      color: #333;
    }

    .form-container input, 
    .form-container select {
      margin-top: 5px;
      padding: 8px;
      font-size: 14px;
      width: 100%;
      box-sizing: border-box;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .form-container button {
      margin-top: 20px;
      padding: 10px 15px;
      font-size: 14px;
      cursor: pointer;
      background-color: #1a3e6f;
      color: white;
      border: none;
      border-radius: 4px;
      width: 100%;
    }

    .form-container button:hover {
      background-color: #0d2b4e;
    }

    .ktp-container {
      width: 480px;
      height: auto;
      background: linear-gradient(to right, #d4e6f7, #e6f0fa);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      padding: 20px;
      position: relative;
      border: 1px solid #a8c5e0;
      margin-top: 20px;
    }

    .ktp-header {
      text-align: center;
      margin-bottom: 10px;
    }

    .provinsi, .kabupaten {
      font-size: 12px;
      font-weight: bold;
      letter-spacing: 1px;
      color: #1a3e6f;
    }

    .kabupaten {
      margin-top: 2px;
    }

    .ktp-photo-placeholder {
      position: absolute;
      right: 15px;
      top: 70px;
      width: 80px;
      height: 100px;
      background-color: #c8d9eb;
      border: 1px solid #7a9cc6;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 10px;
      color: #3a5a7a;
    }

    .ktp-content {
      font-size: 10px;
      line-height: 1.4;
      color: #1a3e6f;
      margin-bottom: 5px;
    }

    .ktp-row {
      display: flex;
      margin-bottom: 2px;
    }

    .ktp-label {
      width: 120px;
      font-weight: bold;
    }

    .alamat {
        width: 100px;
    }

    .ktp-value {
      flex: 1;
    }

    .indented-row {
      display: flex;
      margin-bottom: 2px;
      margin-left: 20px; 
    }

    .nik {
      font-size: 14px;
      font-weight: bold;
      letter-spacing: 3px;
      margin-bottom: 5px;
      color: #1a3e6f;
    }

    .footer {
      position: absolute;
      bottom:60px;
      right: 20px;
      text-align: center;
      font-size: 10px;
      color: #1a3e6f;
    }
    
    .photo-preview {
      width: 80px;
      height: 100px;
      object-fit: cover;
    }

    .row-with-gap {
      display: flex;
      gap: 10px;
    }

    .row-with-gap > 
    div {
      flex: 1;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2 style="text-align: center; color: #1a3e6f;">Form Data KTP</h2>

    <form method="POST" enctype="multipart/form-data">
      <label>Nama: <input type="text" name="nama" value="<?= htmlspecialchars($nama); ?>" placeholder="Masukkan nama lengkap"></label>
      <label>NIK: <input type="text" name="nik" value="<?= htmlspecialchars($nik); ?>" placeholder="16 digit angka" maxlength="16"></label>
      
      <div style="display: flex; gap: 10px;">
        <div style="flex: 1;">
          <label>Tempat Lahir: <input type="text" name="tempatLahir" value="<?= htmlspecialchars($tempatLahir); ?>" placeholder="Kota kelahiran"></label>
        </div>
        <div style="flex: 1;">
          <label>Tanggal Lahir: <input type="date" name="tanggalLahir" value="<?= htmlspecialchars($tanggalLahir); ?>"></label>
        </div>
      </div>
      
      <div class="row-with-gap">
        <div>
          <label>Jenis Kelamin: 
            <select name="jenisKelamin">
              <option value="LAKI-LAKI" <?= $jenisKelamin == 'LAKI-LAKI' ? 'selected' : ''; ?>>Laki-Laki</option>
              <option value="PEREMPUAN" <?= $jenisKelamin == 'PEREMPUAN' ? 'selected' : ''; ?>>Perempuan</option>
            </select>
          </label>
        </div>
        <div>
          <label>Gol. Darah: 
            <select name="golonganDarah">
              <option value="A" <?= $golonganDarah == 'A' ? 'selected' : ''; ?>>A</option>
              <option value="B" <?= $golonganDarah == 'B' ? 'selected' : ''; ?>>B</option>
              <option value="AB" <?= $golonganDarah == 'AB' ? 'selected' : ''; ?>>AB</option>
              <option value="O" <?= $golonganDarah == 'O' ? 'selected' : ''; ?>>O</option>
            </select>
          </label>
        </div>
      </div>
      
      <label>Alamat: <input type="text" name="alamat" value="<?= htmlspecialchars($alamat); ?>" placeholder="Masukkan alamat lengkap"></label>
      
      <div style="display: flex; gap: 10px;">
        <div style="flex: 1;">
          <label>RT: <input type="text" name="rt" value="<?= htmlspecialchars($rt); ?>" placeholder="3 digit" maxlength="3"></label>
        </div>
        <div style="flex: 1;">
          <label>RW: <input type="text" name="rw" value="<?= htmlspecialchars($rw); ?>" placeholder="3 digit" maxlength="3"></label>
        </div>
      </div>
      
      <label>Kel/Desa: <input type="text" name="desa" value="<?= htmlspecialchars($desa); ?>" placeholder="Nama kelurahan/desa"></label>
      <label>Kecamatan: <input type="text" name="kecamatan" value="<?= htmlspecialchars($kecamatan); ?>" placeholder="Nama kecamatan"></label>
      
      <label>Agama: 
        <select name="agama">
          <option value="ISLAM" <?= $agama == 'ISLAM' ? 'selected' : ''; ?>>Islam</option>
          <option value="KRISTEN" <?= $agama == 'KRISTEN' ? 'selected' : ''; ?>>Kristen</option>
          <option value="KATOLIK" <?= $agama == 'KATOLIK' ? 'selected' : ''; ?>>Katolik</option>
          <option value="HINDU" <?= $agama == 'HINDU' ? 'selected' : ''; ?>>Hindu</option>
          <option value="BUDDHA" <?= $agama == 'BUDDHA' ? 'selected' : ''; ?>>Buddha</option>
          <option value="KONGHUCU" <?= $agama == 'KONGHUCU' ? 'selected' : ''; ?>>Konghucu</option>
        </select>
      </label>
      
      <label>Status Perkawinan: 
        <select name="status">
          <option value="BELUM KAWIN" <?= $status == 'BELUM KAWIN' ? 'selected' : ''; ?>>Belum Kawin</option>
          <option value="KAWIN" <?= $status == 'KAWIN' ? 'selected' : ''; ?>>Kawin</option>
          <option value="CERAI HIDUP" <?= $status == 'CERAI HIDUP' ? 'selected' : ''; ?>>Cerai Hidup</option>
          <option value="CERAI MATI" <?= $status == 'CERAI MATI' ? 'selected' : ''; ?>>Cerai Mati</option>
        </select>
      </label>
      
      <label>Pekerjaan: <input type="text" name="pekerjaan" value="<?= htmlspecialchars($pekerjaan); ?>" placeholder="Pekerjaan saat ini"></label>
      
      <label>Kewarganegaraan: 
        <select name="kwn">
          <option value="WNI" <?= $kwn == 'WNI' ? 'selected' : ''; ?>>WNI</option>
          <option value="WNA" <?= $kwn == 'WNA' ? 'selected' : ''; ?>>WNA</option>
        </select>
      </label>
      
      <label>Berlaku Hingga: 
        <select name="berlaku">
          <option value="SEUMUR HIDUP" <?= $berlaku == 'SEUMUR HIDUP' ? 'selected' : ''; ?>>Seumur Hidup</option>
          <option value="5 TAHUN" <?= $berlaku == '5 TAHUN' ? 'selected' : ''; ?>>5 Tahun</option>
          <option value="10 TAHUN" <?= $berlaku == '10 TAHUN' ? 'selected' : ''; ?>>10 Tahun</option>
        </select>
      </label>
      
      <label>Kota/Kabupaten: <input type="text" name="kota" value="<?= htmlspecialchars($kota); ?>" placeholder="Nama kota/kabupaten"></label>
      
      <label>Foto: 
        <input type="file" name="fotoInput" accept="image/*">
      </label>
      
      <label>Tanggal Cetak: <input type="date" name="tanggalCetak" value="<?= htmlspecialchars($tanggalCetak); ?>"></label>

      <button type="submit">Cetak KTP</button>
      <button type="reset" style="margin-top: 10px; background-color: #6c757d;">Reset Form</button>
    </form>
  </div>

  <div class="ktp-container">
    <div class="ktp-header">
      <div class="provinsi">PROVINSI JAWA BARAT</div>
      <div class="kabupaten">KABUPATEN <?= htmlspecialchars($kota) ?: 'PURWAKARTA'; ?></div>
    </div>
    
    <div class="nik">NIK : <?= htmlspecialchars($nik) ?: '321431407050003'; ?></div>

    <div class="ktp-content">
      <div class="ktp-row">
        <div class="ktp-label">Nama</div>
        <div class="ktp-value"><?= htmlspecialchars($nama); ?></div>
      </div>
      <div class="ktp-row">
        <div class="ktp-label">Tempat/Tgl Lahir</div>
        <div class="ktp-value"><?= htmlspecialchars($tempatLahir) . ', ' . formatDate($tanggalLahir); ?></div>
      </div>
      <div class="ktp-row">
        <div class="ktp-label">Jenis Kelamin</div>
        <div class="ktp-value"><?= htmlspecialchars($jenisKelamin); ?></div>
        <div class="ktp-label" style="width:60px;margin-left:10px;">Gol. Darah</div>
        <div class="ktp-value"><?= htmlspecialchars($golonganDarah); ?></div>
      </div>
      <div class="ktp-row">
        <div class="ktp-label">Alamat</div>
        <div class="ktp-value"><?= htmlspecialchars($alamat); ?></div>
      </div>
      <div class="indented-row">
        <div class="ktp-label alamat">RT/RW</div>
        <div class="ktp-value"><?= str_pad($rt, 3, '0', STR_PAD_LEFT) . '/' . str_pad($rw, 3, '0', STR_PAD_LEFT); ?></div>
      </div>
      <div class="indented-row">
        <div class="ktp-label alamat">Kel/Desa</div>
        <div class="ktp-value"><?= htmlspecialchars($desa); ?></div>
      </div>
      <div class="indented-row">
        <div class="ktp-label alamat">Kecamatan</div>
        <div class="ktp-value"><?= htmlspecialchars($kecamatan); ?></div>
      </div>
      <div class="ktp-row">
        <div class="ktp-label">Agama</div>
        <div class="ktp-value"><?= htmlspecialchars($agama); ?></div>
      </div>
      <div class="ktp-row">
        <div class="ktp-label">Status Perkawinan</div>
        <div class="ktp-value"><?= htmlspecialchars($status); ?></div>
      </div>
      <div class="ktp-row">
        <div class="ktp-label">Pekerjaan</div>
        <div class="ktp-value"><?= htmlspecialchars($pekerjaan); ?></div>
      </div>
      <div class="ktp-row">
        <div class="ktp-label">Kewarganegaraan</div>
        <div class="ktp-value"><?= htmlspecialchars($kwn); ?></div>
      </div>
      <div class="ktp-row">
        <div class="ktp-label">Berlaku Hingga</div>
        <div class="ktp-value"><?= htmlspecialchars($berlaku); ?></div>
      </div>
    </div>

    <div class="ktp-photo-placeholder">
      <?php if ($fotoInput): ?>
        <img src="<?= $fotoInput; ?>" class="photo-preview" alt="Foto KTP">
      <?php else: ?>
        <span id="photoPlaceholderText">FOTO</span>
      <?php endif; ?>
    </div>

    <div class="footer">
      <span><?= htmlspecialchars($kota) ?: 'PURWAKARTA'; ?></span><br>
      <span><?= formatDate($tanggalCetak); ?></span>
    </div>
  </div>

</body>
</html>