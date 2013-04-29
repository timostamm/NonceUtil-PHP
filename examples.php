<?php


ini_set('default_mimetype', 'text/plain');
ini_set('default_charset', 'ISO-8859-1');
define('NONCE_SECRET', 'jvTGophIQ108Pqw9Hej');


require_once('NonceUtil.php');

print "generating a nonce with a 1 second lifetime.\n";
$nonce = NonceUtil::generate(NONCE_SECRET, 1);

print "check nonce (nonce should be valid): ";
$r = NonceUtil::check(NONCE_SECRET, $nonce);
var_dump($r);

print "\n";

print "generating a nonce with a 1 second lifetime.\n";
$nonce = NonceUtil::generate(NONCE_SECRET, 1);

print "wait 2 seconds.\n";
sleep(2);

print "check nonce (nonce should be invalid): ";
$r = NonceUtil::check(NONCE_SECRET, $nonce);
var_dump($r);


?>