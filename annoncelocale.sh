#!/bin/bash
if grep -q 0 /sys/class/gpio_sw/PA7/data; then
// wget si distance ou copy si locale.
	wget -q "https://XXXXXXXXXXXXXX/annoncelocale.php?audio=1" -O /etc/spotnik/annoncelocale.wav
	if [ -s /etc/spotnik/annoncelocale.wav ]
	 then
		echo "A" >/tmp/svxlink_dtmf_ctrl_pty
		sleep 3
		echo "3#" > /tmp/svxlink_dtmf_ctrl_pty
	fi
fi
