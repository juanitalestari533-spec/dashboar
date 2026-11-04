<?php
if(isset($_GET['pages'])){
    $page=$_GET['pages'];
}else{
    $page="dashboard";
}
$halaman=[
    "dashboard" => "pages/dashboard.php", //perhatikan pagesnya ini berfungsi menyambungkan ke botton hapus
    "products" => "pages/produk.php",
    "orders" => "pages/orders.php",
    "customers" => "pages/customers.php"
];
if(isset($halaman[$page])){
    require $halaman[$page];
}else{
    echo "<h1>Halaman Tidak Ditemukan</h1>";
}
?>