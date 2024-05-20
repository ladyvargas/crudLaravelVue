<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoElectronico;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {        
        $correoElectronico = new CorreoElectronico();
        $email = 'support@rebits.cl';
        Mail::to($email)->send($correoElectronico);
        
        return response()->json(['message' => 'Correo electrónico enviado correctamente'], 200);
    }
}
