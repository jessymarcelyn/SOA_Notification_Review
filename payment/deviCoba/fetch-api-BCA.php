<?php

// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

header('Content-Type: application/json');

$no_telp = "081211366021";
$nominal = 500000;

function sendCurlRequest($url, $postData)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            echo 'Error: Received HTTP code ' . $httpCode;
        } else {
            $result = json_decode($response, true);
            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                echo 'Error decoding JSON response';
            } else {
                echo json_encode($result);
            }
        }
    }
}

#Untuk cek id_pesanan dan post di tabel transaksi_pembayaran dengan status initial
if (isset($_POST['id_pesanan'])) {

    if (isset($_POST['id_pesanan2'])) {
        // echo ("masuk1");
        $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
        $id_pesanan2 = htmlspecialchars($_POST['id_pesanan2']);
        // echo "<script>console.log('HALO');</script>";
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
            // curl_close($ch);
        } else {
            // Tutup cURL
            curl_close($ch);

            // Decode response JSON menjadi array asosiatif
            $result = json_decode($response, true);

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                echo 'Error decoding JSON response: ' . json_last_error_msg();
            } else {
                // Output the response from API
                // echo 'Response from API: ' . json_encode($result);
                echo json_encode($result);
            }
        }
    } else { #untuk kalau id_pesanan cuman 1
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
}



#untuk cek apakah user sudah milih metode transfer_bank dan jenis bank yang dipilih kemudian mencatat transaksi user berdasarkan bank yang dipilih
if (isset($_POST['bank']) && isset($_POST['id_pesanan'])) {
    // if(isset($_POST['id_pesanan'])){

    $bank = htmlspecialchars($_POST['bank']);
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    // $nominal = htmlspecialchars($_POST['nominal']); #sementara gk pake ini tapi pake hardcode an dr atas

    if ($_POST['bank'] == 'BCA') {

        $url = "http://localhost:8000/transBCA"; #hasil dari API adalah id_transaksi dan VA
        $postData = array(
            "no_telp" => $no_telp, #sudah di hardcode di atas
            "total_transaksi" => $nominal #sudah di hardcode di atas
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode(['code' => 500, 'message' => 'Error executing request']);
            // echo 'Error:' . curl_error($ch);
        } else {
            curl_close($ch);

            $result = json_decode($response, true);

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['code' => 500, 'message' => 'Error decoding JSON response']);
                // echo 'Error decoding JSON response';
            } else {
                error_log("Else");
                echo json_encode($result);

                //UPDATE Transaksi pembayaran
                if ($result['code'] == 200) {
                    // Construct the PUT request data
                    $putData = [
                        'id_transaksi' => $result['data']['id_transaksi'],
                        'jenis_pembayaran' => 'TransferBank',
                        'nama_penyedia' => 'BCA'
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
                                    'tipe_notif' => 'info',
                                    'judul' => 'VA',
                                    'deskripsi' => "Silahkan lakukan pembayaran untuk pesanan $id_pesanan dengan VA ini {$result['data']['va']}",
                                    'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                                    'status' => 0,
                                    'link' => "../../inputVA.php"
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
                                                'tipe_notif' => 'info',
                                                'judul' => 'OTP',
                                                'deskripsi' => "Silahkan lakukan pembayaran untuk pesanan $id_pesanan",
                                                'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                                                'status' => 0,
                                                'link' => "../../inputOTP.php"
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
        // $result = sendCurlRequest($url, $postData);
        var_dump($result); // Debugging output
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    if ($_POST['bank'] == 'Mandiri') {

        $url = "http://localhost:8000/transMandiri"; #output id_transaksi dan VA
        $postData = array(
            "no_telp" => $no_telp,
            "total_transaksi" => $nominal
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

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
                        'jenis_pembayaran' => 'TransferBank',
                        'nama_penyedia' => 'Mandiri'
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
                                    'tipe_notif' => 'info',
                                    'judul' => 'VA',
                                    'deskripsi' => "Silahkan lakukan pembayaran untuk pesanan $id_pesanan dengan VA ini {$result['data']['va']}",
                                    'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                                    'status' => 0,
                                    'link' => "../../inputVA.php"
                                )));
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                                $postResponse = curl_exec($chPost);
                            }
                        }
                    }
                }
            }
        }
    }
    // }
}
