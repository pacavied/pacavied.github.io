<?php
session_start();
if(isset($_POST['email'])) {
 
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
 
    $email_to = "articulospsiquiatricos@vtr.net";
 
    $email_subject = "Contacto desde Sitio Web";
 
 
    function died($error) {
        
        header("Location: contacto.php"); 
 
        // your error code can go here
 
        $_SESSION['message'] = "Lo sentimos, pero al parecer hay errores en el formulario: <br>";
 
        $_SESSION['message'] .=  $error."<br>";
 
        $_SESSION['message'] .=  "Por favor vuelve a intentarlo.";
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['nombre']) ||

        !isset($_POST['email']) ||
 
        !isset($_POST['telefono']) ||

        !isset($_POST['ciudad']) ||

        !isset($_POST['mensaje'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
     
 
    $first_name = $_POST['nombre']; // required
 
    $email_from = $_POST['email']; // required
 
    $telephone = $_POST['telefono']; // required
 
    $city = $_POST['ciudad']; // not required
 
    $comments = $_POST['mensaje']; // required
 
     
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'El email ingresado no es válido. <br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
 
    $error_message .= 'El nombre ingresado no es válido. <br />';
 
  }
 
  if(strlen($comments) < 2) {
 
    $error_message .= 'El mensaje ingresado no es válido.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Detalle del mensaje a continuación.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Nombre: ".clean_string($first_name)."\n";
 
    $email_message .= "Ciudad: ".clean_string($city)."\n";
 
    $email_message .= "Telefono: ".clean_string($telephone)."\n";
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "Mensaje: ".clean_string($comments)."\n";
 
     
 
     
 
// create email headers
 
$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
@mail($email_to, $email_subject, $email_message, $headers);
//session_start();
$_SESSION['message'] = 'Mensaje enviado. Nos pondremos en contacto con ud. a la brevedad.';
header("Location: contacto.php"); 
 
}
 
?>