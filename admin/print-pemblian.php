<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
ob_start();

?>

<!-- Halaman edit isi laporan-->

    </<!DOCTYPE html>
    <html>
    <head>
        <title></title>
         </head>
    <body>
    <h3 align="center">Jember Green Herbalist</h3>
    <h5 align="center">Jl. Kaliurang No.63, Krajan Barat</h5>
    <h5 align="center">Kabupaten Jember</h5><hr><br>

    <h4 align="center">Laporan Data Pembelian</h4>
    <center>
    <table border="1" cellpadding="10" cellspacing="0">
                      
                        <tr align="center">
                          <th>No</th>
                          <th>Nama Pelanggan</th>
                          <th>Tanggal</th>
                          <th>Status Pembelian</th>
                          <th>Total</th>

                        </tr>

                        <?php 
                        include '../koneksi/koneksi.php';
                        $no = '1';
                        $data = mysqli_query($koneksi, "SELECT * FROM tb_pembelian JOIN tb_user ON tb_pembelian.id_user=tb_user.id_user");
                        while($row = mysqli_fetch_array($data)){ ?>

                          <tr align="center">
                            <td><?php echo $no++; ?></td>
                             <td><?php echo $row['nama_depan'] . ' '. $row['nama_belakang']; ?></td>
                             <td><?php echo $row['tanggal_pembelian'] ?></td>
                             <td><?php echo $row['status_pembelian'] ?></td>
                             <td>Rp. <?php echo number_format($row['total_pembelian']); ?></td>
                                                     
                          </tr>
                        <?php } ?>
                      
                    </table>
                    </center>
                    <br><br><br><br><br><br>
                    <?php 
                    $tanggal = date("d M Y");
                    ?>
                    <h6 align="right"> Jember, <?php echo $tanggal; ?> </h6>
                    <h6 align="right">Penanggung Jawab,</h6><br>
                    <br><br>
                    <?php if ($_SESSION['id_level']=="1"): ?>
                      <h6 align="right"><?php echo $_SESSION['admin']['nama_depan'] . ' ' . $_SESSION['admin']['nama_belakang']; ?></h6>

                    <?php elseif ($_SESSION['id_level']=="3") : ?>
                      <h6 align="right"><?php echo $_SESSION['superadmin']['nama_depan'] . ' ' . $_SESSION['superadmin']['nama_belakang']; ?></h6>
                 
                    <?php endif ?>
                    </h6>
    </html>
    

<?php
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output();
?>