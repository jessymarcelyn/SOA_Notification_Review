<?php
if (isset($_POST['id_pesanan']) && isset($_POST['otp'])) {

    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
    $otp = htmlspecialchars($_POST['otp']);

    // URL to get the transaction ID
    $url = "http://localhost:8000/Tpembayaran/pesanan/{$id_pesanan}";

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options for GET request
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    // Execute cURL and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Log the raw response for debugging
        error_log("Response from Tpembayaran: " . $response);

        // Close cURL
        curl_close($ch);

        // Decode response JSON to associative array
        $result = json_decode($response, true);

        // Check if JSON decoding was successful
        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON response: ' . json_last_error_msg();
        } else {
            $idTrans = $result['data'][0]['id_transaksi'];
            $timestamp = $result['data'][0]['timestamp'];

            date_default_timezone_set('Asia/Jakarta');

            $timestamp_unix = strtotime($timestamp);

            $current_time = date('Y-m-d H:i:s');
            $current_timee = strtotime($current_time);

            $difference_seconds = abs($current_timee - $timestamp_unix);
            $difference_minutes  = $difference_seconds / 60;

            if ($difference_minutes <= 2) {
                // echo $idTrans;

                // cek attempt dari user udah 3 blm
                $url = "http://localhost:8000/kartu_kredit/transaksi/{$idTrans}";

                // Initialize cURL
                $ch = curl_init();

                // Set cURL options for GET request
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
                    $resultAttempt = json_decode($response, true);

                    if ($resultAttempt === null && json_last_error() !== JSON_ERROR_NONE) {
                        echo 'Error decoding JSON response';
                    } else {
                        // update transaksi pembayaran
                        if ($resultAttempt[0]['attempt'] < 3) {


                            $url = "http://localhost:8000//kartu_kredit/transaksi/{$idTrans}/otp/{$otp}";

                            // Initialize cURL
                            $ch = curl_init();

                            // Set cURL options for GET request
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
                                $resultOTP = json_decode($response, true);

                                if ($resultOTP === null && json_last_error() !== JSON_ERROR_NONE) {
                                    echo 'Error decoding JSON response';
                                } else {
                                    echo $resultOTP;

                                    // update transaksi pembayaran
                                    if ($resultOTP == true) {

                                        $putUrl = "http://localhost:8000/Tpembayaran/pesanan/$id_pesanan/status/success";

                                        // Initialize cURL session
                                        $chPut = curl_init();

                                        // Set cURL options for PUT request
                                        curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                        curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                        curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                            'Content-Type: application/json',
                                            // You may need to set Content-Length depending on your data
                                        ]);

                                        // Execute cURL and capture the response
                                        $putResponse = curl_exec($chPut);

                                        // Check for cURL errors
                                        if (curl_errno($chPut)) {
                                            echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                        } else {
                                            // update status dan limit transaksi provider kartu
                                            curl_close($chPut);

                                            // Decode response JSON
                                            $putResult = json_decode($putResponse, true);

                                            // Check if JSON decoding was successful
                                            if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                            } else {
                                                // Check if update was successful based on $putResult being true or false
                                                if ($putResult === true) {
                                                    // echo json_encode(['code' => 200, 'message' => 'Booking status updated successfully']);
                                                    $putUrl = "http://localhost:8000/kartu_kredit/transaksi/{$idTrans}/status/success";

                                                    // Initialize cURL session
                                                    $chPut = curl_init();

                                                    // Set cURL options for PUT request
                                                    curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                                    curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                                    curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                                    curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                                        'Content-Type: application/json',
                                                        // You may need to set Content-Length depending on your data
                                                    ]);

                                                    // Execute cURL and capture the response
                                                    $putResponse = curl_exec($chPut);

                                                    // Check for cURL errors
                                                    if (curl_errno($chPut)) {
                                                        echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                                    } else {
                                                        // Close cURL session
                                                        curl_close($chPut);

                                                        // Decode response JSON
                                                        $putResult = json_decode($putResponse, true);

                                                        // Check if JSON decoding was successful
                                                        if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                            echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                                        } else {
                                                            //POST NOTIFIKASI
                                                            $chPost = curl_init();

                                                            curl_setopt($chPost, CURLOPT_URL, 'http://localhost:8000/notif');
                                                            curl_setopt($chPost, CURLOPT_POST, 1);
                                                            curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
                                                            curl_setopt($chPost, CURLOPT_POSTFIELDS, json_encode(array(
                                                                'id_user' => 1,
                                                                'id_pesanan' => $id_pesanan,
                                                                'tipe_notif' => 'pembayaran',
                                                                'judul' => 'Pembayaran Berhasil',
                                                                'deskripsi' => "Pembayaran untuk pesanan $id_pesanan berhasil",
                                                                'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                                                                'status' => 0,
                                                                'link' => null
                                                            )));
                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                                                            $postResponse = curl_exec($chPost);

                                                            if (curl_errno($chPost)) {
                                                                echo json_encode(['code' => 500, 'message' => 'Error executing POST request to /notif']);
                                                            } else {
                                                                // GANTI LINK NOTIF
                                                                $putData = [
                                                                    'judul' => 'Lakukan Pembayaran'
                                                                ];

                                                                // Encode data as JSON
                                                                $putDataJson = json_encode($putData);

                                                                // URL for the PUT request, assuming localhost and port 8000
                                                                $putUrl = "http://localhost:8000/notif/pesanan/{$id_pesanan}";

                                                                // Initialize cURL session
                                                                $chPut = curl_init();

                                                                // Set cURL options
                                                                curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                                                curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                                                curl_setopt($chPut, CURLOPT_POSTFIELDS, $putDataJson);
                                                                curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                                                curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                                                    'Content-Type: application/json',
                                                                    'Content-Length: ' . strlen($putDataJson)
                                                                ]);

                                                                // Execute cURL session
                                                                $putResponse = curl_exec($chPut);

                                                                // Check for cURL errors
                                                                if (curl_errno($chPut)) {
                                                                    echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                                                } else {
                                                                    // Close cURL session
                                                                    curl_close($chPut);

                                                                    // Decode response JSON
                                                                    $putResult = json_decode($putResponse, true);

                                                                    // Check if JSON decoding was successful
                                                                    if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                                        echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                                                    } else {
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        //tambah attempt karena otp salah
                                        $putUrl = "http://localhost:8000/kartu_kredit/transaksi/{$idTrans}";

                                        // Initialize cURL session
                                        $chPut = curl_init();

                                        // Set cURL options
                                        curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                        curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                        curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                            'Content-Type: application/json'
                                        ]);

                                        // Execute cURL session
                                        $putResponse = curl_exec($chPut);

                                        // Check for cURL errors
                                        if (curl_errno($chPut)) {
                                            echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                        } else {
                                            // Close cURL session
                                            curl_close($chPut);

                                            // Decode response JSON
                                            $putResult = json_decode($putResponse, true);

                                            // Check if JSON decoding was successful
                                            if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                            } else {

                                                // echo json_encode(['code' => 200, 'message' => 'Attempt updated successfully']);
                                                //kalau udah 3 kali gagal
                                                if ($resultAttempt[0]['attempt'] == 2) {
                                                    echo "3";
                                                    // GANTI LINK NOTIF
                                                    $putData = [
                                                        'judul' => 'Lakukan Pembayaran'
                                                    ];

                                                    // Encode data as JSON
                                                    $putDataJson = json_encode($putData);

                                                    // URL for the PUT request, assuming localhost and port 8000
                                                    $putUrl = "http://localhost:8000/notif/pesanan/{$id_pesanan}";

                                                    // Initialize cURL session
                                                    $chPut = curl_init();

                                                    // Set cURL options
                                                    curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                                    curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                                    curl_setopt($chPut, CURLOPT_POSTFIELDS, $putDataJson);
                                                    curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                                    curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                                        'Content-Type: application/json',
                                                        'Content-Length: ' . strlen($putDataJson)
                                                    ]);

                                                    // Execute cURL session
                                                    $putResponse = curl_exec($chPut);

                                                    // Check for cURL errors
                                                    if (curl_errno($chPut)) {
                                                        echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                                    } else {
                                                        // Close cURL session
                                                        curl_close($chPut);

                                                        // Decode response JSON
                                                        $putResult = json_decode($putResponse, true);

                                                        // Check if JSON decoding was successful
                                                        if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                            echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                                        } else {
                                                            //update status transaksi jadi failed
                                                            $putUrl = "http://localhost:8000/Tpembayaran/pesanan/$id_pesanan/status/failed";

                                                            // Initialize cURL session
                                                            $chPut = curl_init();

                                                            // Set cURL options for PUT request
                                                            curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                                            curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                                            curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                                            curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                                                'Content-Type: application/json',
                                                                // You may need to set Content-Length depending on your data
                                                            ]);

                                                            // Execute cURL and capture the response
                                                            $putResponse = curl_exec($chPut);

                                                            // Check for cURL errors
                                                            if (curl_errno($chPut)) {
                                                                echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                                            } else {
                                                                // update status dan limit transaksi provider kartu
                                                                curl_close($chPut);

                                                                // Decode response JSON
                                                                $putResult = json_decode($putResponse, true);

                                                                // Check if JSON decoding was successful
                                                                if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                                    echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                                                } else {
                                                                    //update stauts transaksi kartu failed
                                                                    $putUrl = "http://localhost:8000/kartu_kredit/transaksi/{$idTrans}/status/failed";

                                                                    // Initialize cURL session
                                                                    $chPut = curl_init();

                                                                    // Set cURL options for PUT request
                                                                    curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                                                    curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                                                    curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                                                    curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                                                        'Content-Type: application/json',
                                                                        // You may need to set Content-Length depending on your data
                                                                    ]);

                                                                    // Execute cURL and capture the response
                                                                    $putResponse = curl_exec($chPut);

                                                                    // Check for cURL errors
                                                                    if (curl_errno($chPut)) {
                                                                        echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                                                    } else {
                                                                        curl_close($chPut);

                                                                        // Decode response JSON
                                                                        $putResult = json_decode($putResponse, true);

                                                                        // Check if JSON decoding was successful
                                                                        if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                                            echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                                                        } else {
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    // echo json_encode(['code' => 500, 'message' => 'Failed to update attempt']);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            echo "3";
                            // GANTI LINK NOTIF
                            $putData = [
                                'judul' => 'Lakukan Pembayaran'
                            ];

                            // Encode data as JSON
                            $putDataJson = json_encode($putData);

                            // URL for the PUT request, assuming localhost and port 8000
                            $putUrl = "http://localhost:8000/notif/pesanan/{$id_pesanan}";

                            // Initialize cURL session
                            $chPut = curl_init();

                            // Set cURL options
                            curl_setopt($chPut, CURLOPT_URL, $putUrl);
                            curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                            curl_setopt($chPut, CURLOPT_POSTFIELDS, $putDataJson);
                            curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                'Content-Type: application/json',
                                'Content-Length: ' . strlen($putDataJson)
                            ]);

                            // Execute cURL session
                            $putResponse = curl_exec($chPut);

                            // Check for cURL errors
                            if (curl_errno($chPut)) {
                                echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                            } else {
                                // Close cURL session
                                curl_close($chPut);

                                // Decode response JSON
                                $putResult = json_decode($putResponse, true);

                                // Check if JSON decoding was successful
                                if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                    echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                } else {
                                    //update status transaksi jadi failed
                                    $putUrl = "http://localhost:8000/Tpembayaran/pesanan/$id_pesanan/status/failed";

                                    // Initialize cURL session
                                    $chPut = curl_init();

                                    // Set cURL options for PUT request
                                    curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                    curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                    curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                        'Content-Type: application/json',
                                        // You may need to set Content-Length depending on your data
                                    ]);

                                    // Execute cURL and capture the response
                                    $putResponse = curl_exec($chPut);

                                    // Check for cURL errors
                                    if (curl_errno($chPut)) {
                                        echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                    } else {
                                        curl_close($chPut);

                                        // Decode response JSON
                                        $putResult = json_decode($putResponse, true);

                                        // Check if JSON decoding was successful
                                        if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                            echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                        } else {
                                            //update status transaksi kartu failed
                                            $putUrl = "http://localhost:8000/kartu_kredit/transaksi/{$idTrans}/status/failed";

                                            // Initialize cURL session
                                            $chPut = curl_init();

                                            // Set cURL options for PUT request
                                            curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                            curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                            curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                                'Content-Type: application/json',
                                                // You may need to set Content-Length depending on your data
                                            ]);

                                            // Execute cURL and capture the response
                                            $putResponse = curl_exec($chPut);

                                            // Check for cURL errors
                                            if (curl_errno($chPut)) {
                                                echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                            } else {
                                                // update status dan limit transaksi provider kartu
                                                curl_close($chPut);

                                                // Decode response JSON
                                                $putResult = json_decode($putResponse, true);

                                                // Check if JSON decoding was successful
                                                if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                    echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                                } else {
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                //lebih dari 120 detik
                echo "2";
                // GANTI LINK NOTIF
                $putData = [
                    'judul' => 'Lakukan Pembayaran'
                ];

                // Encode data as JSON
                $putDataJson = json_encode($putData);

                // URL for the PUT request, assuming localhost and port 8000
                $putUrl = "http://localhost:8000/notif/pesanan/{$id_pesanan}";

                // Initialize cURL session
                $chPut = curl_init();

                // Set cURL options
                curl_setopt($chPut, CURLOPT_URL, $putUrl);
                curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($chPut, CURLOPT_POSTFIELDS, $putDataJson);
                curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($putDataJson)
                ]);

                // Execute cURL session
                $putResponse = curl_exec($chPut);

                // Check for cURL errors
                if (curl_errno($chPut)) {
                    echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                } else {
                    // Close cURL session
                    curl_close($chPut);

                    // Decode response JSON
                    $putResult = json_decode($putResponse, true);

                    // Check if JSON decoding was successful
                    if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                        echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                    } else {
                        $putUrl = "http://localhost:8000/Tpembayaran/pesanan/$id_pesanan/status/failed";

                        // Initialize cURL session
                        $chPut = curl_init();

                        // Set cURL options for PUT request
                        curl_setopt($chPut, CURLOPT_URL, $putUrl);
                        curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            // You may need to set Content-Length depending on your data
                        ]);

                        // Execute cURL and capture the response
                        $putResponse = curl_exec($chPut);

                        // Check for cURL errors
                        if (curl_errno($chPut)) {
                            echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                        } else {
                            // update status dan limit transaksi provider kartu
                            curl_close($chPut);

                            // Decode response JSON
                            $putResult = json_decode($putResponse, true);

                            // Check if JSON decoding was successful
                            if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                            } else {
                                //update status transaksi kartu failed
                                $putUrl = "http://localhost:8000/kartu_kredit/transaksi/{$idTrans}/status/failed";

                                // Initialize cURL session
                                $chPut = curl_init();

                                // Set cURL options for PUT request
                                curl_setopt($chPut, CURLOPT_URL, $putUrl);
                                curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                    'Content-Type: application/json',
                                    // You may need to set Content-Length depending on your data
                                ]);

                                // Execute cURL and capture the response
                                $putResponse = curl_exec($chPut);

                                // Check for cURL errors
                                if (curl_errno($chPut)) {
                                    echo json_encode(['code' => 500, 'message' => 'Error executing PUT request: ' . curl_error($chPut)]);
                                } else {
                                    // update status dan limit transaksi provider kartu
                                    curl_close($chPut);

                                    // Decode response JSON
                                    $putResult = json_decode($putResponse, true);

                                    // Check if JSON decoding was successful
                                    if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                        echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                    } else {
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'id_pesanan is required.'));
}
