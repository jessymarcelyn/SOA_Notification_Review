<?php
if (isset($_POST['id_booking'])) {
    $id_booking = $_POST['id_booking'];
    $url = "http://3.226.141.243:8004/bookingDetails/" . $id_booking;

    // Inisialisasi cURL
    $ch = curl_init();

    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);
    $data = array();

    // Periksa kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Tutup cURL
        curl_close($ch);

        // Decode response JSON menjadi array asosiatif
        $result = json_decode($response, true);

        // Karna return ada code dan data
        if (isset($result['booking details'])) {
            $resultData = $result['booking details'];

            if ($resultData['booking_type'] == "Hotel") {
                $data = array(
                    'booking_type' => $resultData['booking_type'],
                    'provider_name' => $resultData['provider_name'],
                    'check_in' => $resultData['check_in_date'],
                    'check_out' => $resultData['check_out_date'],
                    'number_of_rooms' => $resultData['number_of_rooms'],
                    'number_of_nights' => $resultData['number_of_nights'],
                    'room_type_id' => $resultData['room_type'],
                    'total_price' => $resultData['total_price'],
                );

            } else if ($resultData['booking_type'] == "Airline") {
                $data = array(
                    'booking_type' => $resultData['booking_type'],
                    'provider_name' => $resultData['provider_name'],
                    'departure_date' => $resultData['departure_date'],
                    'arrival_date' => $resultData['arrival_date'],
                    'departure_city' => $resultData['departure_city'],
                    'arrival_city' => $resultData['arrival_city'],
                    'total_price' => $resultData['total_price'],
                );

            } else if ($resultData['booking_type'] == "Attraction") {

            } else if ($resultData['booking_type'] == "Rental") {

                $resultAsuransi =  getAsuransi($id_user, $resultData['asuransi_id']);
                $carDetail =  getCar($resultData['car_id']);

                $data = array(
                    'booking_type' => $resultData['booking_type'],
                    'provider_name' => $resultData['provider_name'],
                    'start_date' => $resultData['pickup_date'],
                    'end_date' => $resultData['return_date'],
                    'car_id' => $resultData['car_id'],
                    'total_price' => $resultData['total_price'],
                    'is_with_driver' => $resultData['is_with_driver'],
                    'biaya_asuransi' => $resultAsuransi,

                );



            }
        }
    }

    echo json_encode($result);
}

function getHotel($id_hotel)
{
    $url = "http:// ";

}

function getRental($id_rental)
{
    // $url = "http://3.228.174.120:/ ".;
}

function getAsuransi($id_user, $id_purchase)
{
    $url = "http://ec2-52-7-154-154.compute-1.amazonaws.com:8005/insurance/purchase/" . $id_user . "/" . $id_purchase;

    // Inisialisasi cURL
    $ch = curl_init();
    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);
    $total_bayar ="" ; 

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {

        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['data'])) {
            $resultData = $result['data'];

          $total_bayar = $resultData['total_bayar'];


        }
    }

    return $total_bayar;

}

function getCar($port, $id_car)
{
    $url = "http://3.228.174.120:{$port}/car/{$id_car}";

    // Inisialisasi cURL
    $ch = curl_init();
    
    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);
    $carDetail = array();

    if(curl_errno($ch)){
        echo 'Error:' . curl_error($ch);
    } else {
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['data'])) {
            $resultData = $result['data'];

            $carDetail = array(
                'nama_mobil' => $resultData['nama_mobil'],
                'harga' => $resultData['harga'],
                'gambar' => $resultData['gambar'],
            );
        }
    }


}

?>