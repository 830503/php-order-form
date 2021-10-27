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
}else if($_GET['food'] == '0'){
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
        ['name' => 'Club Salmon', 'price' => 5],
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

//session variable
if(!isset($_SESSION['email'])){
    $_SESSION['email'] = '';
}
if(!isset($_SESSION['street'])){
    $_SESSION['street'] = '';
}
if(!isset($_SESSION['streetnumber'])){
    $_SESSION['streetnumber'] = '';
}
if(!isset($_SESSION['city'])){
    $_SESSION['city'] = '';
}
if(!isset($_SESSION['zipcode'])){
    $_SESSION['zipcode'] = '';
}

//cookie variable
if(!isset($_COOKIE['cookieTotal'])){
    $_COOKIE['cookieTotal'] = 0;
}else{
    $totalValue = $_COOKIE['cookieTotal'];
}

//variable
$email = $street = $streetnumber = $city = $zipcode = '';
$totalValue = 0;
$errors = array('email'=>'', 'street'=>'', 'streetnumber'=>'', 'city'=>'', 'zipcode'=>'', 'products'=>'');


//validation
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        if(!is_numeric($zipcode)){
            $errors['zipcode'] = 'Zipcode must be numbers only';
        }else{
            $_SESSION['zipcode'] = $zipcode;
        }
    }

    //validate products
    if(empty($_POST['products'])){
        $errors['products'] = 'Please select at least one product! ';
    }else{
        if(isset($_POST['products'])){
            /*foreach($_POST['products'] as $i => $product){
                $totalValue += $products[$i]['price']  * $_POST['products'][$i];*/
            }
            for($i = 0; $i < count($products); $i++){
                if(isset($_POST['products'][$i])){
                    $totalValue += $products[$i]['price'];
                    setcookie("cookieTotal", strval($totalValue), time() + (86400 * 30), "/");
                }
            }
        }                    
    }
    
    //check express-delivery
    if(isset($_POST['express_delivery'])){
        $totalValue += 5;
        $deliveryHour = date("H:i", strtotime("+45 Minutes"));
    }else{
        $deliveryHour = date("H:i", strtotime("+2 Hours"));
    }

    //validate form
    if(array_filter($errors)){
        echo " <div class='alert alert-dismissible alert-danger'>     
        <h4 class='alert-heading'>OOOOOOPS! !</h4> 
        <p class='mb-0'> <strong>  Try again! </strong>
        </p> </div>";
    }else{
       $mailto = "lixiaoqi19830503@gmail.com";
       $subject = "Order from Personal Ham Processors";
       $message = $street . $streetnumber . $city . $zipcode . $totalValue;
       $header = "From: Personal Ham Processors";
       mail($mailto, $subject, $message, $header);
       if(mail($mailto, $subject, $message, $header)){
        echo " <div class='alert alert-dismissible alert-info'>     
        <h4 class='alert-heading'>Congratulations - Order Recived !</h4> 
        <p class='mb-0'> Your order has been sent and you will receive it at: <strong> $deliveryHour </strong>
        </p> </div>";
       }
    }

require 'form-view.php';

?>