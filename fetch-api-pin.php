<?php
// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

function post_notif($id_pesanan)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/notif');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        json_encode(
            array(
                'id_user' => 1,
                'id_pesanan' => $id_pesanan,
                'tipe_notif' => 'pembayaran',
                'judul' => 'Pembayaran Berhasil',
                'deskripsi' => "Pembayaran untuk pesanan $id_pesanan berhasil",
                'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                'status' => 0,
                'link' => null
            )
        )
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $postResponse = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['code' => 500, 'message' => 'Error executing POST request to /notif']);
    } else {

        curl_close($ch);

        // Decod
    }
}


function getIDTransaksi_NamaPenyedia($id_pesanan)
{
    $url = "http://localhost:8000/Tpembayaran/pesanan/" . $id_pesanan;

    // Inisialisasi cURL
    $ch = curl_init();

    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);
    $data = array(
        'id_transaksi' => "",
        'nama_penyedia' => ""
    );

    // Periksa kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Tutup cURL
        curl_close($ch);

        // Decode response JSON menjadi array asosiatif
        $result = json_decode($response, true);

        // Karna return ada code dan data
        if (isset($result['data'])) {
            $resultData = $result['data'];

            // Pastikan data ada dan dalam format yang benar
            if (!empty($resultData) && is_array($resultData)) {
                // Ambil data pertama dari resultData jika tersedia
                $row = $resultData[0];

                $timestamp = $row['timestamp'];

                date_default_timezone_set('Asia/Jakarta');
                // Convert timestamp to Unix timestamp
                $timestamp_unix = strtotime($timestamp);


                $current_time = date('Y-m-d H:i:s');
                $current_timee = strtotime($current_time);

                $difference_seconds = abs($current_timee - $timestamp_unix);
                $difference_minutes = $difference_seconds / 60;



                // Check if the difference is greater than 2 minutes (120 seconds)
                if ($difference_minutes > 2) {
                    // The timestamp is older than 2 minutes
                    // echo "The timestamp is older than 2 minutes.";
                    $data = false;
                } else {
                    $data = array(
                        'id_transaksi' => $row['id_transaksi'],
                        'nama_penyedia' => $row['nama_penyedia']
                    );
                    // echo "The timestamp is within the last 2 minutes.";


                }

                // echo $timestamp_unix, "<br>";

                //     echo $difference_minutes, "<br>";
                //     echo $timestamp, "<br>";
                //     echo $current_time;


                // }
            }
        } else {
            echo 'Error: No data found';
        }
    }
    return $data;
}

// Periksa apakah parameter idUser dikirim melalui metode POST
if (isset($_POST['id_pesanan']) && isset($_POST['pin'])) {

    // Escape string untuk mencegah serangan SQL injection
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    $pin = htmlspecialchars($_POST['pin']);

    $data = getIDTransaksi_NamaPenyedia($id_pesanan);


    if ($data != false) {
        $nama_penyedia = strtolower($data['nama_penyedia']);

        $id_transaksi = $data['id_transaksi'];

        $data = array(
            'id_transaksi' => $id_transaksi,
            'pin' => $pin,
            // 'nama_penyedia' => $nama_penyedia // Memasukkan nama penyedia yang sudah didapatkan
        );

        // URL endpoint API
        $url = "http://localhost:8000/" . $nama_penyedia . "/pembayaran";

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
            post_notif($id_pesanan);
            echo $response;
            // return $response;
        }
    } else {
        echo "Your time has expired";
    }


}
// elseif()

?>