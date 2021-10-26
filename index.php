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

if(empty($_GET) || $_GET['food'] == '1'){
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
   
}else{
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
    
}

//clean
function cleanInput($data){
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

$email = $street = $streetnumber = $city = $zipcode = '';
$errors = array('email'=>'', 'street'=>'', 'streetnumber'=>'', 'city'=>'', 'zipcode'=>'', 'products'=>'');

//validation
function dataValidation(){
    global $email, $street, $streetnumber, $city, $zipcode, $errors, $products, $selectedProcucts;
    //validate email
    if(empty($_POST['email'])){
        $errors['email'] = 'Please enter your email! ';
    }else {
        $email = cleanInput($_POST['email']);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Email must be a valid email address';
        }else{
            $_SESSION['email'] = $email;
        }
        
    }

    //validate street
    if(empty($_POST['street'])){
        $errors['street'] = 'Please enter your street!';
    }else {
        $street = cleanInput($_POST['street']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $street)){
            $errors['street'] = 'Street must be letters and spaces only';
        }else{
            $_SESSION['street'] = $street;
        }
    }

    //validate streetnumber
    if(empty($_POST['streetnumber'])){
        $errors['streetnumber'] = 'Please enter your streetnumber!';
    }else {
        $streetnumber =cleanInput($_POST['streetnumber']);
        if(!is_numeric($streetnumber)){
            $errors['streetnumber'] = 'Streetnumber must be numbers only';
        }else{
            $_SESSION['streetnumber'] = $streetnumber;
        }
    }
    
    //validate city
    if(empty($_POST['city'])){
        $errors['city'] = 'Please enter your city! ';
    }else {
        $city =cleanInput($_POST['city']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $city)){
            $errors['city'] = 'City must be letters and spaces only';
        }else{
            $_SESSION['city'] = $city;
        }
    }

    //validate zipcode
    if(empty($_POST['zipcode'])){
        $errors['zipcode'] = 'Please enter your zipcode!';
    }else {
        $zipcode =cleanInput($_POST['zipcode']);
        $_SESSION['zipcode'] = $zipcode;
        if(!is_numeric($zipcode)){
            $errors['zipcode'] = 'Zipcode must be numbers only';
        }
    }

    //validate products
    if(empty($_POST['products'])){
        $errors['products'] = 'Please select at least one product! ';
    }else{
        foreach($products as $i => $orderedProduct){
            $selectedProcucts[$products[$i]['name']] = $orderedProduct;
            $_SESSION['selectedProcucts'] = $selectedProcucts;
        }
    }

    //validate form
    if(array_filter($errors)){
        echo 'not ok';
    }else{
        echo 'form is ok';
    }
}

if(isset($_POST['submit'])){
    dataValidation();
};
if(isset($_POST['total'])){
    dataValidation();
};

function calculationOfDelivery(){
    $deliveryHour = new DateTime();
    if(isset($_POST['express_delivery'])){
        $deliveryHour->modify('+45 minute');
    }else{
        $deliveryHour->modify('+2 hours');
    }
    $deliveryHour = $deliveryHour->format('Y-m-d H:i:s');
    return $deliveryHour;
}

    

    

$totalValue = 0;

require 'form-view.php';

?>