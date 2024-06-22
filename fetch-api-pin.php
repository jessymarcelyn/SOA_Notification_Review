<?php
// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
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

                if ($timestamp) {
                    // Convert the timestamp to a Unix timestamp
                    $timestamp_unix = strtotime($timestamp);

                    // Get the current time as a Unix timestamp
                    $current_time = time();

                    // Calculate the difference in seconds
                    $time_difference = $current_time - $timestamp_unix;

                    // Check if the difference is greater than 2 minutes (120 seconds)
                    if ($time_difference > 12000) {
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

                    // echo $time_difference;
                    // echo $timestamp , "<br>";
                    // echo $current_time;

                }


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
            echo $response;
            // return $response;
        }
    }
    
    else{
        return "Your time has expired. Please try again.";
    }
    

}
// elseif()

?>