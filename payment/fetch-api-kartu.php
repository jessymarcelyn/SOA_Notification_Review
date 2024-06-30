<?php
// Start session if not started
if (!isset($_SESSION)) {
    session_start();
}

// Log initial message
error_log("HALO1");

header('Content-Type: application/json');

if (isset($_POST['id_pesanan']) && isset($_POST['nama']) && isset($_POST['nomer_kartu']) && isset($_POST['expired_month']) && isset($_POST['expired_year']) && isset($_POST['cvv']) && isset($_POST['nominal'])) {
    date_default_timezone_set('Asia/Jakarta');
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    $nama = htmlspecialchars($_POST['nama']);
    $nomer_kartu = htmlspecialchars($_POST['nomer_kartu']);
    $expired_month = htmlspecialchars($_POST['expired_month']);
    $expired_year = htmlspecialchars($_POST['expired_year']);
    $cvv = htmlspecialchars($_POST['cvv']);
    $nominal = htmlspecialchars($_POST['nominal']);

    $url = "http://localhost:8000/kartu_kredit/{$nomer_kartu}/cvv/{$cvv}/nama/{$nama}/expired_month/{$expired_month}/expired_year/{$expired_year}/nominal/{$nominal}";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['code' => 500, 'message' => 'Error executing request']);
    } else {
        curl_close($ch);

        $result = json_decode($response, true);

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['code' => 500, 'message' => 'Error decoding JSON response']);
        } else {

            echo json_encode($result);

            //UPDATE Transaksi pembayaran
            if ($result['code'] == 200) {
                // Construct the PUT request data
                $putData = [
                    'id_transaksi' => $result['data']['id_transaksi'],
                    'jenis_pembayaran' => 'kartukredit',
                    'nama_penyedia' => 'mastercard'
                ];

                $putDataJson = json_encode($putData);


                $putUrl = "http://localhost:8000/Tpembayaran/pesanan/{$id_pesanan}";


                $chPut = curl_init();

                // Set cURL options for PUT request
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
                    echo json_encode(['code' => 500, 'message' => 'Error executing PUT request']);
                } else {
                    curl_close($chPut);

                    $putResult = json_decode($putResponse, true);
                    if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                        echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                    } else {

                        //post notif
                        if ($putResult == true) {
                            $chPost = curl_init();

                            curl_setopt($chPost, CURLOPT_URL, 'http://localhost:8000/notif');
                            curl_setopt($chPost, CURLOPT_POST, 1);
                            curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($chPost, CURLOPT_POSTFIELDS, json_encode(array(
                                'id_user' => 1,
                                'id_pesanan' => $id_pesanan,
                                'tipe_notif' => 'pembayaran',
                                'judul' => 'OTP',
                                'deskripsi' => "Silahkan lakukan pembayaran dengan OTP ini {$result['data']['otp']}",
                                'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                                'status' => 0,
                                'link' => null
                            )));
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                            $postResponse = curl_exec($chPost);

                            if (curl_errno($chPost)) {
                                echo json_encode(['code' => 500, 'message' => 'Error executing POST request to /notif']);
                            } else {
                                curl_close($chPost);

                                $postResult = json_decode($postResponse, true);

                                if ($postResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                    echo json_encode(['code' => 500, 'message' => 'Error decoding POST response JSON from /notif']);
                                } else {
                                    //Manggil notif kirim link input_otp.php
                                    if ($postResult['data'] == true) {
                                        $chPost = curl_init();

                                        curl_setopt($chPost, CURLOPT_URL, 'http://localhost:8000/notif');
                                        curl_setopt($chPost, CURLOPT_POST, 1);
                                        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($chPost, CURLOPT_POSTFIELDS, json_encode(array(
                                            'id_user' => 1,
                                            'id_pesanan' => $id_pesanan,
                                            'tipe_notif' => 'pembayaran',
                                            'judul' => 'Lakukan Pembayaran',
                                            'deskripsi' => "Silahkan lakukan pembayaran untuk pesanan $id_pesanan",
                                            'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                                            'status' => 0,
                                            'link' => "inputOTP.php"
                                        )));
                                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));


                                        // Execute cURL and fetch response
                                        $postResponse = curl_exec($chPost);
                                        if (curl_errno($chPost)) {
                                            echo json_encode(['code' => 500, 'message' => 'Error executing POST request to /notif']);
                                        } else {
                                            // Close cURL session
                                            curl_close($chPost);

                                            // Decode JSON response into associative array
                                            $postResult = json_decode($postResponse, true);
                                            if ($postResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                echo json_encode(['code' => 500, 'message' => 'Error decoding POST response JSON from /notif']);
                                            } else {
                                            }
                                        }
                                    }
                                    // Respond with the POST request result from /notif
                                    // echo json_encode($postResult);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
} else if (isset($_POST['id_pesanan']) && isset($_POST['id_pesanan2'])) {
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    $id_pesanan2 = htmlspecialchars($_POST['id_pesanan2']);

    $id_booking = $_POST['id_pesanan'];
    $url = "http://3.226.141.243:8004/bookingDetails/" . $id_booking;
    
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
        $nominal = 100000; // Default value in case of cURL error
    } else {
        // Decode response JSON menjadi array asosiatif
        $result = json_decode($response, true);
    
        if (isset($result['booking details'])) {
            $resultData = $result['booking details'];
            $nominal = $resultData['total_price'];
        } else {
            // Hardcode nominal if booking details not found
            $nominal = 200000;
        }
    }
    curl_close($ch);
    
    // URL endpoint API
    $url = "http://localhost:8000/Tpembayaran";

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        "id_pesanan" => $id_pesanan,
        "id_pesanan2" => $id_pesanan2,
        "total_transaksi" => $nominal
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Execute cURL and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Close cURL
        curl_close($ch);

        // Decode response JSON to associative array
        $result = json_decode($response, true);

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            error_log("HALO3");
            echo 'Error decoding JSON response';
        } else {
            error_log("HALO4");
            echo json_encode($result);  // Output the response from API
        }
    }
} else if (isset($_POST['id_pesanan'])) {
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);


    $id_booking = $_POST['id_pesanan'];
    $url = "http://3.226.141.243:8004/bookingDetails/" . $id_booking;
    
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
        $nominal = 100000; // Default value in case of cURL error
    } else {
        // Decode response JSON menjadi array asosiatif
        $result = json_decode($response, true);
    
        if (isset($result['booking details'])) {
            $resultData = $result['booking details'];
            $nominal = $resultData['total_price'];
        } else {
            // Hardcode nominal if booking details not found
            $nominal = 100000;
        }
    }

    curl_close($ch);

    $url = "http://localhost:8000/Tpembayaran";

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        "id_pesanan" => $id_pesanan,
        "total_transaksi" => $nominal
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Execute cURL and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Close cURL
        curl_close($ch);

        // Decode response JSON to associative array
        $result = json_decode($response, true);

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON response';
        } else {
            echo json_encode($result);
        }
    }
}





// if ( isset($_POST['nama']) && isset($_POST['nomer_kartu']) && isset($_POST['expired_month']) && isset($_POST['expired_year']) && isset($_POST['cvv']) && isset($_POST['nominal'])) {
//     // $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
//     $nama = htmlspecialchars($_POST['nama']);
//     $nomer_kartu = htmlspecialchars($_POST['nomer_kartu']);
//     $expired_month = htmlspecialchars($_POST['expired_month']);
//     $expired_year = htmlspecialchars($_POST['expired_year']);
//     $cvv = htmlspecialchars($_POST['cvv']);
//     $nominal = htmlspecialchars($_POST['nominal']);

//     // Construct the URL endpoint for the API request
//     $url = "http://localhost:8000/kartu_kredit/{$nomer_kartu}/cvv/{$cvv}/nama/{$nama}/expired_month/{$expired_month}/expired_year/{$expired_year}/nominal/{$nominal}";

//     // Initialize cURL session
//     $ch = curl_init();

//     // Set cURL options for GET request
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     // Execute cURL and fetch response
//     $response = curl_exec($ch);

//     // Check for cURL errors
//     if (curl_errno($ch)) {
//         echo json_encode(['code' => 500, 'message' => 'Error executing request']);
//     } else {
//         // Close cURL session
//         curl_close($ch);

//         // Decode JSON response into associative array
//         $result = json_decode($response, true);

//         if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
//             echo json_encode(['code' => 500, 'message' => 'Error decoding JSON response']);
//         } else {
//             echo json_encode($result);
//             if ($result['code'] == 200) {

//             }
//         }
//     }
// } else {
//     echo json_encode(['code' => 400, 'message' => 'Missing POST parameters']);
// }
