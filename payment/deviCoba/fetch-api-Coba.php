<?php

// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

header('Content-Type: application/json');

$no_telp = "081211366021";

function sendCurlRequest($url, $postData) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // $response = curl_exec($ch);

    // if (curl_errno($ch)) {
    //     return 'Error:' . curl_error($ch);
    // } else {
    //     curl_close($ch);
    //     return json_decode($response, true);
    // }
    
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


if (isset($_POST['nama_bank'])){
    if(isset($_POST['id_pesanan'])){
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

        // if ($_POST['nama_bank'] == 'BCA'){
        //     $url = "http://localhost:8000/transBCA";
        
        //     // Inisialisasi cURL
        //     $ch = curl_init();
        
        //     // Setel opsi cURL
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        //         "no_telp" => $no_telp,
        //         "total_transaksi" => $nominal
        //     )));
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        //     // Execute cURL and get the response
        //     $response = curl_exec($ch);
        
        //     // Check for cURL errors
        //     if (curl_errno($ch)) {
        //         echo 'Error:' . curl_error($ch);
        //     } else {
        //         // Close cURL
        //         curl_close($ch);
        
        //         // Decode response JSON to associative array
        //         $result = json_decode($response, true);
        
        //         if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
        //             echo 'Error decoding JSON response';
        //         } else {
        //             echo json_encode($result);
        //         }
        //     }
        // }
        if ($_POST['nama_bank'] == 'BCA'){
            $url = "http://localhost:8000/transBCA";
            $postData = array(
                "no_telp" => $no_telp,
                "total_transaksi" => $nominal
            );
            $result = sendCurlRequest($url, $postData);
            echo json_encode($result);
        }
        
        if ($_POST['nama_bank'] == 'Mandiri') {
            $url = "http://localhost:8000/transMandiri";
            $postData = array(
                "no_telp" => $no_telp,
                "total_transaksi" => $nominal
            );
            $result = sendCurlRequest($url, $postData);
            echo json_encode($result);
        }
        
        
        // if ($_POST['nama_bank'] == 'Mandiri') {
        //     $url = "http://localhost:8000/transMandiri";
        
        //     // Initialize cURL
        //     $ch = curl_init();
        
        //     // Set cURL options
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        //         "no_telp" => $no_telp,  // Ensure these variables are properly set before this code block
        //         "total_transaksi" => $nominal  // Ensure these variables are properly set before this code block
        //     )));
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        //     // Execute cURL and get the response
        //     $response = curl_exec($ch);
        
        //     // Check for cURL errors
        //     if (curl_errno($ch)) {
        //         echo 'Error:' . curl_error($ch);
        //     } else {
        //         // Close cURL handle
        //         curl_close($ch);
        
        //         // Decode response JSON to associative array
        //         $result = json_decode($response, true);
        
        //         if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
        //             echo 'Error decoding JSON response';
        //         } else {
        //             echo json_encode($result);
        //         }
        //     }
        // }
        
    
    }
    elseif (isset($_POST['id_pesanan']) && ($_POST['id_pesanan2'])) {
        echo ("masuk1");
        $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
        $id_pesanan2 = htmlspecialchars($_POST['id_pesanan2']);
        echo "<script>console.log('HALO');</script>";
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
              
                echo 'Error decoding JSON response';
            } else {
                // Output the response from API
                echo 'Response from API: ' . json_encode($result);
            }
        }
    }
    

}


?>