<?php
session_start();
require "connect.php";

$id_pesanan = $_GET['id_pesanan'];
$id_user = $_GET['id_user'];


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking.com</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Import jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link rel='icon' href='images/logo.png' type='images/logo.png'>

    <!-- Bootstrap CSS  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/inputVA.css">

</head>

<body>
    <?php include 'notif_modal.php'; ?>
    <div class="container-fluid full-screen pinInputs" data-id-pesanan="<?php echo htmlspecialchars($id_pesanan); ?>">
        <div class="row">
            <div class="content">
                <h2>Virtual Account Number</h2>
                <p>Please enter to continue</p>
                <div class="content2">
                    <form action="" method="post">
                        <div id="noRekInputs">
                            <input class="form-control" type="tel" placeholder="Virtual Account Number" id="VAInput" name="VA" aria-label="default input example" maxlength="16">
                        </div>
                    </form>
                    <div class="content2 mt-4">
                        <p style="margin-bottom: -5vh; text-align:center; margin-top:10px">Enter PIN</p>
                        <div id="pinInputs">
                            <input type="password" class="pin-box" maxlength="1" readonly>
                            <input type="password" class="pin-box" maxlength="1" readonly>
                            <input type="password" class="pin-box" maxlength="1" readonly>
                            <input type="password" class="pin-box" maxlength="1" readonly>
                            <input type="password" class="pin-box" maxlength="1" readonly>
                            <input type="password" class="pin-box" maxlength="1" readonly>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button id="submitPin" class="btn btn-primary kirim" type="submit" disabled>Kirim</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-end">
            <div class="keyboard">
                <button class="key" data-key="1">1</button>
                <button class="key" data-key="2">2</button>
                <button class="key" data-key="3">3</button>
                <button class="key" data-key="4">4</button>
                <button class="key" data-key="5">5</button>
                <button class="key" data-key="6">6</button>
                <button class="key" data-key="7">7</button>
                <button class="key" data-key="8">8</button>
                <button class="key" data-key="9">9</button>
                <button class="key" data-key="backspace"> &larr; </button>
                <button class="key" data-key="0">0</button>
                <button class="key" data-key="submit" id="submitOk">OK</button>
            </div>
        </div>
    </div>

    <script>
        const pinInputsDiv = document.querySelector('.pinInputs'); // Menggunakan selector yang benar
        const idPesanan = pinInputsDiv.getAttribute('data-id-pesanan');
        // $(document).ready(function() {
        //     // You might need to set id_pesanan dynamically
        //     var id_pesanan = 98; // Example static value
        //     console.log("id_pesanan: "+ id_pesanan);
        // });

        document.addEventListener('DOMContentLoaded', () => {
            const VAInput = document.getElementById('VAInput');
            const pinInputs = document.querySelectorAll('.pin-box');
            const keys = document.querySelectorAll('.key');
            const submitPinButton = document.getElementById('submitPin');
            const submitOkButton = document.getElementById('submitOk');
            let currentPinIndex = 0;

            const handlePinInput = (keyValue) => {
                if (keyValue === 'backspace') {
                    if (currentPinIndex > 0) {
                        pinInputs[currentPinIndex - 1].value = '';
                        currentPinIndex--;
                    }
                } else if (!isNaN(keyValue)) {
                    if (currentPinIndex < pinInputs.length) {
                        pinInputs[currentPinIndex].value = keyValue;
                        currentPinIndex++;
                    }
                }
                checkIfAllFieldsAreFilled();
            };

            const checkIfAllFieldsAreFilled = () => {
                const VAInputFilled = VAInput.value.trim().length === 15;
                const pinInputsFilled = Array.from(pinInputs).every(input => input.value.trim() !== '');
                submitPinButton.disabled = !(VAInputFilled && pinInputsFilled);
                submitOkButton.disabled = !(VAInputFilled && pinInputsFilled);
            };

            const submitPin = () => {
                if (!submitPinButton.disabled) {
                    const va = VAInput.value.trim();
                    const pin = Array.from(pinInputs).map(input => input.value.trim()).join('');
                    // const id_pesanan = 98; // Replace with the actual id_pesanan value

                    pay(idPesanan, va, pin);
                }
            };

            keys.forEach(key => {
                key.addEventListener('click', () => {
                    const keyValue = key.dataset.key;
                    if (keyValue === 'submit') {
                        submitPin();
                    } else {
                        handlePinInput(keyValue);
                    }
                });
            });

            document.addEventListener('keydown', (event) => {
                const key = event.key;
                if (document.activeElement === VAInput) {
                    return; // Ignore key presses if VAInput is focused
                }
                if (key >= '0' && key <= '9') {
                    handlePinInput(key);
                } else if (key === 'Backspace') {
                    handlePinInput('backspace');
                } else if (key === 'Enter') {
                    submitPin();
                }
            });

            submitPinButton.addEventListener('click', submitPin);

            VAInput.addEventListener('input', () => {
                if (VAInput.value.length > 16) {
                    VAInput.value = VAInput.value.slice(0, 16); // Limit to 16 characters
                }
                checkIfAllFieldsAreFilled();
            });
        });

        // Fungsi untuk bayar (cek va dan pin)
        function pay(id_pesanan, va, pin) {
            console.log('id_pesanan: ', id_pesanan);
            console.log('VA: ', va);
            console.log('pin: ', pin);
            $.ajax({
                url: "fetch-api-VA.php",
                method: 'POST',
                data: {
                    id_pesanan: id_pesanan,
                    va: va,
                    pin: pin
                },
                success: function(response) {
                    console.log('Response:', response);
                    console.log('Berhasil');
                    if (response === 2) {
                        console.log("expired");
                        $('#error-message').text("We're sorry, but your payment request has expired. Please initiate a new transaction to complete your payment.");
                        $('#failedNotif').modal('show');
                        setTimeout(function() {
                            window.location.href = 'notif_page.php'; // Redirect to notif_page.php after 3 seconds
                        }, 3000);
                    }
                    else if (response.data == true) {
                        console.log("bisa");
                        $('#successNotif').modal('show');
                        setTimeout(function() {
                            window.location.href = 'notif_page.php'; // Redirect to notif_page.php after 3 seconds
                        }, 3000);
                    } else {
                        console.log("gagal bayar?")
                        $('#failedNotif').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Ada yang salah: ', error);
                    console.log('Full error response: ', xhr.responseText);
                }
            });
        }
    </script>
</body>

</html>