<div class="modal fade" id="failedNotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header position-relative border-0">
        <div class="bg-danger position-absolute top-0 start-50 translate-middle"
          style="width: 50px; height: 50px; border-radius: 50%;"></div>
        <span class="modal-close-icon position-absolute top-0 start-50 translate-middle fa-inverse">
          <i class="fas fa-times fa-2x fa-inverse"></i>
        </span>
      </div>
      <div class="modal-body mt-3">
        <div class="text-center">
          <h1 class="text-danger">Oh no!</h1>
          <p class="error-message text-danger"></p> <!-- Error message container -->
        </div>
        <div class="modal-footer justify-content-center border-0 mt-4">
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
        <div class="bg-success position-absolute top-0 start-50 translate-middle"
          style="width: 50px; height: 50px; border-radius: 50%;"></div>

        <span class="modal-close-icon position-absolute top-0 start-50 translate-middle fa-inverse">
          <i class="fas fa-check fa-2x fa-inverse"></i>
        </span>
      </div>
      <div class="modal-body mt-3">
        <div class="text-center">
          <!-- <i class="fas fa-exclamation-circle fa-5x text-danger"></i> -->
          <h1 class="text-success">Success !</h1>
          <p class="text-success">Thank you for your order! Your payment has been successfully processed.</p>
          <p class="text-success2">This is your OTP: <b><span id="isiOtp"></span></b></p>

        </div>
        <div class="modal-footer justify-content-center border-0 mt-4">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
          <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close"> Okay </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="successNotifVA" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header position-relative border-0">
        <div class="bg-success position-absolute top-0 start-50 translate-middle"
          style="width: 50px; height: 50px; border-radius: 50%;"></div>

        <span class="modal-close-icon position-absolute top-0 start-50 translate-middle fa-inverse">
          <i class="fas fa-check fa-2x fa-inverse"></i>
        </span>
      </div>
      <div class="modal-body mt-3">
        <div class="text-center">
          <!-- <i class="fas fa-exclamation-circle fa-5x text-danger"></i> -->
          <h1 class="text-success">Success !</h1>
          <p class="text-success">Thank you for your order! Your payment has been successfully processed.</p>
          <p class="text-success2">This is your VA: <b><span id="isiVA"></span></b></p>

        </div>
        <div class="modal-footer justify-content-center border-0 mt-4">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
          <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close"> Okay </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="successNotifPin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header position-relative border-0">
        <div class="bg-success position-absolute top-0 start-50 translate-middle"
          style="width: 50px; height: 50px; border-radius: 50%;"></div>

        <span class="modal-close-icon position-absolute top-0 start-50 translate-middle fa-inverse">
          <i class="fas fa-check fa-2x fa-inverse"></i>
        </span>
      </div>
      <div class="modal-body mt-3">
        <div class="text-center">
          <!-- <i class="fas fa-exclamation-circle fa-5x text-danger"></i> -->
          <h1 class="text-success">Success !</h1>
          <p class="text-success">Thank you for your order! Your payment has been successfully processed.</p>

        </div>
        <div class="modal-footer justify-content-center border-0 mt-4">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
          <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close"> Okay </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <div  id="autoCloseAlert"  class="alert alert-primary" role="alert">
  <a href="notif_page.php" class="alert-link" style="text-decoration: none; color: inherit; font-weight: normal;">Pembayaran sedang di proses!</a>
</div> -->





    <!-- <script>
        // Set timeout untuk menghilangkan alert setelah 1 menit (60000 milidetik)
        setTimeout(function() {
            document.getElementById('autoCloseAlert').style.display = 'none';
        }, 60000); // 60000 milidetik = 1 menit
    </script> -->