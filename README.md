# vigilancespeechsvxlink

## Générer une clé sur l'API http://www.voicerss.org/registration.aspx

## Créer un cron pour récupérer un le niveau de vigilance
*/5 * * * * /home/radioamateur/www/vigilance.php  > /dev/null 2> /dev/null

## Personnaliser l'api dans vigilance.php

## Ajouter un menu DTMF dans /usr/share/svxlink/events.d/Logic.tcl de  SVXLINK

  if {$cmd == "3"} {
    playMsg "default" "annoncelocale"
    return 1
  }

## Ajouter un cron pour générer l'annonce :

33 * * * * /etc/spotnik/annoncelocale.sh  > /dev/null 2> /dev/null

