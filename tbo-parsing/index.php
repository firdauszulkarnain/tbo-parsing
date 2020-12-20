<?php
error_reporting(0);
include "validasi.php";
include "functions.php";
session_start();
if (isset($_POST['kalimat'])) {
    $tmp_kalimat = htmlspecialchars($_POST['kalimat']);
    validasi_kalimat($tmp_kalimat);
    $kalimat = strtolower(trim($tmp_kalimat));
    $string = explode(" ", $kalimat);
    $data = cek_data($string);
    if ($data == 0) {
        $result = "RULES TIDAK ADA DI DATABASE";
    } else {
        $result = cek_valid($data);
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href=" https://fonts.googleapis.com/css2?family=Viga&display=swap" rel="stylesheet">
    <link href='assets/img/favicon.ico' rel='shortcut icon'>
    <title>Application of CFG in Syntactic Parsing</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>


<body>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">

                <div class="card text-center p-2 text-light shadow p-3 mb-5 bg-info rounded">
                    <div class="card-body">
                        <h1>Validasi Kalimat Dasar Bahasa Bali</h1>
                        <div class="col-lg-11 mx-auto mt-5">
                            <div class="alert alert-light" id="alert" role="alert">
                                <h3><?= $result; ?></h3>
                            </div>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <textarea class="form-control" id="kalimat" name="kalimat" rows="8" placeholder="Masukan Kalimat Disini..."><?= $tmp_kalimat; ?></textarea>

                                    <button type="submit" class="btn btn-lg btn-light float-right mt-3">Validasi</button>
                                </div>
                            </form>
                            <?php if ($data != 0) : ?>
                                <button type="button" class="btn btn-lg btn-light float-left" data-toggle="modal" data-target="#staticBackdrop">
                                    Tabel CYK
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center">INFORMATIKA</p>
        <p class="text-center mt-n3">TEORI BAHASA DAN OTOMATA</p>




    </div>



    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tabel CYK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-auto">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <?php for ($i = 0; $i <= count($data); $i++) : ?>
                                    <th><?= $i; ?></th>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= count($data); $i++) : ?>
                                <tr>
                                    <th><?= $i; ?></th>
                                    <?php for ($j = 1; $j <= count($data[$i]); $j++) {
                                        $sel = implode(", ", $data[$i][$j]);
                                        if ($sel == "") {
                                            $sel = "&empty;";
                                        }
                                        echo "<td>" . $sel . "</td>";
                                    }
                                    ?>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>