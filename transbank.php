<?php



session_start();
require_once('v2/init.php');

use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;
use Transbank\Webpay\RedirectorHelper;



$configuration = new Configuration();
$configuration->setEnvironment("PRODUCCION");
$configuration->setCommerceCode(597034239134);

$configuration->setPrivateKey(
    "-----BEGIN RSA PRIVATE KEY-----\n" .
"MIIEowIBAAKCAQEAwqrBwmp/CH474AcY4/Dyv5TfUdpWE1xnOzGbYjn6TairUoe4\n" .
"4CkIJAfmBtPu0CJnmXOjJNFLs7BXNp3vGJJYbfjXvMrsVO1fP2UoNmOGBIRKZcgZ\n" .
"7DzlnprOTtlt4f9+Isp9f+ZLUWFN6oEmrV/8/OYGGtIB1MyaarKP/79Pbuxc3vCZ\n" .
"fNyVXDDL1lRG/UHq7z/3mEd2Pahieo7R/Cn541BFsrZi21qbgAQAnqX22KyXDGjF\n" .
"nWJp7ab2TcJU8f5YmdcffU3TlOKo4W6dnicdfuAfQyb9bRY3ZQS3oicI3niGi7tt\n" .
"XKNsCRM3N5RoOZN3yKxK15F3EU8YBstARKpKBwIDAQABAoIBAHWVcwgeD7FvnncJ\n" .
"km1MwzQZlnL4sPls3SYSJstEPf7enO1y8abk4ffxlW4WYa/yuCUmhirdCR72qxdg\n" .
"emWbMDLtFlMBN5Ns9hVy4sFHiFH+HnowTgg2GHSfCXLzPr4991DIgtnYnzH+1nOJ\n" .
"o3Uh/8w6nQFiTJzfIX7FcNmIE1DqAqkzTjYM0iCAULR2waN131gOrFGSanajQClf\n" .
"18UZwuaXDFSbWGyJObQCh2gCy4pDU2rHCinppdFHRKoC1lA+3g0adWg7X/Knf0tz\n" .
"DkV5n3+aALTQIS4sjl9oyNEtgvscwXGkoML8kW6DzLYGdLQn3ephmwPiMlaOcoxA\n" .
"oHOGixECgYEA54ybK5CeEBxNkpZbeeQ01xO6jEPC7Ib9zFmWSKRnSy3/xqL+lzjq\n" .
"zgdWmLP2wAkPjRzJ01dKz2hM8gEe7abinNlwEI7k6ilRBpU1AtFrLg0cxf0sVUOj\n" .
"XYdWIEz6LF5YklOEKEkQVNnnJtwcybIpbB8qO62pD5JHjeg0Tg4vf8sCgYEA1zkg\n" .
"NdiDblXLcYHVqMCWK9z7irTETTpcXsSO7+BbqglvxwPE51pBTcfA5qpFwRfRTn9t\n" .
"+QGVLiRd0dlZWuIABvMCbfcBen/JwRzvwQ3/xGR/BGIUOihMmiDJ0MJi/RBdcB+a\n" .
"L3dqWJ9kLQ8FRCf1aFGZgyHNqyX81glox9cp3zUCgYEA45BbnBg4UAsQ7gUZiBUR\n" .
"HWPFTj72XnFZE7HkMiZpYgimPPlKDyMgGTY7FD6iPh9pij0F2dALtQWDwb/6PoRq\n" .
"aM6GBa/6KGxMtpSDke5xUMQQSEFGhdHAx5XPvlUI9fwPPlgYJWORSmMRey6OmGeh\n" .
"sCJ85kQJSEVyT3Qrm57zbbsCgYByNsukJ5lgBUGoo+kZ29IVxvjqXBHMlgsM86yT\n" .
"GfIrI0ThTVvCFsCPIVF6V6Qa26Pkz3Ux7qgXS49KXNixhTvUdEO2zZ1IP+Z2h/+n\n" .
"6ODxfQ926QGo91fndz0CfxX/DB858FtnkyypiTSlQNJfoAD48kzQLTEzAT7S6z1i\n" .
"yAldfQKBgAQhzOf6a3HA8kjyfMc4d0+MD2V8e0gwwynhw6bd5qYnc0pruIcHpQwJ\n" .
"yUbQ44hmmguxmrR686d21jx7Uay4iWaucZmBiaCrOkprSPs42lMD5N8qPMvkU+u4\n" .
"daW/08GTW0NwyT0VBoVUZW5isEOLQAXs1rsJxqAzHx0yfWgP18gQ\n" .
"-----END RSA PRIVATE KEY-----\n");

$configuration->setPublicCert(
    "-----BEGIN CERTIFICATE-----\n" .
"MIICqjCCAZICCQDwk5f1GKQpXzANBgkqhkiG9w0BAQUFADAXMRUwEwYDVQQDDAw1\n" .
"OTcwMzQyMzkxMzQwHhcNMTgxMjI0MTUwNjEwWhcNMjIxMjIzMTUwNjEwWjAXMRUw\n" .
"EwYDVQQDDAw1OTcwMzQyMzkxMzQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEK\n" .
"AoIBAQDCqsHCan8IfjvgBxjj8PK/lN9R2lYTXGc7MZtiOfpNqKtSh7jgKQgkB+YG\n" .
"0+7QImeZc6Mk0UuzsFc2ne8Yklht+Ne8yuxU7V8/ZSg2Y4YEhEplyBnsPOWems5O\n" .
"2W3h/34iyn1/5ktRYU3qgSatX/z85gYa0gHUzJpqso//v09u7Fze8Jl83JVcMMvW\n" .
"VEb9QervP/eYR3Y9qGJ6jtH8KfnjUEWytmLbWpuABACepfbYrJcMaMWdYmntpvZN\n" .
"wlTx/liZ1x99TdOU4qjhbp2eJx1+4B9DJv1tFjdlBLeiJwjeeIaLu21co2wJEzc3\n" .
"lGg5k3fIrErXkXcRTxgGy0BEqkoHAgMBAAEwDQYJKoZIhvcNAQEFBQADggEBAAxY\n" .
"Fib3Jh85ERXGkxDp1L8rLDvImgXpdvdy1zhjIMHrn8eLKCVtqkZIcXRMzxOBUxo9\n" .
"y6xzX9Lf+ofupARpXKFNCjpgmhE/scbAtBKeMoBI/vyrVZzsYDWYzHrVtFqcYY79\n" .
"GZo0/oXDdu/tVOa6pzlfZjvJlrchJLrf7Oz0cOF/fyEx1RXxkSgOXRfbE5Ro9nur\n" .
"4yFJCwAJabwbVf9F7/BoT16Rg5rocJH8poZOdwvOIEBvRle3XCTRVy8ajByIupAh\n" .
"kGKtLzTp6H89XWO498co7I19IuWCunqKi3TtvxrQX8IxK+2fNz1FLmWz/tmXpHlt\n" .
"TmxG1t5/CUX5u7KHMII=\n" .
"-----END CERTIFICATE----\n");

$configuration->setWebpayCert(Webpay::defaultCert());  
$transaction = (new Webpay($configuration))->getNormalTransaction();
             
$amount = 1000;
$sessionId = "mi-id-de-sesion";
$buyOrder = strval(rand(100000, 999999999));
$amount = $_GET['amount'];
$buy_order = $_GET['buy_order'];




$initResult = $transaction->initTransaction($_GET['amount'], $_GET['buy_order'],$sessionId,
'https://api.timetravellers.net/transbank/response.php', 'https://api.timetravellers.net/transbank/finish.php');
       
print_r ($initResult);
//print_r ($transaction);
$formAction = $initResult->url;
$tokenWs = $initResult->token;
//$_SESSION['amount'] = $amount;
//$_SESSION['buy_order'] = $buy_order;
//$_SESSION['token'] = $tokenWs;


//echo RedirectorHelper::redirectHTML($formAction, $tokenWs);
