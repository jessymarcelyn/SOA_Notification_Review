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
  <link rel="stylesheet" href="css/inputPin.css">

</head>

<body>
  <div class="container-fluid full-screen">
    <div class="row">
      <div class="content ">
        <!-- <p>Total</p> -->
        <!-- <h2>Total Rp 50000</h2> -->
        <h1>Enter PIN</h1>
        <p>Please enter your pin to continue</p>
        <div id="pinInputs">
          <input type="password" class="pin-box" maxlength="1" readonly>
          <input type="password" class="pin-box" maxlength="1" readonly>
          <input type="password" class="pin-box" maxlength="1" readonly>
          <input type="password" class="pin-box" maxlength="1" readonly>
          <input type="password" class="pin-box" maxlength="1" readonly>
          <input type="password" class="pin-box" maxlength="1" readonly>
        </div>
        <div class="d-flex justify-content-center mt-3">
          <button id="submitPin" class="btn btn-primary kirim" disabled>Kirim</button>
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
</body>

</html>



<script>
  window.addEventListener('DOMContentLoaded', () => {
    const keyboard = document.querySelector('.keyboard');
    const content = document.querySelector('.content');

    function adjustContentPosition() {
        const keyboardHeight = keyboard.offsetHeight;
        content.style.marginBottom = keyboardHeight + 'px';
    }

    adjustContentPosition();

    window.addEventListener('resize', adjustContentPosition);
});


  document.addEventListener('DOMContentLoaded', () => {
  const pinInputs = document.querySelectorAll('.pin-box');
  const keys = document.querySelectorAll('.key');
  const submitPinButton = document.getElementById('submitPin');
  const submitOkButton = document.getElementById('submitOk');

  let currentInputIndex = 0;

  const handleInput = (keyValue) => {
    if (keyValue === 'clear') {
      pinInputs.forEach(input => input.value = '');
      currentInputIndex = 0;
    } else if (keyValue === 'backspace') {
      if (currentInputIndex > 0) {
        pinInputs[currentInputIndex - 1].value = '';
        currentInputIndex--;
      }
    } else {
      if (currentInputIndex < pinInputs.length && !isNaN(keyValue)) {
        pinInputs[currentInputIndex].value = keyValue;
        currentInputIndex++;
      }
    }
    checkIfAllFieldsAreFilled();
  };

  const checkIfAllFieldsAreFilled = () => {
    const allFilled = [...pinInputs].every(input => input.value !== '');
    submitPinButton.disabled = !allFilled;
    submitOkButton.disabled = !allFilled;

  };

  const getPinValue = () => {
    let pin = '';
    pinInputs.forEach(input => {
      pin += input.value;
    });
    return pin;
  };

  const submitPin = () => {
    const pin = getPinValue();
    console.log('PIN:', pin); // Handle PIN value here as needed (e.g., send it to the server)
    pinInputs.forEach(input => input.value = '');
    currentInputIndex = 0;
    checkIfAllFieldsAreFilled();
  };

  keys.forEach(key => {
    key.addEventListener('click', () => {
      const keyValue = key.dataset.key;
      if (keyValue === 'submit') {
        submitPin();
      } else {
        handleInput(keyValue);
      }
    });
  });

  document.addEventListener('keydown', (event) => {
    const key = event.key;
    if (key >= '0' && key <= '9') {
      handleInput(key);
    } else if (key === 'Backspace') {
      handleInput('backspace');
    } else if (key === 'Delete') {
      handleInput('clear');
    } else if (key === 'Enter') {
      submitPin();
    }
  });

  submitPinButton.addEventListener('click', submitPin);
});

</script>