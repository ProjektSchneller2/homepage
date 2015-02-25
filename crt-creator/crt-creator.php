<?php
//Intermediate:
//$dir.'/ca.csr= der Ort der CSR
$command = "/usr/bin/openssl ca -config 'rootCA/openssl.cnf' -days ".$days." -notext -batch -in ".$dir.'/ca.csr' -extensionsv3_ca -out intermediate.crt;
$output = shell_exec($command);

//WC:
//$dir.'/ca.csr= der Ort der CSR für WC
// signieren wir WCs mit intermediate oder mit der rootCA??
$command = "/usr/bin/openssl ca -config ' intermediate /openssl.cnf' -days ".$days." -notext -batch -in ".$dir.'/ca.csr' -out WC.crt;
$output = shell_exec($command);
