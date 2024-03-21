<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
  
        /* Optional: Add custom styles here */
        .container {
            max-width: 400px;
            margin: auto;
            /* padding-top: 50px; */
            background: #142d4c; 
            /* margin-top: 50px; */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 8px;
            font-family: sans-serif;
            color: #ececec;
            padding: 2rem;

    box-shadow: 13px 13px 0px -2px #ccd1dddd;
        }
       

</style>
</head>

<body>

    <div class="container">
        <form action="index.php?action=process_registration" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="user">User</option>
                    <option value="employer">Employer</option>
                </select>
            </div>
            <button type="submit" class="btn mt-2">Register</button>
        </form>
        
    </div>
    
</body>

</html>
