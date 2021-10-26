<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//whatIsHappening();
//your products with their price.
$food = $_GET['food'];
if($food == '0'){
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
   
}else{
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
}





$email = $street = $streetnumber = $city = $zipcode = '';
$errors = array('email'=>'', 'street'=>'', 'streetnumber'=>'', 'city'=>'', 'zipcode'=>'');

//validation
if(isset($_GET['submit'])){
    //validate email
    if(empty($_GET['email'])){
        $errors['email'] = 'Please enter your email! ';
       
    }else {
        $email = $_GET['email'];
        //$_SESSION['email'] = $email;
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Email must be a valid email address';

        }
        
    }

    //validate street
    if(empty($_GET['street'])){
        $errors['street'] = 'Please enter your street!';
    }else {
        $street = $_GET['street'];
        //$_SESSION['street'] = $street;
        if(!preg_match('/^[a-zA-Z\s]+$/', $street)){
            $errors['street'] = 'Street must be letters and spaces only';
        }
    }

    if(empty($_GET['streetnumber'])){
        $errors['streetnumber'] = 'Please enter your streetnumber!';
    }else {
        $streetnumber = $_GET['streetnumber'];
        //$_SESSION['streetnumber'] = $streetnumber;
        if(!is_numeric($streetnumber)){
            $errors['streetnumber'] = 'Streetnumber must be numbers only';
        }
    }
    
    if(empty($_GET['city'])){
        $errors['city'] = 'Please enter your city! ';
    }else {
        $city = $_GET['city'];
        //$_SESSION['city'] = $city;
        if(!preg_match('/^[a-zA-Z\s]+$/', $city)){
            $errors['city'] = 'City must be letters and spaces only';
        }
    }

    if(empty($_GET['zipcode'])){
        $errors['zipcode'] = 'Please enter your zipcode!';
    }else {
        $zipcode = $_GET['zipcode'];
        //$_SESSION['zipcode'] = $zipcode;
        if(!is_numeric($zipcode)){
            $errors['zipcode'] = 'Zipcode must be numbers only';
        }
    }
};
    

    

    

$totalValue = 0;

require 'form-view.php';

?>