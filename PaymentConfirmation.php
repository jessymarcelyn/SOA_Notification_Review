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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel='icon' href='images/logo.png' type='images/logo.png'>
    <title>Booking.com | Payment Confirmation</title>

    <!-- Bootstrap CSS  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/paymentConf.css">
</head>

<body>
    <div class="container outer-container">
        <h3 style="text-align: left;">Your confirmed booking at <span style="color: #279aec;">Kayuan Lumbur Resort Ubud </span> </h3>
        <div class="row align-items-start">
            <div class="col-md-4">
                <section class="hotel">
                    <img src="image/villa.jpg" alt="Villa Image">
                    <div class="hotelInfo">
                        <p>Hotel</p>
                        <h4>The Kayuan Lumbur Resort Ubud</h4>
                        <div id="location">
                            <p>Jalan Katik Lantang, 80571</p>
                            <p>Ubud</p>
                            <p>Indonesia</p>
                        </div>
                        <hr>
                    </div>
                    <h5>Got a question?</h5>
                    <p>+62 12313212</p>
                    <p style='color:#279aec'>Email the property</p>
                    <hr>
                    <h5><i class="far fa-question-circle" style="margin-right:5px"></i>Need help?</h5>
                    <p style='color:#279aec;'>Contact customer service</p>

                </section>
            </div>
            <div class="col-md-8">
                <section class="detail">
                    <div class="container text">
                        <div class="row row1">
                            <div class="col">
                                <p><b>Booking Number</b></p>
                                <p>123123123</p>
                            </div>
                            <div class="col">
                                <p><b>Payment Method</b></p>
                                <p>Credit card</p>
                            </div>
                            <div class="col">
                                <p><b>Card number</b></p>
                                <p>12312*********</p>
                            </div>
                            <div class="col">
                                <!-- Additional details can be added here -->
                            </div>
                        </div>
                        <hr>
                        <div class="row row2">
                            <div class="col">
                                <p><b>First name</b></p>
                                <p>Tina</p>
                            </div>
                            <div class="col">
                                <p><b>Last name</b></p>
                                <p>Ani</p>
                            </div>
                            <div class="col">
                                <p><b>Phone number</b></p>
                                <p>08123131</p>
                            </div>
                            <div class="col">
                                <p><b>Email address</b></p>
                                <p>ani@gmail.com</p>
                            </div>
                            
                        </div>
                        <hr>

                    </div>
                    <div class="container text">
                        <div class="bookDetail">
                            <div class="row">
                                <div class="col">
                                    <img src="image/room.jpg" alt="Villa Image" style="width: 100%; height:80%;">
                                </div>
                                <div class="col" style="margin-top: 3vh;">
                                    <p><b>Room type</b></p>
                                    <p>Deluxe room</p>

                                </div>
                                <div class="col" style="margin-top: 3vh">
                                    <p><b>Night(s)</b></p>
                                    <p>2</p>
                                </div>
                                <div class="col" style="margin-top: 3vh">
                                    <p><b>Quantity</b></p>
                                    <p>1</p>
                                </div>
                                <div class="col" style="margin-top: 3vh">
                                    <p><b>Price</b></p>
                                    <p>Rp 3,900,000</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2" style="margin-left: 3vh;">
                                </div>
                                <div class="col-3">
                                    <p>Check-in</p>
                                    <p><b>Thu, May 23, 2024</b></p>
                                    <p style="color: gray">From 2:00 PM</p>
                                </div>
                                <div class="col-1" style="margin-left: 7vh;">

                                </div>
                                <div class="col-4">
                                    <p>Check-out</p>
                                    <p><b>Sat, May 25, 2024</b></p>
                                    <p style="color: gray">7.00 AM - 12.00 PM</p>
                                </div>
                                <div class="col">

                                </div>

                            </div>
                            <br>
                        </div>
                        <hr>
                        <div class="bookDetailRoom">
                            <div class="row">
                                <div class="col">
                                    <p><b>Subtotal</b></p>
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                    <p>Rp 3,900,000</p>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p><b>Tax (10%)</b></p>
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                    <p>Rp 390,000</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <h4><b>Total</b></h4>
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                    <h4 style="padding-top: 2vh; margin-left:-2vh;color:green">Rp 3,900,000</h4>
                                </div>
                            </div>


                            <!-- <p><b>2 nights, 1 room</b></p>
                            <h4 style="padding-top: 2vh; color:green">Rp 3,900,000</h4> -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>

</html>