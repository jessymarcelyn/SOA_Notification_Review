<?php
// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Periksa apakah parameter idUser dikirim melalui metode POST
if (isset($_POST['idUser']) && isset($_POST['notifType'])) {
    // Escape string untuk mencegah serangan SQL injection
    $idUser = htmlspecialchars($_POST['idUser']);
    $notifType = htmlspecialchars($_POST['notifType']);


    // URL endpoint API
    $url = "http://localhost:8000/notif/user/" . $idUser . "/" . $notifType;

    // Inisialisasi cURL
    $ch = curl_init();

    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);

    // Periksa kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Tutup cURL
        curl_close($ch);

        // Decode response JSON menjadi array asosiatif
        $notifications = json_decode($response, true);

        if ($notifications === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON: ' . json_last_error_msg();
        } else {
            echo "<script>console.log('HALO');</script>";

            $notificationsHTML = '';

            // Loop melalui hasil response untuk mengambil data notifikasi
            foreach ($notifications as $row) {
                // Tentukan warna berdasarkan status notifikasi
                $color = ($row['status'] == 0) ? "list-group-item-primary" : "list-group-item-light";

                // Ambil data notifikasi
                $title = $row['judul'];
                $desc = $row['deskripsi'];
                $datetime = $row['timestamp_masuk'];
                $id_notif= $row['id_notif'];
                $id_pesanan = $row['id_pesanan'];

                if($row['link'] == null){
                    $link = "#";
                }else{
                    $link = $row['link'];
                }

                // Buat HTML untuk setiap notifikasi
                $notificationsHTML .= '
                    <a id='.$id_notif.' href="'.$link.'" class="list-group-item list-group-item-action ' . $color . ' border-0" id_pesanan='.$id_pesanan.'>
                        <div class="row g-1">
                            <div class="col px-0 text">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-1">' . $title . '</h5>
                                    <small>' . $datetime . '</small>
                                </div>
                                <p class="mb-1">' . $desc . '</p>
                            </div>
                        </div>
                    </a>
                ';
            }

            // Keluarkan HTML notifikasi yang telah dibuat
            echo $notificationsHTML;
        }
    }
} elseif (isset($_POST['id_notif'])) {
    $idNotif = htmlspecialchars($_POST['id_notif']);
    echo $idNotif;

    // Data yang ingin di-update
    $data = array(
        'status' => 'updated'
        // Tambahkan data lain yang ingin di-update
    );

    // URL endpoint API untuk update notifikasi dengan id_notif tertentu
    $url = "http://localhost:8000/notif/" . $idNotif;

    // Inisialisasi cURL untuk metode PUT
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
} else {
    // Jika parameter idUser atau id_notif tidak dikirim, tampilkan pesan error
    echo "Error: Parameter idUser or id_notif is required.";
}
?>
