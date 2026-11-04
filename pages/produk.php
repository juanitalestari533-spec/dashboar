<?php
include 'koneksi.php';
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $hapus = mysqli_query(
        $dbconnect, "DELETE FROM produk1 WHERE id_barang = $id");

    if ($hapus) {
        echo "<script> 
        alert('Produk berhasil dihapus');
        window.location.href='index.php?pages=products';
              </script>";
              exit;
        } else {

        echo "<script>
                alert('Produk gagal dihapus');
              </script>";

    }
}

// ================= TAMBAHAN: PROSES TAMBAH PRODUK =================
if (isset($_POST['tambah'])) {
    $nama  = $_POST['nama_barang'];
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];

    $namaGambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $namaGambar = time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'img/' . $namaGambar);
    }

    $stmt = mysqli_prepare($dbconnect,
        "INSERT INTO produk1 (nama_barang, gambar, harga, stok) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssii", $nama, $namaGambar, $harga, $stok);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Produk berhasil ditambahkan');
                window.location.href='index.php?pages=products';
              </script>";
        exit;
    } else {
        echo "<script>alert('Produk gagal ditambahkan');</script>";
    }
}

// ================= TAMBAHAN: PROSES EDIT PRODUK =================
if (isset($_POST['edit'])) {
    $id    = (int) $_POST['id_barang'];
    $nama  = $_POST['nama_barang'];
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];

    if (!empty($_FILES['gambar']['name'])) {
        $namaGambar = time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'img/' . $namaGambar);

        $stmt = mysqli_prepare($dbconnect,
            "UPDATE produk1 SET nama_barang=?, harga=?, stok=?, gambar=? WHERE id_barang=?");
        mysqli_stmt_bind_param($stmt, "siisi", $nama, $harga, $stok, $namaGambar, $id);
    } else {
        $stmt = mysqli_prepare($dbconnect,
            "UPDATE produk1 SET nama_barang=?, harga=?, stok=? WHERE id_barang=?");
        mysqli_stmt_bind_param($stmt, "siii", $nama, $harga, $stok, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Produk berhasil diupdate');
                window.location.href='index.php?pages=products';
              </script>";
        exit;
    } else {
        echo "<script>alert('Produk gagal diupdate');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <main class="col-12 col-md-10">
            <div class="container py-4">
                <h2 class="fw-bold">Produk</h2>
                <h4 class="mt-4 mb-3">Halaman Produk</h4>

                <!-- TAMBAHAN: tombol Add Product membuka modal (menggantikan link phpMyAdmin) -->
                <button type="button" class="btn btn-dark btn-sm mb-3"
                        data-bs-toggle="modal" data-bs-target="#modalTambah">
                    Add Product
                </button>

                <!-- TAMBAHAN: MODAL TAMBAH PRODUK -->
                <div class="modal fade" id="modalTambah" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Produk</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- TABEL PRODUK -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered bg-white align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>gambar</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead> 
                       <tbody>
                        <?php
                        include 'koneksi.php';
                        $query = mysqli_query($dbconnect,"SELECT * FROM produk1");
                        $no=1;
                        while($tampil = mysqli_fetch_assoc($query)){
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $tampil['nama_barang']; ?></td>
                            <td><img src="img/<?= $tampil['gambar']; ?>" width="70" height="70" style="object-fit: cover;"></td>
                            <td><?= $tampil['harga']; ?></td>
                            <td><?= $tampil['stok']; ?></td>
                            <td>
                              <a href="?pages=products&hapus=<?= $tampil['id_barang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">  Hapus </a>

                              <!-- TAMBAHAN: tombol Edit membuka modal (menggantikan link phpMyAdmin) -->
                              <button type="button" class="btn btn-success btn-sm"
                                      data-bs-toggle="modal"
                                      data-bs-target="#modalEdit<?= $tampil['id_barang']; ?>">
                                  Edit
                              </button>

                              <!-- TAMBAHAN: MODAL EDIT PRODUK -->
                              <div class="modal fade" id="modalEdit<?= $tampil['id_barang']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Edit Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>
                                      <div class="modal-body">
                                        <input type="hidden" name="id_barang" value="<?= $tampil['id_barang']; ?>">

                                        <div class="mb-3">
                                          <label class="form-label">Nama Barang</label>
                                          <input type="text" name="nama_barang" class="form-control"
                                                 value="<?= htmlspecialchars($tampil['nama_barang']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label">Harga</label>
                                          <input type="number" name="harga" class="form-control"
                                                 value="<?= $tampil['harga']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label">Stok</label>
                                          <input type="number" name="stok" class="form-control"
                                                 value="<?= $tampil['stok']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label">Gambar (kosongkan jika tidak diganti)</label><br>
                                          <img src="img/<?= htmlspecialchars($tampil['gambar']); ?>" width="70" class="mb-2"><br>
                                          <input type="file" name="gambar" class="form-control" accept="image/*">
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </td>
                        </tr>
                    </tbody>
                        <?php
                        }
                        ?>
                    </thead>
                    <tbody>
                    </tbody>  
                    </table>
                </div>
            </div>
        </main>
</body>
</html>