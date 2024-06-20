<?php
// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

function getNamaPenyedia($id_transaksi)
{
    $url = "http://localhost:8000/Tpembayaran/IDTransaksi/" . $id_transaksi;

    // Inisialisasi cURL
    $ch = curl_init();

    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);
    $nama_penyedia="lala";

    // Periksa kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Tutup cURL
        curl_close($ch);

        // Decode response JSON menjadi array asosiatif
        $notifications = json_decode($response, true);

        //karna return ada code dan data
        $notifications = $notifications['data'];


        if ($notifications === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON: ' . json_last_error_msg();
        } else {

            // Loop melalui hasil response untuk mengambil data notifikasi
            foreach ($notifications as $row) {
                // Ambil data notifikasi
                $nama_penyedia = $row['nama_penyedia'];

            }

        }
    }
    return $nama_penyedia;
}

// Periksa apakah parameter idUser dikirim melalui metode POST
if (isset($_POST['id_transaksi']) && isset($_POST['pin'])) {

    // Escape string untuk mencegah serangan SQL injection
    $id_transaksi = htmlspecialchars($_POST['id_transaksi']);
    $pin = htmlspecialchars($_POST['pin']);

    $nama_penyedia = getNamaPenyedia($id_transaksi);



    $data = array(
        'id_transaksi' => $id_transaksi,
        'pin' => $pin,
        'nama_penyedia' => $nama_penyedia // Memasukkan nama penyedia yang sudah didapatkan
    );

    // URL endpoint API
    $url = "http://localhost:8000/" .$nama_penyedia. "/bayar";

    $ch = curl_init();

    // Setel opsi cURL untuk metode PUT
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json'
        )
    );
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