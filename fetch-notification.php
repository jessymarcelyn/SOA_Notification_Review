<?php
// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Sisipkan file koneksi ke database
require "connect.php";
echo '<script>';
echo 'console.log("masuk");';
echo '</script>';
// Periksa apakah parameter type_notif dikirim melalui metode POST
if (isset($_POST['type_notif'])) {

    // Escape string untuk mencegah serangan SQL injection
    $type_notif = mysqli_real_escape_string($con, $_POST['type_notif']);

    // Query untuk mengambil notifikasi dengan type_notif yang sesuai
    $query = "SELECT * FROM notification WHERE type_notif = '$type_notif'";
    $result = mysqli_query($con, $query);
    $i=0;
    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Buat variabel untuk menyimpan hasil HTML notifikasi
        $notificationsHTML = '';
        echo '<script>';
        echo 'console.log("masuk");';
        echo '</script>';
        // Loop melalui hasil query untuk membuat HTML notifikasi
        while ($row = mysqli_fetch_assoc($result)) {
            // Ambil data notifikasi
            $title = $row['title'];
            $desc = $row['description'];
            $datetime = $row['date'];
            if ($i % 2 == 0)
                $notif = "successNotif";
            else
                $notif = "failedNotif";
            $i++;
            if($row['status']==1){
                $color="list-group-item-primary";
            }
            else{
                $color= "list-group-item-light";
            }

            // Buat HTML untuk setiap notifikasi
            $notificationsHTML .= '

                


            <a href="#" class="list-group-item list-group-item-action '.$color.' border-0">
                <div class="row g-1">
                    <div class="col-1 px-0 image">
                        <img src="image/room.jpg" alt="...">
                    </div>

                    <div class="col px-0 text ">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-1">' . $title . '</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#' . $notif . '">
                                TEST MODAL
                            </button>
                        </div>
                        <p class="mb-1">' . $desc . '</p>
                        <small>' . $datetime . '</small>
                    </div>
                </div>
            </a>
          ';
        }

        // Keluarkan HTML notifikasi yang telah dibuat
        echo $notificationsHTML;
    } else {
        // Jika query gagal dieksekusi, tampilkan pesan error
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Jika parameter type_notif tidak dikirim, tampilkan pesan error
    echo "Error: Parameter type_notif is required.";
}
?>