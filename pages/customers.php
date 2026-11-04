<?php
include 'koneksi.php';
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $hapus = mysqli_query(
        $dbconnect, "DELETE FROM customers WHERE id_customer = $id");

    if ($hapus) {
        echo "<script> 
        alert('Customer berhasil dihapus');
        window.location.href='index.php?pages=customers';
              </script>";
              exit;
        } else {

        echo "<script>
                alert('Produk gagal dihapus');
              </script>";

    }
}

// ================= TAMBAHAN: PROSES TAMBAH =================
if (isset($_POST['tambah'])) {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $no_hp    = $_POST['no_hp'];
    $alamat   = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($dbconnect,
        "INSERT INTO customers (nama, email, no_hp, alamat, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssss", $nama, $email, $no_hp, $alamat, $username, $password);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Customer berhasil ditambahkan');
                window.location.href='index.php?pages=customers';
              </script>";
        exit;
    } else {
        echo "<script>alert('Customer gagal ditambahkan');</script>";
    }
}

// ================= TAMBAHAN: PROSES EDIT =================
if (isset($_POST['edit'])) {
    $id       = (int) $_POST['id_customer'];
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $no_hp    = $_POST['no_hp'];
    $alamat   = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($dbconnect,
        "UPDATE customers SET nama=?, email=?, no_hp=?, alamat=?, username=?, password=? WHERE id_customer=?");
    mysqli_stmt_bind_param($stmt, "ssssssi", $nama, $email, $no_hp, $alamat, $username, $password, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Customer berhasil diupdate');
                window.location.href='index.php?pages=customers';
              </script>";
        exit;
    } else {
        echo "<script>alert('Customer gagal diupdate');</script>";
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
                <h2 class="fw-bold">Customers</h2>
                <h4 class="mt-4 mb-3">Halaman Customers</h4>

                <!-- TAMBAHAN: tombol Add membuka modal (menggantikan link phpMyAdmin) -->
                <button type="button" class="btn btn-dark btn-sm mb-3"
                        data-bs-toggle="modal" data-bs-target="#modalTambah">
                    Add Customers
                </button>

                <!-- TAMBAHAN: MODAL TAMBAH -->
                <div class="modal fade" id="modalTambah" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="POST">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Customer</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">No Hp</label>
                            <input type="text" name="no_hp" class="form-control" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" required></textarea>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" name="password" class="form-control" required>
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Hp</th>
                                <th>Alamat</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead> 
                        <tbody>
                        <?php
                        include 'koneksi.php';
                        $query = mysqli_query($dbconnect,"SELECT * FROM customers");
                        $no=1;
                        while($tampil = mysqli_fetch_assoc($query)){
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $tampil['nama']; ?></td>
                            <td><?= $tampil['email']; ?></td>
                            <td><?= $tampil['no_hp']; ?></td>
                            <td><?= $tampil['alamat']; ?></td>
                            <td><?= $tampil['username']; ?></td>
                            <td><?= $tampil['password']; ?></td>
                            <td>
                               <a href="?pages=customers&hapus=<?= $tampil['id_customer']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">  Hapus </a>

                               <!-- TAMBAHAN: tombol Edit membuka modal (menggantikan link phpMyAdmin) -->
                               <button type="button" class="btn btn-success btn-sm"
                                       data-bs-toggle="modal"
                                       data-bs-target="#modalEdit<?= $tampil['id_customer']; ?>">
                                   Edit
                               </button>

                               <!-- TAMBAHAN: MODAL EDIT -->
                               <div class="modal fade" id="modalEdit<?= $tampil['id_customer']; ?>" tabindex="-1">
                                 <div class="modal-dialog">
                                   <div class="modal-content">
                                     <form method="POST">
                                       <div class="modal-header">
                                         <h5 class="modal-title">Edit Customer</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                       </div>
                                       <div class="modal-body">
                                         <input type="hidden" name="id_customer" value="<?= $tampil['id_customer']; ?>">

                                         <div class="mb-3">
                                           <label class="form-label">Nama</label>
                                           <input type="text" name="nama" class="form-control"
                                                  value="<?= htmlspecialchars($tampil['nama']); ?>" required>
                                         </div>
                                         <div class="mb-3">
                                           <label class="form-label">Email</label>
                                           <input type="email" name="email" class="form-control"
                                                  value="<?= htmlspecialchars($tampil['email']); ?>" required>
                                         </div>
                                         <div class="mb-3">
                                           <label class="form-label">No Hp</label>
                                           <input type="text" name="no_hp" class="form-control"
                                                  value="<?= htmlspecialchars($tampil['no_hp']); ?>" required>
                                         </div>
                                         <div class="mb-3">
                                           <label class="form-label">Alamat</label>
                                           <textarea name="alamat" class="form-control" rows="2" required><?= htmlspecialchars($tampil['alamat']); ?></textarea>
                                         </div>
                                         <div class="mb-3">
                                           <label class="form-label">Username</label>
                                           <input type="text" name="username" class="form-control"
                                                  value="<?= htmlspecialchars($tampil['username']); ?>" required>
                                         </div>
                                         <div class="mb-3">
                                           <label class="form-label">Password</label>
                                           <input type="text" name="password" class="form-control"
                                                  value="<?= htmlspecialchars($tampil['password']); ?>" required>
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
                    </table>
                </div>
            </div>
        </main>
</body>
</html>