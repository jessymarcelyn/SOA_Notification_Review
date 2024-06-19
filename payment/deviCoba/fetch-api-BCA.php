<?php

// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

if(isset($_POST['id_pesanan'])){
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);

    // Hardcoded nominal for example purposes
    $nominal = 100000;

    // URL endpoint API
    $url = "http://localhost:8000/Tpembayaran";

    // Inisialisasi cURL
    $ch = curl_init();

    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        "id_pesanan" => $id_pesanan,
        "total_transaksi" => $nominal
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);

    // Periksa kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        curl_close($ch);
    } else {
        // Tutup cURL
        curl_close($ch);

        $result = json_decode($response, true);

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON response';
            echo "<script>console.log('HALO');</script>";
        } else {
            // Output the response from API
            echo 'Response from API: ' . json_encode($result);
            echo "<script>console.log('HALO');</script>";
        }
    }

}

elseif (isset($_POST['id_pesanan']) && ($_POST['id_pesanan2'])) {
    echo ("masuk1");
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    $id_pesanan2 = htmlspecialchars($_POST['id_pesanan2']);
    echo "<script>console.log('HALO');</script>";
    // Hardcoded nominal for example purposes
    $nominal = 200000;

    // URL endpoint API
    $url = "http://localhost:8000/Tpembayaran";

    // Inisialisasi cURL
    $ch = curl_init();

    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        "id_pesanan" => $id_pesanan,
        "id_pesanan2" => $id_pesanan2,
        "total_transaksi" => $nominal
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);

    // Periksa kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        curl_close($ch);
    } else {
        // Tutup cURL
        curl_close($ch);

        // Decode response JSON menjadi array asosiatif
        $result = json_decode($response, true);

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
          
            echo 'Error decoding JSON response';
        } else {
            // Output the response from API
            echo 'Response from API: ' . json_encode($result);
        }
    }
}

?>