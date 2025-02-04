<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="refresh" content="10"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Gempa</title>

    <!-- Font -->
    <link href="http://fonts.cdnfonts.com/css/ds-digital" rel="stylesheet">

    <!-- Bi Ivon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <!-- Css Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Js Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <!-- CDN Js -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- css datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

    <!-- JS Datatables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <style>
        .hitung {
            font-family: 'DS-Digital', sans-serif;
            font-size: 120px;
            margin-top: -25px;
            margin-bottom: -25px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-display"></i>
                Monitoring
            </a>
        </div>
    </nav>

    <div class="container">

        <h2 class="text-center mt-3 mb-4">Monitoring Gempa & Liquifaksi</h2>

        <!-- Koneksi database mengambil data terkhir masuk -->
        <?php
        session_start();
        if (isset($_SESSION['suhu'])) {
            $suhu = $_SESSION['suhu'];
            $kelembaban = $_SESSION['kelembaban'];
            $getaran = $_SESSION['getaran'];
            echo '<script>
                datamasuk();
                play_sound();
            </script>';
        } else {
            include 'koneksi.php';
            $data = mysqli_query($con, "SELECT * FROM `log` ORDER BY id DESC LIMIT 1;");
            $new = mysqli_fetch_row($data);
            $suhu = $new[3];
            $kelembaban = $new[4];
            $getaran = $new[5];
        }
        ?>


        <div class="row mb-4">

            <!-- Pake Card -->
            <div class="col-md-4">
                <div class="card bg-light mb-3">
                    <div class="card-header"><i class="bi bi-thermometer-half"></i> Suhu</div>
                    <div class="card-body text-center">
                        <div class="hitung"><?= $suhu ?> °C</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light mb-3">
                    <div class="card-header"><i class="bi bi-thermometer-snow"></i> Kelembaban</div>
                    <div class="card-body text-center">
                        <div class="hitung"><?= $kelembaban ?> °F</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light mb-3">
                    <div class="card-header"><i class="bi bi-activity"></i> Getaran</div>
                    <div class="card-body text-center">
                        <div class="hitung"><?= $getaran ?> SR</div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <!-- Tabel menampilkan semua data -->
        <div class="mt-1 mb-5">
            <table class="table caption-top table-bordered" id="myTable">
                <caption>Data Gempa</caption>
                <thead class="table-light">
                    <tr>
                        <td>No</td>
                        <td>Tanggal</td>
                        <td>Waktu</td>
                        <td>Suhu</td>
                        <td>Kelembaban</td>
                        <td>Getaran</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = '1';
                    include 'koneksi.php';
                    // Pakai ini kalau data output PLTB (85 data)
                    $result = mysqli_query($con, "SELECT * FROM log ORDER BY id ASC");
                    // Pakai ini kalau mau Tampilkan data Validasi (15 data)
                    // $result = mysqli_query($con, "SELECT * FROM ina219val ORDER BY id ASC");
                    while ($d = mysqli_fetch_array($result)) {
                    ?>
                        <tr align=center>
                            <td><?= $no++; ?></td>
                            <td><?= $d['tgl']; ?></td>
                            <td><?= $d['wkt']; ?></td>
                            <td><?= $d['suhu']; ?></td>
                            <td><?= $d['kelembaban']; ?></td>
                            <td><?= $d['getaran']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <button onclick="play_sound()"></button>

    <!-- Footer -->
    <nav class="navbar navbar-dark bg-primary mt-1">
        <div class="container">
            <p class="text-center">
            <h5 class="text-white">
                Copyright © 2022 by F55116065 Informatics Engineering
            </h5>
            </p>
        </div>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="datamasuk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Warning</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Telah terjadi Gempa dengan Getaran 3.5 Sr.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">OKe</button> -->
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $('#datamasuk').modal('show');
    });
    
    function datamasuk() {
        $('#datamasuk').modal('show');
    }

    function play_sound() {
        var bel = new Audio('https://www.meramukoding.com/wp-content/uploads/2020/05/doorbell.mp3');
        bel.play();
    }
</script>

</html>