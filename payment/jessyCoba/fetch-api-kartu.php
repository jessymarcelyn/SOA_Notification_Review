<?php
// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['id_pesanan']) && ($_POST['id_pesanan2'])) {
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


// Periksa apakah parameter idUser dikirim melalui metode POST
elseif (isset($_POST['id_pesanan'])) {
    echo "<script>console.log('HALO');</script>";
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

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);

    // Periksa kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Tutup cURL
        curl_close($ch);

        // Decode response JSON menjadi array asosiatif
        $result = json_decode($response, true);

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON response';
            echo "<script>console.log('HALO');</script>";
        } else {
            // Output the response from API
            echo 'Response from API: ' . json_encode($result);
            echo "<script>console.log('HALO');</script>";
        }
    }
}


if (isset($_POST['nama']) && isset($_POST['nomer_kartu']) && isset($_POST['expired_month']) && isset($_POST['expired_year']) && isset($_POST['cvv']) && isset($_POST['nominal'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $nomer_kartu = htmlspecialchars($_POST['nomer_kartu']);
    $expired_month = htmlspecialchars($_POST['expired_month']);
    $expired_year = htmlspecialchars($_POST['expired_year']);
    $cvv = htmlspecialchars($_POST['cvv']);
    $nominal = htmlspecialchars($_POST['nominal']);

    // Construct the URL endpoint for the API request
    $url = "http://localhost:8000/kartu_kredit/{$nomer_kartu}/cvv/{$cvv}/nama/{$nama}/expired_month/{$expired_month}/expired_year/{$expired_year}/nominal/{$nominal}";


    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options for GET request
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL and fetch response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Close cURL session
        curl_close($ch);

        // Decode JSON response into associative array
        $result = json_decode($response, true);

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON response';
        } else {
            // Output the response from API
            echo 'Response from API: ' . json_encode($result);

            // Handle further logic based on API response
            if (isset($result['data']['status']) && $result['data']['status'] === true) {
                echo 'Response from API: ' . json_encode($result);
                echo "<script>console.log('HALO1');</script>";
                // Transaction approved: Show success modal
                echo '<div class="modal fade" id="successNotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header position-relative border-0">
                                <div class="bg-success position-absolute top-0 start-50 translate-middle" style="width: 50px; height: 50px; border-radius: 50%;"></div>
                                <span class="modal-close-icon position-absolute top-0 start-50 translate-middle fa-inverse">
                                    <i class="fas fa-check fa-2x fa-inverse"></i>
                                </span>
                            </div>
                            <div class="modal-body mt-3">
                                <div class="text-center">
                                    <h1 class="text-success">Success !</h1>
                                    <p class="text-success">Thank you for your order! Your payment has been successfully processed.</p>
                                </div>
                                <div class="modal-footer justify-content-center border-0 mt-4">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close"> Okay </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            } else {
                echo "<script>console.log('HALO2');</script>";
                // Transaction not approved: Show error message or handle as needed
                // echo '<div class="alert alert-danger" role="alert">
                //     Transaction not approved. Message: ' . $result['data']['message'] . '
                // </div>';
                 echo 'Response from API: ' . json_encode($result);
            }
        }
    }
}

