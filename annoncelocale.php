<?php
require_once('/home/radioamateur/www/voicerss_tts.php');
$admin=$_GET['admin'];
$annonce=file_get_contents('/home/radioamateur/annoncelocale.txt');
if ($admin=='XXXXXXXXXXXXXXX') {
    if ( (count($_POST)>0) &&($annonce<>$_POST['annonce'])) {
        $annonce=trim($_POST['annonce']);
        file_put_contents('/home/radioamateur/annoncelocale.txt',$annonce);
        if (strlen($_POST['annonce'])>0) {
            $api='XXXXXXXXXXXXXXXXXXXXX';
 
            $tts = new VoiceRSS;
            $voice = $tts->speech([
                'key' => $api,
                'hl' => 'fr-FR',
                'src' => $annonce,
                'r' => '-1',
                'c' => 'mp3',
                'f' => '16khz_16bit_mono',
                'ssml' => 'false',
                'b64' => 'false'
            ]);

            //print_r($voice);
            file_put_contents('/home/radioamateur/annoncelocale.mp3',$voice['response']);
            
/*
$tts = new VoiceRSS;
            $voice = $tts->speech([
                'key' => $api,
                'hl' => 'fr-FR',
                'src' => 'Annonce du Radio Club de Guadeloupe. Bonjour,',
                'r' => '-1',
                'c' => 'mp3',
                'f' => '16khz_16bit_mono',
                'ssml' => 'false',
                'b64' => 'false'
            ]);

            //print_r($voice);
            file_put_contents('/home/radioamateur/rcguadeloupe.mp3',$voice['response']);
            
            
            $tts = new VoiceRSS;
            $voice = $tts->speech([
                'key' => $api,
                'hl' => 'fr-FR',
                'src' => 'À très bientôt et 73 de toute l\'équipe F G 4 K L ! ',
                'r' => '-1',
                'c' => 'mp3',
                'f' => '16khz_16bit_mono',
                'ssml' => 'false',
                'b64' => 'false'
            ]);

            //print_r($voice);
            file_put_contents('/home/radioamateur/73.mp3',$voice['response']);
*/                        

            exec('sox /home/radioamateur/silence.mp3  /home/radioamateur/rcguadeloupe.mp3 /home/radioamateur/vigilance.mp3 /home/radioamateur/silence.mp3  /home/radioamateur/annoncelocale.mp3  /home/radioamateur/73.mp3  -r 16000 -b 16 /home/radioamateur/annoncelocale.wav',$o);
//print_r($o);

        } else {
            unlink('/home/radioamateur/annoncelocale.wav');
            copy('/home/radioamateur/silence.mp3','/home/radioamateur/annoncelocale.mp3');
            if (filesize('/home/radioamateur/vigilance.mp3')>3000) {
            exec('sox /home/radioamateur/silence.mp3  /home/radioamateur/rcguadeloupe.mp3 /home/radioamateur/vigilance.mp3 /home/radioamateur/silence.mp3 /home/radioamateur/73.mp3  -r 16000 -b 16 /home/radioamateur/annoncelocale.wav',$o);
            }
        }

    }
    
    echo '<form method="POST" action="annoncelocale.php?admin='.$admin.'"><textarea style="width:95%;height:200px;" name="annonce">'.$annonce.'</textarea><br><input style="width:95%;" type="submit" value="Enregistrer"></form>';
    
    echo '<br/><br/><a href="?audio=1">Téléchargez le fichier audio</a>';
               
} else {
    if (strlen($_GET['audio'])>0) {
        $wav=file_get_contents('/home/radioamateur/annoncelocale.wav');
        $size = strlen($wav);
        header("Content-Type: audio/wav", TRUE);
        header("Content-Disposition: ATTACHMENT; FILENAME=\"annoncelocale.wav\"", TRUE);
        header("Content-Length: " . $size);
        header("Content-Transfer-Encoding: binary");
        echo $wav;

    } else {
        echo '<a href="?audio=1">'.$annonce.'</a>';
    }
}

?>
