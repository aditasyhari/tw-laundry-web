<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

function uploads($file, $path)
{
    $fileName   = time() . $file->getClientOriginalName();
    Storage::disk('public')->put($path . $fileName, File::get($file));
    $filePath   = 'storage/'.$path . $fileName;

    return $fileName;
}

if(!function_exists("gantiFormatNomor")){
    function gantiFormatNomor($nomorhp) {
        //Terlebih dahulu kita trim dl
        $nomorhp = trim($nomorhp);
        //bersihkan dari karakter yang tidak perlu
        $nomorhp = strip_tags($nomorhp);     
        // Berishkan dari spasi
        $nomorhp= str_replace(" ","",$nomorhp);
        // bersihkan dari bentuk seperti  (022) 66677788
        $nomorhp= str_replace("(","",$nomorhp);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $nomorhp= str_replace(".","",$nomorhp); 

        //cek apakah mengandung karakter + dan 0-9
        if(!preg_match('/[^+0-9]/',trim($nomorhp))){
            // cek apakah no hp karakter 1-3 adalah +62
            if(substr(trim($nomorhp), 0, 3)=='+62'){
                $nomorhp= '0'.substr($nomorhp, 1);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif(substr($nomorhp, 0, 1)=='0'){
                $nomorhp= trim($nomorhp);
            }
        }
        return $nomorhp;
    }
}

function checkNumberWa($number)
{
    $token = "L92mEt1pBymGE84y7KgNCfTLC6Vbe6YnWbCt8Q6dfnZ53nTZoK";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.ruangwa.id/api/check_number',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'token='.$token.'&number='.$number,
    ));

    $response = curl_exec($curl);
    $response = json_decode($response);

    curl_close($curl);
    return $response->onwhatsapp;

}

function sendwa($phone, $message)
{
    $token = "L92mEt1pBymGE84y7KgNCfTLC6Vbe6YnWbCt8Q6dfnZ53nTZoK";

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'token='.$token.'&number='.$phone.'&message='.$message,
    ));

    $response = curl_exec($curl);
    $response = json_decode($response);

    curl_close($curl);
    return $response->status;

    // {
    //     "result": "true",
    //     "id": "3EB0AD743D63",
    //     "number": "087869415384",
    //     "message": "Kirim pesan sukses!",
    //     "status": "sent"
    // }
}