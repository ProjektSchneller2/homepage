<?php

//$command = "openssl req -in C:\Vera\Programme\Openssl\openssl\intermediateTest2.csr (-noout) -text";
//$out = shell_exec($command);

//Test
$out = "bla bla bla awqgnriüvn aäkd,fomeäpüm Subject: C=DE, ST=Bayern, L=HDH, O=DHBW, fewnIFPÜÄSubject Public Key Info:rsaEncryption 2058 bit Modulus:CEJF wepfc jnpEOWMJFMCEWOPVMJÜExponent:ncvadieognaroün Signature Algorithm: sha256WithRSAEncryption";

echo "<br>";
echo "Hier die komplette CSR ungeparst:";
echo "<br>";
echo $out;
echo "<br>";
echo "<br>";


include ("CSR_read.html");

?>