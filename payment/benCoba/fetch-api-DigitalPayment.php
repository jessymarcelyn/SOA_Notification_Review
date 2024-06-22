<?php
// // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Mulai session jika belum dimulai
//     if (!isset($_SESSION)) {
//         session_start();
//     }
//     echo '<script>console.log("masuk")</script>';

//     function checkNumber($number, $provider)
//     {
//         $data = array(
//             'no_telp' => $number,
//             'nominal' => '10000',
//         );

//         $url = "http://localhost:8000/" . $provider;

//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//         $response = curl_exec($ch);

//         if (curl_errno($ch)) {
//             echo 'Error:' . curl_error($ch);
//         } else {
//             curl_close($ch);
//             $result = json_decode($response, true);
//             return $result;
//         }
//     }

//     if (isset($_POST['id_pesanan']) && isset($_POST['method']) && isset($_POST['provider']) && isset($_POST['mobileNumber'])) {
//         $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
//         $provider = htmlspecialchars($_POST['provider']);
//         $mobileNumber = htmlspecialchars($_POST['mobileNumber']);

//         $result = checkNumber($mobileNumber, $provider);

//         if ($result) {
//             $data = array(
//                 'jenis' => 'digitalpayment',
//                 'nama_penyedia' => $provider,
//                 'status' => 'ongoing'
//             );

//             $url = "http://localhost:8000/Tpembayaran/transaksi/" . $id_pesanan;

//             $ch = curl_init();
//             curl_setopt($ch, CURLOPT_URL, $url);
//             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

//             $response = curl_exec($ch);
//             if (curl_errno($ch)) {
//                 echo 'Error:' . curl_error($ch);
//             } else {
//                 curl_close($ch);
//                 echo $response;
//             }
//         } else {
//             echo json_encode(array('status' => 'failed', 'message' => 'Invalid mobile number or provider.'));
//         }
//     } else {
//         echo json_encode(array('status' => 'failed', 'message' => 'Required fields are missing.'));
//     }
// // }
if (!isset($_SESSION)) {
    session_start();
}

function checkNumber($number, $provider)
{
    $data = array(
        'no_telp' => $number,
        'nominal' => '10000',
    );

    $url = "http://localhost:8000/" . $provider;

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
       'no_telp' => $number,
        'nominal' => '10000',
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        curl_close($ch);
        $result = json_decode($response, true);
        echo $result;
        return $result;
        // echo $result;
    }
}

if (isset($_POST['id_pesanan']) && isset($_POST['method']) && isset($_POST['provider']) && isset($_POST['mobileNumber'])) {
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    $provider = htmlspecialchars($_POST['provider']);
    $mobileNumber = htmlspecialchars($_POST['mobileNumber']);

    $result = checkNumber($mobileNumber, $provider);

    if ($result) {
        echo "masuk7";
        $putData = [
            'jenis' => 'digitalpayment',
            'nama_penyedia' => $provider,
            'status' => 'ongoing'
        ];

        $putDataJson = json_encode($putData);

        $putUrl = "http://localhost:8000/Tpembayaran/pesanan/{$id_pesanan}";

        $chPut = curl_init();
        curl_setopt($chPut, CURLOPT_URL, $putUrl);
        curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($chPut, CURLOPT_POSTFIELDS, $putDataJson);
        curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chPut, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($putDataJson)
        ]);

        $putResponse = curl_exec($chPut);

        if (curl_errno($chPut)) {
            echo 'Error:' . curl_error($chPut);
        } else {
            curl_close($chPut);
            echo $putResponse;  // This should echo the response from the PUT request
        }
    } else {
        echo json_encode(['status' => 'failed', 'message' => 'Invalid mobile number or provider.']);
    }
} else {
    echo json_encode(['status' => 'failed', 'message' => 'Required fields are missing.']);
}
?>
