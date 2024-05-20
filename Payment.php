<!doctype html>
<?php
session_start();
require "connect.php";
?>


<html>

<head>
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Import jquery cdn -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <link rel='icon' href='images/logo.png' type='images/logo.png'>
  <title>Booking.com | Payment</title>

  <!-- Bootstrap CSS  -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="css/payment.css">
</head>

<script>
  $(document).ready(function() {
    $("#toggleDetails").click(function() {
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
    <div class="container text-center">
      <div class="row justify-content-start">
        <div class="col-md-5">
          <div class="kiri">
            <section class="hotel">
              <p>Hotel</p>
              <H4>The Kayuan Lumbur Resort ubud</H4>
              <div id="location">
                <p>Jalan Katik Lantang, 80571 Ubud, Indonesia</p>
                <p style="color: green">Excellent Location -- 9.2</p>
              </div>
              <div id="rate">
                <div class="square">9.3</div>
                <p style="margin-left:1vh"> Wonderful</p>
                <div class="dot"></div>
                <p style="margin-left:1vh; color:gray">3 reviews</p>
              </div>
              <div id="facility">
                <p><i class="fas fa-wifi"></i> Free Wifi </p>
                <p><i class="fas fa-shuttle-van"></i> Airport Shuttle </p>
                <p> <i class="fas fa-parking"></i> Parking</p>
                <p> <i class="fas fa-utensils"></i> Resturant</p>
                <p> <i class="fas fa-swimming-pool"></i> Swimming Pool</p>
              </div>
            </section>
            <section class="bookDetail">
              <H4>Your Booking Details</H4>
              <div class="row justify-content-start">
                <div class="col-4" style="width: 30vh;">
                  <p>Check-in</p>
                  <h5 style="margin-top:2vh;margin-bottom: 1vh;">Thu, May 23, 2024</h5>
                  <p>From 2:00 PM</p>
                  <br>
                  <p>Total length of stay:</p>
                  <p><b>2 nights</b></p>
                </div>
                <div class="col-4" style="width: 30vh;">
                  <p>Check-out</p>
                  <h5 style="margin-top:2vh;margin-bottom: 1vh;">Thu, May 25, 2024</h5>
                  <p>7:00 AM - 12:00 PM</p>
            </section>
            <section class="price">
              <div id="rincian">
                <h4>Your Price Summary</h4>
                <div class="row justify-content-start">
                  <div class="col-4" style="width: 30vh;">
                    <p>Original price</p>
                    <p>Limited-time Deal</p>
                    <br>
                    <p>Total length of stay:</p>
                    <p><b>2 nights</b></p>
                  </div>
                  <div class="col-4 kanan" id="tes" style="width: 30vh;">
                    <p>Rp 7,800,000</p>
                    <p style="margin-left:-1.5vh">- Rp 3,900,000</p>
                  </div>
                </div>
              </div>
              <div id="totalHarga">
                <div class="row justify-content-start">
                  <div class="col-4" style="width: 30vh;">
                    <br>
                    <h4 style="padding-left:2vh">Total</h4>
                  </div>
                  <div class="col-4 kanan" style="width: 30vh;">
                    <p style="color:red;  text-decoration: line-through;">Rp 7,800,000</p>
                    <h4 style="margin-left:-1.5vh">Rp 3,900,000</h4>
                    <p style="margin-top: -1vh;color:gray">Include taxes and fees</p>
                  </div>
                </div>
              </div>
              <div id="priceInfo">
                <p><b>Price Information</b></p>
                <p><i class="fas fa-money-bill-wave" style="margin-right: 15px;  margin-top: 1vh;"></i>Includes Rp 354,545 in taxes and fees (10%)</p>

              </div>
              <br>
              <p id="toggleDetails" style="color:blue">Hide Details</p>
            </section>
          </div>
        </div>
        <div class="col-md-5">
          <div class="kanann">
            <section class="bookForm">
              <h3>How do you want to secure your booking?</h3>
              <h5 style="color:#019af3; margin-top:2vh"><i class="fas fa-lock" style="margin-right:5px; color:#019af3"></i>Secure Payment</h5>
              <p style="margin-top:-1vh; margin-bottom:2vh"><b>All card information is fully encrypted, secure and protected</b></p>
              <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" style="background-color:#95c7f3;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                      <div class="row justify-content-between">
                        <div class="col-6">
                          <p>Credit/ Debit Card</p>
                        </div>
                        <div class="col-6" style="padding-left: 15%;">
                          <img src="icon/visa.png" class="my-image" style="width: 20%;">
                          <img src="icon/mastercard.png" class="my-image" style="width: 20%;">
                          <img src="icon/american2.png" class="my-image" style="width: 20%;">
                          <img src="icon/jcb4.png" class="my-image" style="width: 20%;">
                        </div>
                      </div>
                    </button>
                  </h2>
                  <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample" style="border: 1px solid #ccc;">
                    <div class="accordion-body">
                      <div class="container text">
                        <div class="row justify-content-start">
                          <div class="col-6">
                            <label>
                              <p>Card holder name <span class="asterisk" style="color:red">*</span></p>
                            </label>
                            <input type="text" class="form-control" name="name" required>
                          </div>
                          <div class="col-6">
                            <label>
                              <p>Credit/ Debit card number <span class="asterisk" style="color:red">*</span></p>
                            </label>
                            <input type="text" class="form-control" name="name" required>
                          </div>
                        </div>
                      </div>
                      <div class="container text">
                        <div class="row justify-content-start">
                          <div class="col-6">
                            <label>
                              <p>Expiry date <span class="asterisk" style="color:red;">*</span></p>
                            </label>
                            <input type="text" class="form-control" name="name" required style="width:70%">
                          </div>
                          <div class="col-6">
                            <label>
                              <p>CVC/ CVV <span class="asterisk" style="color:red">*</span></p>
                            </label>
                            <input type="text" class="form-control" name="name" required style="width:70%">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" style="background-color:#95c7f3; " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        <div class="row justify-content-between">
                          <div class="col-6">
                            <p>Digital Payment</p>
                          </div>
                          <div class="col-6" style="padding-left: 25%;">
                            <img src="icon/ovo.png" class="my-image" style="width:40%;">
                            <img src="icon/dana.png" class="my-image" style="width: 40%;">
                          </div>
                        </div>
                      </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body" style="border: 1px solid #ccc;">
                        <label>
                          <p>Enter your mobile number (without country code) <span class="asterisk" style="color:red">*</span></p>
                        </label>
                        <input type="text" class="form-control" name="name" required>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" style="background-color:#95c7f3;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        <div class="row justify-content-between">
                          <div class="col-6">
                            <p>Bank Transfer</p>
                          </div>
                          <div class="col-6" style="padding-left: 15%;">
                            <img src="icon/bca.png" class="my-image" style="width: 20%;">
                            <img src="icon/mandiri.png" class="my-image" style="width: 20%;">
                            <img src="icon/bri.png" class="my-image" style="width: 20%;">
                            <img src="icon/bni.png" class="my-image" style="width: 20%;">
                          </div>
                        </div>
                      </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body " style="border: 1px solid #ccc;">
                        <select class="form-select" aria-label="Default select example" style="font-size: 13px;">
                          <option value="bca" data-image="icon/bca.png" selected>BCA</option>
                          <option value="mandiri" data-image="icon/mandiri.png">Mandiri</option>
                          <option value="bri" data-image="icon/bri.png">BRI</option>
                          <option value="bni" data-image="icon/bni.png">BNI</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <p style="padding-top: 5vh;">By proceeding with this booking, I agree to SOA’s Terms of Use and Privacy Policy.</p>
                <div class="col text-end"> <!-- text-end class aligns content to the right -->
                  <button type="button" style="margin-top: 1vh; margin-right:0.5vh" class="btn btn-primary"><i class="fas fa-lock" style="margin-right:8px"></i>BOOK NOW!</button>
                </div>
            </section>
          </div>
        </div>
      </div>
    </div>


</body>

</html>