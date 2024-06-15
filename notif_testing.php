<?php
session_start();
require "connect.php";



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking.com</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Import jquery cdn -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <link rel='icon' href='images/logo.png' type='images/logo.png'>

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


  <link rel="stylesheet" href="css/notification.css">

</head>


<body>
  <?php include 'notif_modal.php'; ?>

  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successNotif">
    TEST MODAL
  </button>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#failedNotif">
    TEST MODAL
  </button>





</body>

</html>

<script>
  // var type_notif = 1;

  $(document).ready(function () {
    // var type_notif = 1;

    // Fungsi untuk memuat notifikasi dengan type_notif yang ditentukan
    // function loadNotifications(type) {
    //   $.ajax({
    //     url: 'fetch-notification.php',
    //     method: 'POST',
    //     data: { type_notif: type },
    //     success: function (response) {
    //       // Mengganti konten dari tab pane yang aktif dengan data notifikasi yang baru
    //       $('.tab-pane.active').find('.list-group').html(response);
    //     }
    //   });
    // }

    // // Memuat notifikasi dengan type_notif = 1 saat halaman dimuat pertama kali
    // loadNotifications(type_notif);
    // Event listener untuk setiap kali tab diubah
    // $('.nav-link').on('click', function () {
    //   // Mengambil id tab yang aktif
    //   var activeTab = $(this).attr('data-bs-target');
    //   console.log(type_notif);
    //   console.log(activeTab);

    //   if (activeTab == "#nav-home") {
    //     type_notif = 1;
    //   }
    //   else if (activeTab == "#nav-profile") {
    //     type_notif = 0;
    //   }
    //   // Melakukan request AJAX untuk mengambil data notifikasi dengan type_notif = 2
    //   $.ajax({
    //     url: 'fetch-notification.php', // Ubah sesuai dengan file yang berisi script PHP untuk mengambil notifikasi
    //     method: 'POST',
    //     data: { type_notif: type_notif }, // Mengirim parameter type_notif
    //     success: function (response) {
    //       // Mengganti konten dari tab pane yang aktif dengan data notifikasi yang baru
    //       $(activeTab).find('.list-group').html(response);
    //     }
    //   });
    // });
  });
</script>