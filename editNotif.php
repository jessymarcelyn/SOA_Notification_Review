<!doctype html>


<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Import jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel='icon' href='images/logo.png' type='images/logo.png'>
    <title>Edit Notification</title>

    <!-- Bootstrap CSS  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/adminNotif.css">
</head>

<body>
    <div class="container outer-container">
       <h1>Edit Notification</h1>
       <form enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter notification title">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="4" placeholder="Enter notification content"></textarea>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment Image</label>
                <input type="file" class="form-control" id="attachment" name="image" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-control" id="type" name="type">
                    <option value="promosi">Promosi</option>
                    <option value="pembayaran">Pembayaran</option>
                </select>
            <!-- </div>
                <label for="start-timestamp" class="form-label">Start Timestamp</label>
                <input type="datetime-local" class="form-control" id="start-timestamp" name="start-timestamp">
            </div> -->
            <div class="mb-3">
                <label for="announce-timestamp" class="form-label">Announce Timestamp</label>
                <input type="datetime-local" class="form-control" id="announce-timestamp" name="announce-timestamp">
            </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><a href="adminNotif.php">Cancel</a></button>
                <button type="button" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>

</html>