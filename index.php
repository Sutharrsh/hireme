<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      
        button{
            
            background-color: #9fd3c7 !important;
            color: #142d4c !important;
        }
       
     
    </style>

</head>
<?php
/*.first-color { 
	background: #ececec; 
}
	
.second-color { 
	background: #9fd3c7; 
}

.third-color { 
	background: #385170; 
}

.fourth-color { 
	background: #142d4c; 
}*/

require 'vendor/autoload.php';

// Include PHPMailer autoloader
// require_once 'PHPMailer/src/PHPMailer.php';
// require_once 'PHPMailer/src/SMTP.php';
// require 'PHPMailer/src/Exception.php';
require_once 'db_connection.php';
require_once 'controllers/UserController.php';
require_once 'models/UserModel.php';
require_once 'models/JobModel.php';
require_once 'models/JobApplicationModel.php';
require_once 'services.php';
require_once 'elements/Header.php';
require_once 'action.php';
?>
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>


</html>

