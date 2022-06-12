<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\FunctionsController;
use App\Http\Controllers\UserController;
use App\Models\User;

class MailerController extends Controller {

 
    // =============== [ Email ] ===================
    public function email() {
        return view("email");
    }

    static function BodyMessage($file,$originRecivied,$data){

       switch ($originRecivied) {
           case 'New User':
                $bodyrecivied = file_get_contents($file);
                $bodyrecivied = str_replace('$fullname',$data['first_name'].' '.$data['last_name'], $bodyrecivied);
                $bodyrecivied = str_replace('$linkactiveaccount', env('APP_URL')."/api/account/activate/".self::obtainCodeActivation($data['email']), $bodyrecivied);
               
                return $bodyrecivied;
            break;
            
       }
    }


    static function obtainCodeActivation($email)
    {
       $functionGeneral = new FunctionsController();
       $userid = $functionGeneral->loadDataUserByEmail($email);

       return  $userid->code_activation;
    }

    static function SendEmail($data,$title,$body) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
    
        $mail->From = "kelvinencarnacion@ambardev.com";
        $mail->FromName = "Kelvin Encarnacion";

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.bpaauditores.com';             //  smtp host
        $mail->SMTPAuth = true;
        $mail->Username = 'kelvinencarnacion@bpaauditores.com';   //  sender username
        $mail->Password = 'kelvinencarnacion';       // sender password
        $mail->SMTPSecure = 'ssl';                  // encryption - ssl/tls
        $mail->Port = 465;                          // port - 587/465
        $mail->addAddress($data['email'], $data['first_name']);
        
        $mail->setFrom('kelvinencarnacion@bpaauditores.com', 'Dry Hi Tec');
        $mail->isHTML(true);      

        $mail->Subject = $title ." - Dry Hi Tec" ;
        $mail->MsgHTML(self::bodyMessage($body,$title,$data));
        $mail->AltBody = $title;
        $mail->send();
    }
}