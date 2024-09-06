<?php
include "./datacontext.php";


$add_submitted = isset($_POST["add"]);
if ($add_submitted) {
    # Input Validation and Sanitization
    AddProduct($_POST["ProductName"], $_POST["ProductDesc"]);
}
Show();
?>



<form action="" method="POST">
    <input type="text" name="ProductName">
    <input type="text" name="ProductDesc">
    <button name="add">add</button>
</form>




<button onclick="login()">Login</button>
<script src="./js/main.js"></script>
