<?php

if ($_SERVER["REQUEST_METHOD"] != "POST")
{
    $email = $_SERVER['email'];
    $credencial = $_SERVER['credencial'];
    $contrasena = $_SERVER['contrasena'];
    $matricula = $_SERVER['matricula'];

    if($email === NULL || $credencial === NULL || $contrasena === NULL || $matricula === NULL)
    {
        print("Hay campos vacíos");
        sleep(2);
        header("location: signup.html");
    }
    else
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            print("email no válido");
            sleep(2);
            header("location: signup.html");
        }
        $long_contr = length($contrasena);
        if($long_contr < 5)
        {
            print("es muy corta!");
            sleep(2);
            header("location: signup.html");
        }
        if($credencial < 9 || $credencial > 9)
        {
            print("credencial inválido");
            sleep(2);
            header("location: signup.html");
        }
    }

}