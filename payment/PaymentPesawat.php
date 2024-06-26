<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Import jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
    <link rel='icon' href='../images/logo.png' type='images/logo.png'>
    <title>Booking.com | Payment</title>

    <!-- Bootstrap CSS  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../css/payment.css">

</head>
<script>
    $(document).ready(function () {
        $("#toggleDetails").click(function () {
            $("#priceInfo").toggle();
            var text = $(this).text();
            $(this).text(text == "Hide Details" ? "Show Details" : "Hide Details");
        });
        const selectElement = document.getElementById("mySelect");

        const options = selectElement.options;

        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const imageUrl = option.dataset.image;

            if (imageUrl) {
                const image = document.createElement("img");
                image.src = imageUrl;
                image.style.marginRight = "5px"; // Adjust margin as needed

                option.parentNode.insertBefore(image, option);
            }
        }
    });
</script>

<body>

    <div class="container">
        <div class="row">
            <!-- Kolom pertama -->
            <div class="col-md-4 col-12">
                <div class="">
                    <!-- Kolom 1: Konten pertama -->
                    <section class="hotel">
                        <h4>Flight Summary</h4>
                        <p><strong>Booking ID:</strong> GA12345678</p>
                        <!-- <p><strong>Flight:</strong> Garuda Indonesia</p> -->
                        <!-- <div id="bookingID">
                        <p>Booking ID: <b>GA12345678</b></p>
                        </div> -->
                    </section>

                    <!-- Flight Details -->
                    <section class="bookDetail">
                        <h4>Your Flight Details</h4>
                        <div class="mb-3">
                            <h5>Departure</h5>
                            <p><strong>Jakarta (CGK) to Bali (DPS)</strong></p>
                            <p>Thu, June 20, 2024</p>
                            <p><span class="flight-time">08:00 AM</span> - <span class="flight-time">10:30 AM</span></p>
                            <p>Flight: <strong>Garuda Indonesia </strong></p>
                            <p class="flight-info">Class: Economy | Duration: 2h 30m</p>
                            <!-- <p class="flight-info">Aircraft: Boeing 737-800</p>
                            <p class="flight-info">Terminal: 1</p> -->
                        </div>
                        <div class="mb-3" id="returnFlightDetails">
                            <!-- <div class="mb-3" id="returnFlightDetails" style="display: none;"> -->
                            <h5>Return</h5>
                            <p><strong>Bali (DPS) to Jakarta (CGK)</strong></p>
                            <p>Sun, June 23, 2024</p>
                            <p><span class="flight-time">04:00 PM</span> - <span class="flight-time">06:30 PM</span></p>
                            <p>Flight: <strong> Garuda Indonesia</strong></p>
                            <p class="flight-info">Class: Economy | Duration: 2h 30m</p>
                            <!-- <p class="flight-info">Aircraft: Boeing 737-800</p>
                            <p class="flight-info">Terminal: 2</p> -->
                        </div>
                        <p style="margin-bottom: 1vh">Additional Information</p>
                        <div class="checklist">
                            <div class="checklist-item">
                                <input type="checkbox" id="item1" checked disabled>
                                <label for="item1">Included Insurance</label>
                                <span id="price">(Rp 1,800,000)</span>
                            </div>
                    </section>
                    <section class="price">
                        <div id="rincian">
                            <h4>Your Price Summary</h4>
                            <!-- <div class="row justify-content-start">
                                <div class="col-6">
                                    <p>Included isurance</p>
                                </div>
                                <div class="col-6 kanan" id="tes" style="padding-right:9vh">
                                    <p>Rp 1,800,000</p>
                                </div>
                            </div> -->
                        </div>
                        <div id="totalHarga">
                            <div class="row justify-content-start" style="padding-top:1vh">
                                <div class="col-6">
                                    <h4 style="padding-left:2vh">Total</h4>
                                </div>
                                <div class="col-6 kanan" style="padding-right:4vh">

                                    <h4 style="margin-left:-1.5vh">Rp 6,000,000</h4>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
            <!-- Kolom kedua -->
            <div class="col-md-8 col-12">
                <div class="">
                    <!-- Kolom 2: Konten kedua -->

                    <section class="bookForm">
                        <h3>How do you want to secure your booking?</h3>
                        <h5 style="color:#019af3; margin-top:2vh"><i class="fas fa-lock"
                                style="margin-right:5px; color:#019af3"></i>Secure Payment</h5>
                        <p style="margin-top:-1vh; margin-bottom:2vh"><b>All card information is fully encrypted, secure
                                and
                                protected</b></p>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item" id="creditCardOption">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" style="background-color:#95c7f3;"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        <div class="row justify-content-between">
                                            <div class="col-6">
                                                <p>Credit/ Debit Card</p>
                                            </div>
                                            <div class="col-6" style="padding-right: 5%; text-align:right">
                                                <!-- <img src="../icon/visa.png" class="my-image" style="width: 20%;"> -->
                                                <img src="../icon/mastercard.png" class="my-image" style="width: 15%;">
                                                <!-- <img src="../icon/american2.png" class="my-image" style="width: 20%;">
                        <img src="../icon/jcb4.png" class="my-image" style="width: 20%;"> -->
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample" style="border: 1px solid #ccc;">
                                    <div class="accordion-body">
                                        <div class="container text">
                                            <div class="row justify-content-start">
                                                <div class="col-6">
                                                    <label>
                                                        <p>Card holder name <span class="asterisk"
                                                                style="color:red">*</span></p>
                                                    </label>
                                                    <input id="cardHolderName" type="text" class="form-control"
                                                        name="name" required>
                                                </div>
                                                <div class="col-6">
                                                    <label>
                                                        <p>Credit/ Debit card number <span class="asterisk"
                                                                style="color:red">*</span></p>
                                                    </label>
                                                    <input id="cardNumber" type="text" class="form-control" name="name"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container text">
                                            <div class="row justify-content-start">
                                                <div class="col-6">
                                                    <label>
                                                        <p>Expiry date <span class="asterisk"
                                                                style="color:red;">*</span></p>
                                                    </label>
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <input id="expiryMonth" type="text" class="form-control"
                                                            name="expiry-month" placeholder="MM" required
                                                            style="width: 30%;">
                                                        <span style="font-size: 1.5em;">/</span>
                                                        <input id="expiryYear" type="text" class="form-control"
                                                            name="expiry-year" placeholder="YYYY" required
                                                            style="width: 40%;">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label>
                                                        <p>CVC/ CVV <span class="asterisk" style="color:red">*</span>
                                                        </p>
                                                    </label>
                                                    <input id="cvc" type="text" class="form-control" name="name"
                                                        required style="width:70%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item" id="digitalPaymentOption">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" style="background-color:#95c7f3; "
                                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                        aria-expanded="false" aria-controls="flush-collapseTwo">
                                        <div class="row justify-content-between">
                                            <div class="col-6">
                                                <p>Digital Payment</p>
                                            </div>
                                            <div class="col-6" style="padding-right: 5%; text-align:right">
                                                <img src="../icon/ovo.png" class="my-image" style="width:15%;">
                                                <img src="../icon/gopay.png" class="my-image" style="width: 25%;">
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body" style="border: 1px solid #ccc;">
                                        <div class="container text">
                                            <label>
                                                <p>Choose provider <span class="asterisk" style="color:red">*</span></p>
                                            </label>
                                            <select id="digitalProvider" class="form-select"
                                                aria-label="Default select example" style="font-size: 13px;">

                                                <option value="ovo" data-image="icon/bca.png" selected>OVO</option>
                                                <option value="gopay" data-image="icon/mandiri.png">GOPAY</option>
                                                <!-- <option value="bri" data-image="icon/bri.png">BRI</option>
                        <option value="bni" data-image="icon/bni.png">BNI</option> -->
                                            </select>
                                            <label style="margin-top:1vh">
                                                <p>Enter your mobile number (without country code) <span
                                                        class="asterisk" style="color:red">*</span></p>
                                            </label>
                                            <input id="mobileNumber" type="text" class="form-control" name="name"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item" id="bankTransferOption">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" style="background-color:#95c7f3;"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                        aria-expanded="false" aria-controls="flush-collapseThree">
                                        <div class="row justify-content-between">
                                            <div class="col-6">
                                                <p>Bank Transfer</p>
                                            </div>
                                            <div class="col-6" style="padding-right: 5%; text-align:right">
                                                <img src="../icon/bca.png" class="my-image" style="width: 15%;">
                                                <img src="../icon/mandiri.png" class="my-image" style="width: 15%;">
                                                <!-- <img src="../icon/bri.png" class="my-image" style="width: 20%;">
                          <img src="../icon/bni.png" class="my-image" style="width: 20%;"> -->
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body " style="border: 1px solid #ccc;">
                                        <div class="container text">
                                            <label>
                                                <p>Choose bank <span class="asterisk" style="color:red">*</span></p>
                                            </label>
                                            <select id="bank" class="form-select" aria-label="Default select example"
                                                style="font-size: 13px;">
                                                <option value="bca" data-image="icon/bca.png" selected>BCA</option>
                                                <option value="mandiri" data-image="icon/mandiri.png">Mandiri</option>
                                                <!-- <option value="bri" data-image="icon/bri.png">BRI</option>
                        <option value="bni" data-image="icon/bni.png">BNI</option> -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p style="padding-top: 5vh;">By proceeding with this booking, I agree to SOA’s Terms of Use and
                            Privacy
                            Policy.</p>
                        <div class="col text-end"> <!-- text-end class aligns content to the right -->
                            <button id="bookNowBtn" type="button"
                                style="margin-top: 1vh; margin-right: 0.5vh; font-size: 14px;" class="btn btn-primary">
                                <i class="fas fa-lock" style="margin-right: 8px;"></i>
                                PAY NOW!
                            </button>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {

            var selectedPaymentMethod = ""; // Variabel untuk menyimpan metode pembayaran yang dipilih



            // Ketika accordion item dibuka
            $(".accordion-item").on('shown.bs.collapse', function () {
                // Bersihkan formulir
                $("input[type='text']").val('');
                selectedPaymentMethod = $(this).attr("id");;
                console.log(selectedPaymentMethod) // Reset variabel selectedPaymentMethod
                $("#bank").val("bca");

            });

            // Ketika tombol "Book Now" diklik
            $("#bookNowBtn").click(function () {
                if (selectedPaymentMethod) { // Jika metode pembayaran dipilih
                    switch (selectedPaymentMethod) {
                        case "creditCardOption":
                            if ($("#cardHolderName").val() === "" || $("#cardNumber").val() === "" || $("#expiryMonth").val() === "" || $("#expiryYear").val() === "" || $("#cvc").val() === "") {
                                alert("Please fill in all required fields.");
                                return;
                            }
                            // Kumpulkan data dari formulir kartu kredit/debit
                            paymentData = {
                                method: "Credit/Debit Card",
                                cardHolderName: $("#cardHolderName").val(),
                                cardNumber: $("#cardNumber").val(),
                                expiryMonth: $("#expiryMonth").val(),
                                expiryYear: $("#expiryYear").val(),
                                cvc: $("#cvc").val()
                            };
                            console.log(paymentData); // Lakukan tindakan dengan data yang dikumpulkan
                            alert("Processing credit/debit card payment...");
                            break;
                        case "digitalPaymentOption":
                            if ($("#mobileNumber").val() === "") {
                                alert("Please fill in all required fields.");
                                return;
                            }
                            // Kumpulkan data dari formulir pembayaran digital
                            var provider = $("#digitalProvider").val();
                            var mobileNumber = $("#mobileNumber").val();
                            console.log({
                                method: "Digital Payment",
                                provider: provider,
                                mobileNumber: mobileNumber
                            });

                            // Contoh pengiriman data ke server
                            $.ajax({
                                url: 'fetch-api-DigitalPayment.php',
                                method: 'POST',
                                data: {
                                    id_pesanan: id_pesanan,
                                    method: "Digital Payment",
                                    provider: provider,
                                    mobileNumber: mobileNumber,
                                    nominal: 1000
                                },
                                success: function (response) {

                                    // console.log(response);
                                    if (response == "true") {
                                        // console.log(response, "2")
                                        console.log('Payment data submitted successfully');
                                        $('#successNotif').modal('show');


                                    } else {
                                        const errorMessageElement = document.querySelector('p.text-danger');
                                        errorMessageElement.textContent = response;
                                        // console.log('Error submitting payment data');
                                        $('#failedNotif').modal('show');

                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error('AJAX Error:', error); // Handle AJAX errors
                                    $('#failedNotif').modal('show');
                                }
                            });

                            break;
                        case "bankTransferOption":
                            // Kumpulkan data dari formulir transfer bank
                            paymentData = {
                                method: "Bank Transfer",
                                bank: $("#bank").val()
                            };
                            console.log(paymentData); // Lakukan tindakan dengan data yang dikumpulkan
                            alert("Processing bank transfer payment...");
                            break;
                        default:
                            // Tindakan jika tidak ada metode pembayaran yang dipilih
                            alert("Please select a payment method.");
                    }
                    // Contoh pengiriman data ke server
                    /*
                    $.ajax({
                      url: 'your-server-endpoint',
                      method: 'POST',
                      data: paymentData,
                      success: function(response) {
                        console.log('Payment data submitted successfully');
                      },
                      error: function(error) {
                        console.log('Error submitting payment data', error);
                      }
                    });
                    */
                } else {
                    // Tampilkan pesan jika tidak ada metode pembayaran yang dipilih
                    alert("Please select a payment method before proceeding.");
                }
            });
        });



        // Fungsi untuk memuat membuat transaksi pertama kali dengan status "initial" 
        function createTransaction(id_pesanan) {
            console.log('id_pesanan:', id_pesanan);
            $.ajax({
                url: "fetch-api-kartu.php",
                method: 'POST',
                data: {
                    id_pesanan: id_pesanan
                },
                success: function (response) {
                    console.log(response);
                    console.log('Berhasil buat Initial Transaksi1 ');
                },
                error: function (xhr, status, error) {
                    console.error('Gagal membuat transaksi:', error);
                }
            });
        }

        // Fungsi untuk memuat membuat transaksi pertama kali dengan status "initial" khusus pesawat PP
        function createTransaction2(id_pesanan, id_pesanan2) {
            console.log('id_pesanan:', id_pesanan);
            console.log('id_pesanan2:', id_pesanan2);
            $.ajax({
                url: "fetch-api-kartu.php",
                method: 'POST',
                data: {
                    id_pesanan: id_pesanan,
                    id_pesanan2: id_pesanan2
                },
                success: function (response) {
                    console.log(response);
                    console.log('Berhasil buat Initial Transaksi2;');
                },
                error: function (xhr, status, error) {
                    console.error('Gagal membuat transaksi:', error);
                }
            });
        }

        function checkKartu(id_pesanan, nama, nomer_kartu, expired_month, expired_year, cvv, nominal) {
            console.log('Checking kartu...');

            $.ajax({
                url: "fetch-api-kartu.php",
                method: 'POST',
                dataType: 'json', // Specify dataType as json
                data: {
                    id_pesanan: id_pesanan,
                    nama: nama,
                    nomer_kartu: nomer_kartu,
                    expired_month: expired_month,
                    expired_year: expired_year,
                    cvv: cvv,
                    nominal: nominal
                },
                success: function (response) {
                    console.log('Response:', response); // Log the response to inspect it

                    // Check if response code is 200 for success
                    if (response.code === 200) {
                        $('#isiOtp').text(response.data.otp);
                        $('#successNotif').modal('show'); // Show success modal

                    } else {
                        $('.error-message').text(response.data.message);
                        $('#failedNotif').modal('show'); // Show failed modal

                    }
                },
                error: function (xhr, status, error) {
                    console.error('Failed to check user input:', error);
                    $('#failedNotif').modal('show'); // Show failed modal due to error
                }
            });
        }

        function TransferBankBCA(id_pesanan, bank) {
            console.log('Trying to make a payment with ' + bank + ' dengan id pesanan: ' + id_pesanan);
            if (bank == "bca") {
                $.ajax({
                    url: "fetch-api-TransferBank.php",
                    method: 'POST',
                    data: {
                        id_pesanan: id_pesanan,
                        bank: "BCA",
                    },
                    dataType: 'json', // Ensures jQuery parses the response as JSON
                    success: function (response) {
                        console.log('Payment bakalan sukses');
                        console.log('Full response from server:', response);

                        if (response.code === 200) {
                            $('#isiVA').text(response.data.va);
                            $('#successNotifVA').modal('show'); // Show success modal

                            console.log('BERHASIL');
                        } else {
                            $('.error-message').text(response.data.message);
                            $('#failedNotif').modal('show'); // Show failed modal

                            console.log('GAGAL');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Ada yang salah: ', error);
                        console.log('Full error response: ', xhr.responseText);
                    }
                })
            } else {

                $.ajax({
                    url: "fetch-api-TransferBank.php",
                    method: 'POST',
                    data: {
                        id_pesanan: id_pesanan,
                        bank: "Mandiri",
                    },
                    dataType: 'json', // Ensures jQuery parses the response as JSON
                    success: function (response) {
                        console.log('Full response from server:', response);
                        console.log('Payment bakalan sukses');
                        if (response.code === 200) {
                            $('#isiVA').text(response.data.va);
                            $('#successNotifVA').modal('show'); // Show success modal

                            console.log('BERHASIL');
                        } else {
                            $('.error-message').text(response.data.message);
                            $('#failedNotif').modal('show'); // Show failed modal

                            console.log('GAGAL');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Ada yang salah: ', error);
                        console.log('Full error response: ', xhr.responseText);
                    }
                })

            }
        }
    </script>


</body>

</html>