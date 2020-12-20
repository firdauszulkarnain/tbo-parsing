<?php

function validasi_kalimat($data)
{

    if (empty($data)) {
        echo    "<script>
        alert('Inputkan Kalimat')
        document.location.href = 'index.php';
        </script>";
    }
}
