<?php
<?php



session_start();
require_once('v2/init.php');

use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;
use Transbank\Webpay\RedirectorHelper;



$configuration = new Configuration();
$configuration->setEnvironment("PRODUCCION");

$configuration->setCommerceCode(597034000004);
$configuration->setPrivateKey(
"-----BEGIN RSA PRIVATE KEY-----\n" .
"MIIEpAIBAAKCAQEAu/3sEwdCTavs+FV1GUfZ+zKvEoVAJhSrkBRMAGF9tPwZ1azU\n" .
"5OwfFR+VzllZ7NikNyc7DR0EiR7bsc9W476HiuR2LSDZnK+/oLw94sQPIZNoy27z\n" .
"MH/K7AitkOAN6ltaTd6o65AC+yKqmHp0dUXfjOmkZzoZli9pcjufOnEhOcDAYM96\n" .
"cw7R61Hr/oE/2z5+KweDxT9giIlLuNWtcbdN7z3XYdjKRKH77KUVta5s2k3/16gI\n" .
"0a7jXZoI/N4U1AoN7p84cr3POstdD7BV0ngS7LV+4spYvYuyfsfNvVM0zAoubRJt\n" .
"UI2/o0h5/QlJQuRFZrPSAFncvKO5N/516EJIDQIDAQABAoIBAQC5NOK9pGsoBneB\n" .
"+P9Slr0kg7yDbI/UdIzJd5Wg0mt8QNpa7tkXZ6D/uIxoLRMxCgZO5/F/a9UqGiKr\n" .
"PPAHk5AJwCbFMxXxDhymiI4XuLyHgai+s2IXp+8NN0d38aUD/FgtW23kFY86R972\n" .
"Nb5CQ0KImy6DHHRUyAUEq8SlWQs4zwDTgv+d/xEIH+NrAm01zhJwh3WrWpa2YLhB\n" .
"7cAiSU9D9GwBbmeDXK0qmmuS4AafjaBWB7pFNdSFD20uw8/b5Lx+PJFRy7qNGmFB\n" .
"11lpb5c/V5AJLiKNn5faBN/4lJ2h0DpFwFXhI50YphkkE4ndETpMk2qg1hzsi9Sk\n" .
"5ANVb/uBAoGBAPJN+ElbC4cVA67GZZQ1NaJIPtZANe31ZAAxJaRd0EX85bZMbzRN\n" .
"uYAQazRpg/kL6Svy1BjdYcdLpbMBLGMZ3s/io/kXKsKLFjCTQ0KNYwcihiE5K/U3\n" .
"krd1fAIQntJoYoq1LewbMgmaKL9qJxJit94sKsYcKr/bdLK8vvomX/CdAoGBAMae\n" .
"1flxebwaZeMNmXXe5a7Ac9NLzKLAzhrikFqmd1P+vo1a18QmONj5ig==\n" .
"-----END RSA PRIVATE KEY-----\n");

$configuration->setPublicCert(
"-----BEGIN CERTIFICATE-----\n" .
"MIICqjCCAZICCQC9tNL7t/jyfTANBgkqhkiG9w0BAQUFADAXMRUwEwYDVQQDDAw1\n" .
"OTcwMzQyMzkxMzQwHhcNMTkwMTA0MjExMTQ4WhcNMjMwMTAzMjExMTQ4WjAXMRUw\n" .
"EwYDVQQDDAw1OTcwMzQyMzkxMzQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEK\n" .
"AoIBAQC7/ewTB0JNq+z4VXUZR9n7Mq8ShUAmFKuQFEwAYX20/BnVrNTk7B8VH5XO\n" .
"WVns2KQ3JzsNHQSJHtuxz1bjvoeK5HYtINmcr7+gvD3ixA8hk2jLbvMwf8rsCK2Q\n" .
"4A3qW1pN3qjrkAL7IqqYenR1Rd+M6aRnOhmWL2lyO586cSE5wMBgz3pzDtHrUev+\n" .
"gT/bPn4rB4PFP2CIiUu41a1xt03vPddh2MpEofvspRW1rmzaTf/XqAjRruNdmgj8\n" .
"S9dHNXQEdhkMcVJFMc4=\n" .
"-----END CERTIFICATE-----\n");


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
