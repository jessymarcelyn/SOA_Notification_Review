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
                'judul' => 'Lakukan Pembayaran',
                'deskripsi' => "Silahkan lakukan pembayaran untuk pesanan $id_pesanan ",
                'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                'status' => 0,
                'link' => "inputPin.php"
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
function checkNumber($number, $provider, $nominal)
{
    $data = array(
        "no_telp" => $number,
        "nominal" => $nominal,
    );

    
    $url = "http://localhost:8000/" . $provider;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); // Set URL tujuan
    curl_setopt($ch, CURLOPT_POST, 1); // Set metode POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Kirim data POST
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // Tambahkan header

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error executing cURL request: ' . curl_error($ch);
        curl_close($ch);
        return false;
    } else {
        curl_close($ch);

        return $response;
    }


}



if (isset($_POST['id_pesanan']) && isset($_POST['method']) && isset($_POST['provider']) && isset($_POST['mobileNumber']) && isset($_POST['nominal'])) {
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    $provider = htmlspecialchars($_POST['provider']);
    $mobileNumber = htmlspecialchars($_POST['mobileNumber']);
    $nominal = htmlspecialchars($_POST['nominal']);

    // echo $mobileNumber, $provider, $nominal;
    $result = checkNumber($mobileNumber, $provider, $nominal);
    echo $result;

    if ($result !== "false") {
        // echo "valid $result ok";
        // echo $result;
        $data = array(
            'jenis_pembayaran' => 'Digital Payment',
            'nama_penyedia' => $provider,
            'status' => 'ongoing'
        );

        $url = "http://localhost:8000/Tpembayaran/pesanan/" . $id_pesanan;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            curl_close($ch);
         
            echo $response;
      
        }
    } else {
        echo "Your number is not valid ";
    }
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'Required fields are missing.'));
}

// }
?>