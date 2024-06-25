<?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        'no_telp' => "08123456789",
        'nominal' => 10000,
    );

    
    $url = "http://localhost:8000/" . $provider;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); // Set URL tujuan
    curl_setopt($ch, CURLOPT_POST, 1); // Set metode POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Kirim data POST
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // Tambahkan header

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo 'Error executing cURL request: ' . curl_error($ch);
        curl_close($ch);
        return false;
    } else {
        curl_close($ch);

        if ($http_code != 200) {
            echo 'Error in API response: HTTP code ' . $http_code;
            return false;
        }

        // Decode the JSON response
        $result = json_decode($response, true);

        // Check if JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON response: ' . json_last_error_msg();
            return false;
        }

        // Check if 'data' key exists in the response
        if (!isset($result['data'])) {
            echo 'Data key not found in response';
            return false;
        }

        // Return the decoded response
        return $result['data'];
    }


}



if (isset($_POST['id_pesanan']) && isset($_POST['method']) && isset($_POST['provider']) && isset($_POST['mobileNumber']) && isset($_POST['nominal'])) {
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    $provider = htmlspecialchars($_POST['provider']);
    $mobileNumber = htmlspecialchars($_POST['mobileNumber']);
    $nominal = htmlspecialchars($_POST['nominal']);

    echo $mobileNumber, $provider, $nominal;
    $result = checkNumber($mobileNumber, $provider, $nominal);
    // echo $result;

    if ($result != False) {
        echo "valid $result ok";
        // echo $result;
        // $data = array(
        //     'jenis_pembayaran' => 'Digital Payment',
        //     'nama_penyedia' => $provider,
        //     'status' => 'ongoing'
        // );

        // $url = "http://localhost:8000/Tpembayaran/pesanan/" . $id_pesanan;

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // $response = curl_exec($ch);
        // if (curl_errno($ch)) {
        //     echo 'Error:' . curl_error($ch);
        // } else {
        //     curl_close($ch);
        //     post_notif($id_pesanan);
        //     echo $response;
        //     echo $result;
        // }
    } else {
        echo "Your number is not valid $result yaaa";
    }
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'Required fields are missing.'));
}

// }
?>