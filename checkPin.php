<?php
// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Periksa apakah parameter idUser dikirim melalui metode POST
if (isset($_POST['id_transaksi']) && isset($_POST['pin']) && isset($_POST['nama_penyedia']) ){
    // Escape string untuk mencegah serangan SQL injection
    $id_transaksi = htmlspecialchars($_POST['id_transaksi']);
    $pin = htmlspecialchars($_POST['pin']);

    $url = "http://localhost:8000/transaksi/" . $id_transaksi;
    // cara dulu nama penyedianya apa 


    $nama_penyedia = htmlspecialchars($_POST['nama_penyedia']);

    // URL endpoint API
    $url = "http://localhost:8000/" . $nama_penyedia . "/bayar";

    $ch = curl_init();

    // Setel opsi cURL untuk metode PUT
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);

    // Periksa kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Tutup cURL
        curl_close($ch);
        // Tampilkan respons dari server
        echo $response;
    }

}
// elseif()

?>