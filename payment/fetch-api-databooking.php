<?php
if (isset($_POST['id_pesanan'])) {
    // $id_pesanan = $_POST['id_pesanan'];
    // echo "Received ID Pesanan: " . $id_pesanan;  // Debugging

    // $data = getCar(8001, "1") ;
    // $data = getRental(8001);
    // $data = array(
    //     "brand" => "Toyota",
    //     "nama" => "Avanza",
    //     "tahun" => "2019"
    // );

    $id_booking = $_POST['id_pesanan'];
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
            $resultData = "Rental";
            if ($resultData['booking_type'] == "Hotel") {
                $extraDataHotel = get_address($resultData['room_type'], $resultData['provider_name']);
                $room_type = $extraDataHotel['room_type'];
                $address = $extraDataHotel['address'];
                $data = array(
                    'booking_type' => $resultData['booking_type'],
                    'provider_name' => $resultData['provider_name'],
                    'check_in' => $resultData['check_in_date'],
                    'check_out' => $resultData['check_out_date'],
                    'number_of_rooms' => $resultData['number_of_rooms'],
                    'number_of_nights' => $resultData['number_of_nights'],
                    'total_price' => $resultData['total_price'],
                    'address' => $address,
                    'room_type' => $room_type,

                );

            } else if ($resultData['booking_type'] == "Airline") {


                $extraData = getPesawat($resultData['flight_id']);
                $resultAsuransi = getAsuransi($id_user, $resultData['asuransi_id']);


                $data = array(
                    'booking_type' => $resultData['booking_type'],
                    'provider_name' => $resultData['provider_name'],
                    'departure_date' => $resultData['departure_date'],
                    'arrival_date' => $resultData['arrival_date'],
                    'booking_code' => $extraData['booking_code'],
                    'airport_origin_location_code' => $extraData['airport_origin_location_code'],
                    'airport_origin_city_name' => $extraData['airport_origin_city_name'],
                    'airport_destination_location_code' => $extraData['airport_destination_location_code'],
                    'airport_destination_city_name' => $extraData['airport_destination_city_name'],
                    'class'=> $extraData['class_name'],
                    'start_time' => $extraData['start_time'],
                    'end_time' => $extraData['end_time'],
                    'asuransi' => $resultAsuransi,
                    'total_price' => $resultData['total_price'],

                );

            } else if ($resultData['booking_type'] == "Attraction") {
                $data = array(
                    'booking_type' => $resultData['booking_type'],
                    'provider_name' => $resultData['provider_name'],
                    'paket_attraction_id' => $resultData['paket_attraction_id'],
                    'visit_date' => $resultData['visit_date'],
                    'total_price' => $resultData['total_price'],
                    'total_tickets' => $resultData['total_tickets'],
                );

            } else if ($resultData['booking_type'] == "Rental") {
                $nama = $resultData['provider_name'];
                $port = 8001;
                if ($nama == "ada_kawan_jogja") {
                    $port = 8001;
                } else if ($nama == "arasya_jakarta") {
                    $port = 8002;
                } else if ($nama == "empat_roda_jogja") {
                    $port = 8003;
                } else if ("jayamahe_easy_ride_jakarta") {
                    $port = 8004;
                } else if ("moovby_driverless_jakarta") {
                    $port = 8005;
                } else if ("puri_bali") {
                    $port = 8006;
                }

                $address = getRental($port);
                $carDetail = getCar($port, $resultData['car_id']);
                $resultAsuransi = getAsuransi($id_user, $resultData['asuransi_id']);

                $data = array(
                    'booking_type' => $resultData['booking_type'],
                    'provider_name' => $resultData['provider_name'],
                    'start_date' => $resultData['pickup_date'],
                    'end_date' => $resultData['return_date'],
                    'car_id' => $resultData['car_id'],
                    'total_price' => $resultData['total_price'],
                    'is_with_driver' => $resultData['is_with_driver'],
                    'biaya_asuransi' => $resultAsuransi,
                    'car_brand' => $carDetail['brand'],
                    'car_name' => $carDetail['nama'],
                    'car_year' => $carDetail['tahun'],
                    'address' => $address,


                );



            }
        }
    }

    echo json_encode($data);
} else {
    echo json_encode(['code' => 500, 'message' => 'Error executing ']);
}



function getAttraction($attraction, $id_paket)
{
    if ($attraction == 'dufan') {
        $url = "http://3.217.250.166:8003";
    } else if ($attraction == 'balizoo') {
        $url = "http://52.6.192.248:8003";
    } else if ($attraction == 'waterboom') {
        $url = "http://44.222.16.57:8003";
    } else if ($attraction == 'seaworld') {
        $url = "http:// 34.194.127.109:8003";
    } else if ($attraction == 'prambanan') {
        $url = "http:// 34.193.181.49:8003";

    } else if ($attraction == 'trans studio') {
        $url = "http://34.193.181.49:8007";
    }
    $url = $url . "/api/atraksi/paket/" . $id_paket;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


    $response = curl_exec($ch);
    $packageName = "";

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        curl_close($ch);

        $result = json_decode($response, true);

        $packageName = $result['title'];

        return $packageName;

    }

}




function get_address($id_type, $provider_name)
{
    if ($provider_name == 'merlynn park hotel') {
        $url = "http://52.200.174.164:8003";
    } else if ($provider_name == 'jayakarta sp hotel') {
        $url = "http://44.218.207.165:8009";
    } else if ($provider_name == 'artotel suites bianti') {
        $url = "http://50.16.176.111:8005";
    } else if ($provider_name == 'Yogyakarta mariott') {
        $url = "http://3.215.46.161:8011";
    } else if ($provider_name == 'Hilton bali resort') {
        $url = "http://3.215.46.161:8013";
    } else if ($provider_name == 'Borobudur hotel Jakarta') {
        $url = "http://100.28.104.239:8007";
    }
    $url = $url . "/hotel";


    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


    $response = curl_exec($ch);
    $dataHotel = array();
    $room_type = get_room_type($id_type, $url);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        curl_close($ch);

        $result = json_decode($response, true);

        $dataHotel = array(
            'address' => $result['address'],
            'room_type' => $room_type,
        );


        return $dataHotel;

    }

}
function get_room_type($id_type, $url)
{


    $url = $url . "/hotel/room_type/" . $id_type;

    $ch = curl_init();
    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);
    $tipe_kamar = "";

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        curl_close($ch);

        $result = json_decode($response, true);

        $tipe_kamar = $result['type'];

        //  if (isset($result['data'])) {
        //      $resultData = $result['data'];

        //  $HotelDetail = array(
        //      'hotel_id' => $resultData['hotel_id'],
        //      'type' => $resultData['type'],
        //      'image' => $resultData['image'],
        //      'detail' => $resultData['detail'],
        //      'facilities' => $resultData['facilities'],
        //      'total_room' => $resultData['total_room'],
        //      'capacity' => $resultData['capacity'],
        //      'price' => $resultData['price'],
        //  );

        return $tipe_kamar;

    }


}

function getPesawat($id_pesawat)
{
    $url = "http://107.20.145.163:8003/airlines/airport_origin_location_code/-/airport_destination_location_code/-/minprice/-/maxprice/-/date/-/start_time/-/end_time/-/sort/-";
    $ch = curl_init();
    // Setel opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Eksekusi cURL dan ambil hasilnya
    $response = curl_exec($ch);
    $PesawatDetail = array();

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['data'])) {
            $resultData = $result['data'];

            $PesawatDetail = array(
                'flight_code' => $resultData['flight_code'],
                'airport_origin_name' => $resultData['airport_origin_name'],
                'airport_origin_location_code' => $resultData['airport_origin_location_code'],
                'airport_origin_city_name' => $resultData['airport_origin_city_name'],
                'airport_destination_name' => $resultData['airport_destination_name'],
                'airport_destination_location_code' => $resultData['airport_destination_location_code'],
                'airport_destination_city_name' => $resultData['airport_destination_city_name'],
                'start_time' => $resultData['start_time'],
                'end_time' => $resultData['end_time'],
                'class_name' => $resultData['class_name'],
                // 'price' => $resultData['price'],
                'date' => $resultData['date'],
            );

            return $PesawatDetail;
        }
    }


}

function getRental($port)
{
    $url = "http://3.228.174.120:{$port}/provider";

    // Inisialisasi cURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    $address = "";

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        curl_close($ch);

        $result = json_decode($response, true);
        $result = $result[0];
        if (isset($result['provider_address']) && isset($result['provider_city'])) {
            // Concatenate address and city
            $address = $result['provider_address'] . ", " . $result['provider_city'];
        }
    }

    return $address;
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

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['data'])) {
            $resultData = $result['data'];

            $carDetail = array(
                'brand' => $resultData['car_brand'],
                'nama' => $resultData['car_name'],
                'tahun' => $resultData['car_year'],
            );
        }
    }
    return $carDetail;

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
    $total_bayar = "";

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



?>