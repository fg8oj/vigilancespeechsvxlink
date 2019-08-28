#!/usr/bin/php
<?php
require_once('/home/radioamateur/www/voicerss_tts.php'); 
$vigilance=file_get_contents('/home/radioamateur/vigilance.txt');
$url='https://www.alerte.mq/api/v1/zones/2/last_vigilance';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_COOKIESESSION, true);
$return = curl_exec($curl);
curl_close($curl);
$js=json_decode($return);
if ($return<>$vigilance) {
    file_put_contents('/home/radioamateur/vigilance.txt',$return);
    if ($js->niveau_id>1) {
        $message='Vigilance : '.$js->niveau->nom.'. '.$js->niveau->message.'. '.$js->niveau->consigne.'. ';

        $api='XXXXXXXXXXXXXXXX';
        $tts = new VoiceRSS;
        $voice = $tts->speech([
        'key' => $api,
        'hl' => 'fr-FR',
        'src' => $message,
        'r' => '-1',
        'c' => 'mp3',
        'f' => '16khz_16bit_mono',
        'ssml' => 'false',
        'b64' => 'false'
        ]);
        
        file_put_contents('/home/radioamateur/vigilance.mp3',$voice['response']);
    } else {
        copy('/home/radioamateur/silence.mp3','/home/radioamateur/vigilance.mp3');
    }
    $annonce=file_get_contents('/home/radioamateur/annoncelocale.txt');
    $update=false;
    if (strlen(trim($annonce))>0) {
        $update=true;
    } else {
        if ($js->niveau_id<=1) {
            unlink('/home/radioamateur/annoncelocale.wav');
        } else {
            $update=true;
        }
    }
    if ( $update==true) {
echo 'update';
        exec('sox /home/radioamateur/silence.mp3  /home/radioamateur/rcguadeloupe.mp3 /home/radioamateur/vigilance.mp3 /home/radioamateur/silence.mp3  /home/radioamateur/annoncelocale.mp3  /home/radioamateur/73.mp3  -r 16000 -b 16 /home/radioamateur/annoncelocale.wav',$o);
    }
    
    

}


?>
