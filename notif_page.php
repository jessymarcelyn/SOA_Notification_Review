<?php
session_start();
require "connect.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking.com | Notification</title>

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


  <!-- <link rel="stylesheet" href="css/notification.css"> -->

</head>

<body>

  <div class="notif-content m-5">
    <nav>
      <div class="nav nav-tabs" id="pembayaran" role="tablist">
        <button class="nav-link active" id="pembayaran" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
          role="tab" aria-controls="nav-home" aria-selected="true">Keuangan</button>
        <button class="nav-link" id="info" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab"
          aria-controls="nav-profile" aria-selected="false">Info Pesanan</button>

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
        </div>

      </div>
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="list-group pt-2 ">

        </div>
      </div>
    </div>
  </div>



</body>

</html>

<script>
  $(document).ready(function () {
    $(document).on('click', '.list-group-item', function () {  // Gunakan event delegation untuk menangani click event
      console.log('Notifikasi di klik.');



      // Ambil ID notifikasi dari atribut data
      var id_notif = $(this).attr('id');
      console.log('ID Notifikasi:', id_notif);      


      $.ajax({
        url: "fetch-api-notif.php",
        method: 'POST',
        data: {
          id_notif: id_notif
        },
        success: function (response) {
          // Mengganti konten dari tab pane yang aktif dengan data notifikasi yang baru
          // $('.tab-pane.active').find('.list-group').html(response);
          console.log('Berhasil update notifikasi:', response);
        },
        error: function (xhr, status, error) {
          console.error('Gagal update notifikasi:', error);
          // Tambahkan logika untuk menangani kesalahan saat memuat notifikasi
        }
      });

      loadNotifications(idUser, notifType);
      var id_pesanan = $(this).attr('id_pesanan');
      var href = $(this).attr('href');
      if (href != "#"){
        event.preventDefault(); // Prevents the default action of the link

        window.location.href = `${href}?id_pesanan=${id_pesanan}&id_user=${idUser}`;

      }

      // Optional: Ganti atau tambahkan kelas pada elemen .list-group-item
      // $(this).removeClass('list-group-item-primary').addClass('list-group-item-light');
    });

    var idUser = 1;
    var notifType = "pembayaran";

    // Fungsi untuk memuat notifikasi dengan type_notif yang ditentukan
    function loadNotifications(idUser, notifType) {
      $.ajax({
        url: "fetch-api-notif.php",
        method: 'POST',
        data: {
          idUser: idUser,
          notifType: notifType
        },
        success: function (response) {
          // Mengganti konten dari tab pane yang aktif dengan data notifikasi yang baru
          $('.tab-pane.active').find('.list-group').html(response);
        },
        error: function (xhr, status, error) {
          console.error('Gagal memuat notifikasi:', error);
          // Tambahkan logika untuk menangani kesalahan saat memuat notifikasi
        }
      });
    }

    // Memuat notifikasi dengan type_notif = 1 saat halaman dimuat pertama kali
    loadNotifications(idUser, notifType);

    $(document).on('click', '.nav-link', function () {
      notifType = $(this).attr('id');
      // print(notifType);
      loadNotifications(idUser, notifType);
    });
  });

</script>