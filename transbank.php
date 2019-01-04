<?php



session_start();
require_once('v2/init.php');

use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;
use Transbank\Webpay\RedirectorHelper;

$privateKey = '-----BEGIN RSA PRIVATE KEY-----' . "\n" .
'MIIEpQIBAAKCAQEA9DsE0pXP/4Z61a3nLQatWNjPnQZxS4e1eG5zkCLa7QI95xmL' . "\n" .
'gG0jEuJHommGqWWwvVnh0Bo0yE1EbLyIGT2b5lBLqYapFqv+SFhoiUVZZzHy1O3h' . "\n" .
'gyTolHOHTvYEBaJ0NEvIbpcUNj3c6EUockFcd+obkhDWNBFfwUcpdly5A5mIlesy' . "\n" .
'Mgrp70l/GN6v6hcJvGdjDxUI9VZULaNl/GFuvk1moZVxrnzuA/KSIJQhwJh9FB4r' . "\n" .
'k9YE0xz8aE16fonlMxwF37r9cR/K47UNf/BMVw91tZfFN1DGvpzs7JYTf80W2yA/' . "\n" .
'MUU9f7L4V3uexxFDezxgG5i216x7mWXi1msU7wIDAQABAoIBAGFLUbSCsgXdkPmm' . "\n" .
'+b1aN5x5YtvvQRsRyR1dAvScrhJVHkv+RTC4SYywUFFHMLozJKGKOQcqKXTSMzwO' . "\n" .
'Lzm+7Whm/H1gg+PgSMCRV7O3yNHveAmTao9QGMdq7rBqGVgVS625svM7hHXHV0XA' . "\n" .
'p0g8+ZVb0ffydSLw+PCKZN4eOiZQMHLkWP+XzTNsm3zM/Ym7OIkvf+IWewMd6W/F' . "\n" .
'ScPWixzjHOcxIWCArkDhuMYEwpCG31bcgJqH28hUDdLz2qpn4wTU0q1ts4vpkYB7' . "\n" .
'4EYI4jrdwKaGw2+fNLEe5YZxxgXgnI1N/NLFPOiqJwl00VA52lhpKBARhfzj4jWQ' . "\n" .
'wxnf0CECgYEA/sWpnFa0NjSty/YZUFBf16VWrZ+CnnaM3v3mdgSGroYqODlBUq+6' . "\n" .
'rgiYMXTJxnBhIAxLpbIJyVrUo5VOhBmE/F9bHWrywvx1GTzT4OygAueEbiCOAdwN' . "\n" .
'eUwYlB/EkO9nIsB5V2NNjuQhbBqSRqcnBTZaWFeUdYgJAUCyMMRsz2sCgYEA9WhZ' . "\n" .
'oR0vHp2bCyy6hntPtOP1hILEc7xlKZb7ZwjBiqXlqgL/v+ffU02F0avalri6XXv1' . "\n" .
'l6ivvBNx+rOuOnYYRWIhPcfPjaEOB1TGauFGZoBejpScyTdjbAl8PcNfcuD5FuoI' . "\n" .
'CWj9m5EG8PaMmNSKAdhwmLeRWsgR716seOX/RY0CgYEAvtrGV7bgI6dM9vkyN2cu' . "\n" .
'lTZn+4L978WxfC9KIOj9F+qr4BiMJew89bi8gngR29U9/SsY1FTOXgfsOWtVOUKA' . "\n" .
'zCqG8D+5AnbrJe/aban1qJdVLsa2exAlC9QEqZouv8CIS5FSlTNv23ZszzYMlF8N' . "\n" .
'rSrtfTaGoZE55bVYh43uUWcCgYEAoyxXLEFzay/wP2XmQDUNsoFAZnNsnGfP++9g' . "\n" .
'CgpQZhgYtQp5cuiCHamWKOvT1BPQFwitK8IF11A2oTOHzWdoi/nLkICjCNDluwor' . "\n" .
'RDW10cHZHYTDGyew+8zyxz544LGl7g5+eYNN3Xp42w+UPKpVeRSpCWJFS89r3XVd' . "\n" .
'yKVlLqECgYEAvT/B2ll1wS0V/r5GW3G2ZteoR4hSCjEXUPlpYiAX2F0IZp76DIk4' . "\n" .
'UkmnXGXq0QK/aZj4T+8r4EdtizafjVQIVMRhpJWrJN/xDVPlnmIekRrWErYfA3iZ' . "\n" .
'GVsZDNKAnfGOmeatzdRcxoNPlmnrCh8s9uABKNi2KX00000' . "\n" .
'-----END RSA PRIVATE KEY-----' . "\n";

$publicCert = '-----BEGIN CERTIFICATE-----' . "\n" .
'MIICqjCCAZICCQDbIvobCJe87DANBgkqhkiG9w0BAQUFADAXMRUwEwYDVQQDDAw1' . "\n" .
'OTcwMzQyMzkxMzQwHhcNMTkwMTAyMTIzOTMwWhcNMjMwMTAxMTIzOTMwWjAXMRUw' . "\n" .
'EwYDVQQDDAw1OTcwMzQyMzkxMzQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEK' . "\n" .
'AoIBAQD0OwTSlc//hnrVrectBq1Y2M+dBnFLh7V4bnOQItrtAj3nGYuAbSMS4kei' . "\n" .
'aYapZbC9WeHQGjTITURsvIgZPZvmUEuphqkWq/5IWGiJRVlnMfLU7eGDJOiUc4dO' . "\n" .
'9gQFonQ0S8hulxQ2PdzoRShyQVx36huSENY0EV/BRyl2XLkDmYiV6zIyCunvSX8Y' . "\n" .
'3q/qFwm8Z2MPFQj1VlQto2X8YW6+TWahlXGufO4D8pIglCHAmH0UHiuT1gTTHPxo' . "\n" .
'TXp+ieUzHAXfuv1xH8rjtQ1/8ExXD3W1l8U3UMa+nOzslhN/zRbbID8xRT1/svhX' . "\n" .
'e57HEUN7PGAbmLbXrHuZZeLWaxTvAgMBAAEwDQYJKoZIhvcNAQEFBQADggEBAFA4' . "\n" .
'PMQMcolzKrbdegmaaVhWgxLj7Nf/kmeuZHZmIcvZlHX4ZcVuT38vJ5e+ZvNCH8KT' . "\n" .
'iCJmXJwun2CJPuT46NadHQjzbgftcoOY/sZhQ2nmrVOKPxt60WZs352Ktp2mP5BX' . "\n" .
'L/Z9iLSJfQ3IdW/7mFgoNCmuImqdTuL5t+MH4dBOL4j9T/Tp7/g/K0gMmnnDeWzu' . "\n" .
'PYiuXTkvfioxwqmn6nwV+JR696FxYB6Tfbrjm1nxKy+8N7848ZQjude88yH2SV0t' . "\n" .
'RziG+ESL9KBAI7WatiOd1eKYuTzsxtmrinlno4k1miPfOPNa6D5s22ASx+E3uWdH' . "\n" .
'PbJNQhPVh/0000000' . "\n" .
'-----END CERTIFICATE-----' . "\n";



$configuration = new Configuration();
$configuration->setEnvironment("PRODUCCION");
$configuration->setCommerceCode(59703423000);
$configuration->setPrivateKey($privateKey);
$configuration->setPublicCert($publicCert);
$configuration->setWebpayCert(Webpay::defaultCert());  
$transaction = (new Webpay($configuration))->getNormalTransaction();
             
$amount = $_GET['amount'];
$buy_order = $_GET['buy_order'];



$initResult = $transaction->initTransaction($_GET['amount'], $_GET['buy_order'],
'response.php', 'finish.php');
       
//print_r ($initResult);
//print_r ($transaction);
$formAction = $initResult->url;
$tokenWs = $initResult->token;
$_SESSION['amount'] = $amount;
$_SESSION['buy_order'] = $buy_order;
$_SESSION['token'] = $tokenWs;