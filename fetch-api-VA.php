<?php

// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

header('Content-Type: application/json');
$id_transaksi;
$bank = "";

if (isset($_POST['id_pesanan']) && isset($_POST['va']) && isset($_POST['pin'])) {

    $va = htmlspecialchars($_POST['va']);
    $pin = htmlspecialchars($_POST['pin']);
    $id_pesanan = htmlspecialchars($_POST['id_pesanan']);

    $url = "http://localhost:8000/Tpembayaran/pesanan/{$id_pesanan}";

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
        } 
        else {
            echo json_encode($result);

            //GET VA dari tabel trans_bank pakai id_transaksi
            $transaction = $result['data'][0]; // Accessing the first element of the data array

            if (isset($transaction['id_transaksi']) && isset($transaction['nama_penyedia'])) {
                $id_transaksi = $transaction['id_transaksi'];
                $bank = $transaction['nama_penyedia'];
        
            // if ($result['code'] == 200) {
            //     $id_transaksi = $result['data']['id_transaksi'];
            //     $bank = $result['data']['nama_penyedia'];

                // $Get1Data = [
                //     'id_transaksi' => $result['data']['id_transaksi'],
                
                // ];

                // $Get1DataJson = json_encode($Get1Data);

                if ($bank=='BCA'){
                    $Get1Url = "http://localhost:8000/transBCA/{$id_transaksi}";
                }
                else if ($bank=='Mandiri'){
                    $Get1Url = "http://localhost:8000/transMandiri/{$id_transaksi}";
                }

                $chGet1 = curl_init();
                curl_setopt($chGet1, CURLOPT_URL, $Get1Url);
                curl_setopt($chGet1, CURLOPT_RETURNTRANSFER, true);
            
                $responseGet1 = curl_exec($chGet1);

                if (curl_errno($chGet1)) {
                    echo json_encode(['code' => 500, 'message' => 'Error executing request']);
                } else {
                    curl_close($chGet1);
            
                    $resultGet1 = json_decode($responseGet1, true);
                    if ($resultGet1 === null && json_last_error() !== JSON_ERROR_NONE) {
                        echo json_encode(['code' => 500, 'message' => 'Error decoding JSON response']);
                    } 
                    else {
                        if ($va === $resultGet1 ){
                            //kasih error handler karena VA yang di input salah
                        }else{
                            //lanjut ke proses selanjutnya cek pin untuk va nya 
                            if ($bank=='BCA'){
                                $Get2Url = "http://localhost:8000/BCA/pin/{$va}/{$pin}";
                            }
                            else if ($bank=='Mandiri'){
                                $Get2Url = "http://localhost:8000/Mandiri/pin/{$va}/{$pin}";
                            }

                            $chGet2 = curl_init();
                            curl_setopt($chGet2, CURLOPT_URL, $Get2Url);
                            curl_setopt($chGet2, CURLOPT_RETURNTRANSFER, true);
                        
                            $responseGet2 = curl_exec($chGet2);

                            if (curl_errno($chGet2)) {
                                echo json_encode(['code' => 500, 'message' => 'Error executing request']);
                            } else {
                                curl_close($chGet2);

                                $resultGet2 = json_decode($responseGet2, true);

                                if ($resultGet2 === null && json_last_error() !== JSON_ERROR_NONE) {
                                    echo json_encode(['code' => 500, 'message' => 'Error decoding JSON response']);
                                } 
                                else {
                                    // echo json_encode($resultGet2);
                                    if($resultGet2==true){ #kalau pin benar

                                        #update tras_bca dan update trans_pembayaran
                                        if ($bank=='BCA'){
                                            $urlPutBank = "http://localhost:8000/transBCA/{$id_pesanan}";
                                            $putData = [
                                                'jenis' => 'Transfer Bank',
                                                'nama_penyedia'  => 'BCA',
                                                'status'  => 'success'
                                            ];
    
                                        }
                                        else if ($bank=='Mandiri'){
                                            $urlPutBank = "http://localhost:8000/transMandiri/{$id_pesanan}";
                                            // $putData = [
                                            //     'jenis' => 'Transfer Bank',
                                            //     'nama_penyedia'  => 'Mandiri',
                                            //     'status'  => 'success'
                                            // ];
                                        }

                                        // $putDataJson = json_encode($putData);

                                        $chPut = curl_init();

                                        // Set cURL options for PUT request
                                        // curl_setopt($chPut, CURLOPT_URL, $urlPutBank);
                                        // curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                        // curl_setopt($chPut, CURLOPT_POSTFIELDS, $putDataJson);
                                        // curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);
                                        // curl_setopt($chPut, CURLOPT_HTTPHEADER, [
                                        //     'Content-Type: application/json',
                                        //     'Content-Length: ' . strlen($putDataJson)
                                        // ]);
                                        curl_setopt($chPut, CURLOPT_URL, $urlPutBank);
                                        curl_setopt($chPut, CURLOPT_CUSTOMREQUEST, "PUT");
                                        curl_setopt($chPut, CURLOPT_RETURNTRANSFER, true);

                                        $putResponse = curl_exec($chPut);

                                        if (curl_errno($chPut)) {
                                            echo json_encode(['code' => 500, 'message' => 'Error executing PUT request']);
                                        } else {
                                            curl_close($chPut);
                        
                                            $putResult = json_decode($putResponse, true);
                                            if ($putResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                echo json_encode(['code' => 500, 'message' => 'Error decoding PUT response JSON']);
                                            } 
                                            else {
                                                $chPost = curl_init();

                                                curl_setopt($chPost, CURLOPT_URL, 'http://localhost:8000/notif');
                                                curl_setopt($chPost, CURLOPT_POST, 1);
                                                curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
                                                curl_setopt($chPost, CURLOPT_POSTFIELDS, json_encode(array(
                                                    'id_user' => 1,
                                                    'id_pesanan' => $id_pesanan,
                                                    'tipe_notif' => 'keuangan',
                                                    'judul' => 'VA',
                                                    'deskripsi' => "Pembayaran untuk pesanan $id_pesanan telah berhasil",
                                                    'timestamp_masuk' => date('Y-m-d H:i:s'), // Current timestamp
                                                    'status' => 0,
                                                    'link' => ""
                                                )));

                                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                                                $postResponse = curl_exec($chPost);

                                                if (curl_errno($chPost)) {
                                                    echo json_encode(['code' => 500, 'message' => 'Error executing POST request to /notif']);
                                                }
                                                else {
                                                    curl_close($chPost);
                                                    $postResult = json_decode($postResponse, true);

                                                    if ($postResult === null && json_last_error() !== JSON_ERROR_NONE) {
                                                        echo json_encode(['code' => 500, 'message' => 'Error decoding POST response JSON from /notif']);
                                                    } else {

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
                    }
                }

            }
        }
    }
}

?>
