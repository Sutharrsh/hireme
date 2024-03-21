<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->

    <style>
        /* Your existing CSS styles */
        .container {
            max-width: 400px;
            margin: auto;
            background: #142d4c;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 8px;
            font-family: sans-serif;
            color: #ececec;
            box-shadow: 13px 13px 0px -2px #ccd1dddd;
            padding: 2rem;
        }
        #forgotPasswordLink{
            color:#9fd3c7;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="index.php?action=admin-lock" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                
            </div>
            <button type="submit" class="btn mt-2">Login</button>
        </form>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="?action=reset-password">
                        <div class="form-group">
                            <label>Email Address:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Popper.js included) -->
</body>

</html>