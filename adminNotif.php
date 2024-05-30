<!doctype html>


<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Import jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel='icon' href='images/logo.png' type='images/logo.png'>
    <title>Admin Notification</title>

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
        <h1 class="my-4">Admin Notification Management</h1>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#notificationModal" onclick="clearForm()">
            Add Notification
        </button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Type</th>
                    <th>Start Timestamp</th>
                    <!-- <th>End Timestamp</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="notificationTableBody">
                <td>Contoh1</td>
                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, sunt. Fugiat, delectus! Accusantium tempore itaque consequuntur illo magni sed modi harum exercitationem perspiciatis debitis ad, amet nam, aut molestiae laborum.</td>
                <td>Promosi</td>
                <td>2024/05/24</td>
                <!-- <td>2024/05/29</td> -->
                <td>
                    <button type="button" class="btn btn-warning btn-sm me-2"><a href="editNotif.php">Edit</a></button>
                    <button type="button" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="notificationForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModalLabel">Add Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="notificationId">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter notification title">
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="4" placeholder="Enter notification content"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="promosi">Promosi</option>
                                <option value="pembayaran">Pembayaran</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="start-timestamp" class="form-label">Start Timestamp</label>
                            <input type="datetime-local" class="form-control" id="start-timestamp" name="start-timestamp">
                        </div> -->
                        <div class="mb-3">
                            <label for="announce-timestamp" class="form-label">Announce Timestamp</label>
                            <input type="datetime-local" class="form-control" id="announce-timestamp" name="announce-timestamp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>