<?php include_once "partials/cssdatatables.php" ?>

<div class="content-header">
    <div class="container-fluid">
        <?php   
        if (isset($_SESSION["hasil"])){
            if ($_SESSION["hasil"]) {
        ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                    <?php echo $_SESSION["pesan"] ?>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                    <?php echo $_SESSION["pesan"] ?>
                </div>
        <?php  
            }
            unset($_SESSION['hasil']);
            unset($_SESSION['pesan']);
        }
        ?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penggajian Rekap</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="?page=home"> Home</a>
                    </li>
                    <li class="breadcrumb-item">Penggajian Rekap</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Rekap Gaji</h3>
            <a href="export/penggajianrekap-pdf.php"
                class="btn btn-success btn-sm float-right">
                <i class="fa fa-"></i> Export PDF</a>
        </div>
        <div class="card-body">
        <table id="mytable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Unag Makan</th>
                <th>Total</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Unag Makan</th>
                <th>Total</th>
                <th>Opsi</th>
            </tr>
        </tfoot>
        <tbody>
        </tbody>
        <?php
        $database = new Database();
        $db = $database->getConnection();
        $selectSql = "SELECT tahun,
                            SUM(P.gapok) jumlah_gapok,
                            SUM(P.tunjangan) jumlah_tunjangan,
                            SUM(P.uang_makan) jumlah_uang_makan,
                            SUM(P.gapok) + SUM(P.tunjangan) + SUM(P.uang_makan) total
                            FROM penggajian P
                            GROUP BY tahun;";
        $stmt = $db->prepare($selectSql);
        $stmt->execute();
        $no = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $row['tahun'] ?></td>
            <td style="text-align: right;"><?php echo number_format($row['jumlah_gapok'])?></td>
            <td style="text-align: right;"><?php echo number_format($row['jumlah_tunjangan'])?></td>
            <td style="text-align: right;"><?php echo number_format($row['jumlah_uang_makan'])?></td>
            <td style="text-align: right;"><?php echo number_format($row['total'])?></td>
            <td>
                <a href="?page=penggajianrekaptahun&tahun=<?php echo $row['tahun']?>"
                class="btn btn-info btn-sm mt-1"><i class="fa fa-info"> Rincian</i></a>
            </td>
        </tr>
        <?php
        }
        ?>
        </tbody>
        </table>
        </div>
    </div>
</div>

    <!-- /.content -->
<?php include "partials/scripts.php" ?>
<?php include_once "partials/scripts.php" ?>
<?php include_once "partials/scriptsdatatables.php" ?>
<script>
    $(function() {
        $("#mytable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy","csv","excel","pdf","print","colvis"]
        }).buttons().container().appendTo('#mytable_wrapper .col-md-6:eq(0)');
    });
</script>