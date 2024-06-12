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
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successNotif">
    TEST MODAL
  </button>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#failedNotif">
    TEST MODAL
  </button>
  <div class="notif-content m-5">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
          role="tab" aria-controls="nav-home" aria-selected="true">Keuangan</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
          role="tab" aria-controls="nav-profile" aria-selected="false">Info Booking</button>

      </div>
    </nav>

    <div class="tab-content border-0" id="myTabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="list-group pt-2 ">
          <a href="#" class="list-group-item list-group-item-action list-group-item-primary border-0">
            <div class="row g-1">

              <div class="col px-0 text ">
                <div class="d-flex justify-content-between">
                  <h5 class="mb-1">Pembayaran anda sedang di proses</h5>
                  <small>2025-05-12 12:23</small>
              
                </div>
                <p class="mb-1">Silahkan masukan pin anda melalui link berikut</p>
              </div>
            </div>
          </a>

          <a href="#" class="list-group-item list-group-item-action '.$color.' border-0">
            <div class="row g-1">

              <div class="col px-0 text ">
                <div class="d-flex justify-content-between">
                  <h5 class="mb-1">Pembayaran anda sedang di proses</h5>
                  <small>2025-05-12 12:23</small>

                </div>
                <p class="mb-1">Silahkan masukan pin anda melalui link berikut</p>
              </div>
            </div>
          </a>
          <a href="#" class="list-group-item list-group-item-action '.$color.' border-0">
            <div class="row g-1">

              <div class="col px-0 text ">
                <div class="d-flex justify-content-between">
                  <h5 class="mb-1">Pembayaran anda sedang di proses</h5>
                  <small>2025-05-12 12:23</small>
                </div>
                <p class="mb-1">Silahkan masukan pin anda melalui link berikut</p>
              </div>
            </div>
          </a>
        </div>

      </div>
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="list-group pt-2 ">
          <a href="#" class="list-group-item list-group-item-action '.$color.' border-0">
            <div class="row g-1">

              <div class="col px-0 text ">
                <div class="d-flex justify-content-between">
                  <h5 class="mb-1">Perubahan keberangkatan pesawat</h5>
                </div>
                <p class="mb-1">Pesawat yang anda pesan mengalami perubahan jadwal keberangkatan menjadi pukul 18:00</p>
                <small>2025-05-12 11:23</small>
              </div>
            </div>
          </a>
          <a href="#" class="list-group-item list-group-item-action '.$color.' border-0">
            <div class="row g-1">

              <div class="col px-0 text ">
                <div class="d-flex justify-content-between">
                  <h5 class="mb-1">Perubahan keberangkatan pesawat</h5>
                </div>
                <p class="mb-1">Pesawat yang anda pesan mengalami perubahan jadwal keberangkatan menjadi pukul 18:00</p>
                <small>2025-05-12 11:23</small>
              </div>
            </div>
          </a>
          <a href="#" class="list-group-item list-group-item-action '.$color.' border-0">
            <div class="row g-1">

              <div class="col px-0 text ">
                <div class="d-flex justify-content-between">
                  <h5 class="mb-1">Perubahan keberangkatan pesawat</h5>
                </div>
                <p class="mb-1">Pesawat yang anda pesan mengalami perubahan jadwal keberangkatan menjadi pukul 18:00</p>
                <small>2025-05-12 11:23</small>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="failedNotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header position-relative border-0">
        <div class="bg-danger position-absolute top-0 start-50 translate-middle" style="width: 50px; height: 50px; border-radius: 50%;"></div>

          <span class="modal-close-icon position-absolute top-0 start-50 translate-middle fa-inverse">
            <i class="fas fa-times fa-2x fa-inverse"></i>
          </span>
          <!-- <div class="close-bg bg-danger position-absolute top-0 start-50 translate-middle"></div> -->
        </div>
        <div class="modal-body mt-3">
          <div class="text-center">
            <!-- <i class="fas fa-exclamation-circle fa-5x text-danger"></i> -->
            <h1 class="text-danger">Oh no!</h1>
            <p class="text-danger">Something went wrong. Please try again.</p>

          </div>
          <div class="modal-footer justify-content-center border-0 mt-4">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"> Try Again</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="successNotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
            <!-- <i class="fas fa-exclamation-circle fa-5x text-danger"></i> -->
            <h1 class="text-success">Success !</h1>
            <p class="text-success">Lorem ipsum dolor sit amet consectetur </p>

          </div>
          <div class="modal-footer justify-content-center border-0 mt-4">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close"> Okay </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>

<script>
  // var type_notif = 1;
  $(document).ready(function () {
      $('.list-group-item').on('click', function () {
        $(this).removeClass('list-group-item-primary');
        // $(this).addClass('list-group-item-light');
      });
    });
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