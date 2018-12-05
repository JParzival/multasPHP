<?php

if (!filter_var($email_paypal, FILTER_VALIDATE_EMAIL)) 
{
    print("email no válido");
    header("location:login_paypal.html");
}

?>