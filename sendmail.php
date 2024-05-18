<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require(__DIR__ . "/PHPMailer/src/Exception.php");
require(__DIR__ . "/PHPMailer/src/PHPMailer.php");

if ($_POST['invisible'] != '') {
	die('Ботам - нет!');
} else {
	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('info@tvoepererozhdenie.ru', 'tvoepererozhdenie'); // Указать нужный E-mail
	//Кому отправить
	$mail->addAddress('zayavka.loboda@gmail.com'); // Указать нужный E-mail
	$mail->addAddress('zayavka.loboda@yandex.ru');
	// $mail->addAddress('andrejprasolov@inbox.ru');
	$mail->addAddress('prasolovandreas@yandex.ru');
	// $mail->addAddress('andrejprasolov93239@gmail.com');
	//Тема письма
	$mail->Subject = 'Заявка с сайта tvoepererozhdenie.ru reason';

	$phone = trim($_POST['phone']);
	$from = trim($_POST['from']);
		$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$invisible = trim($_POST['invisible']);
	$utm_source = $_SESSION['utm_source'];
	$utm_medium = $_SESSION['utm_medium'];
	$utm_campaign = $_SESSION['utm_campaign'];
	$utm_content = $_SESSION['utm_content'];
	$utm_term = $_SESSION['utm_term'];

	

	//Тело письма
	$body = '<h1>' . $from . '</h1>';
	if (!empty($name)) {
		$body .= '<p><strong>Имя:</strong> ' . $name . '</p>';
	}
	if (!empty($phone)) {
		$body .= '<p><strong>Телефон:</strong> ' . $phone . '</p>';
	}
	if (!empty($email)) {
		$body .= '<p><strong>Email:</strong> ' . $email . '</p>';
	}
	if (!empty($utm_source)) {
		$body .= '<p><strong>utm_source:</strong> ' . $utm_source . '</p>';
	}
	if (!empty($utm_medium)) {
		$body .= '<p><strong>utm_medium:</strong> ' . $utm_medium . '</p>';
	}
	if (!empty($utm_campaign)) {
		$body .= '<p><strong>utm_campaign:</strong> ' . $utm_campaign . '</p>';
	}
	if (!empty($utm_content)) {
		$body .= '<p><strong>utm_content:</strong> ' . $utm_content . '</p>';
	}
	if (!empty($utm_term)) {
		$body .= '<p><strong>utm_term:</strong> ' . $utm_term . '</p>';
	}
}

require_once dirname(__FILE__) . "/libs/SendAmo.php";

// AmoCRM integration
$amo_msg = "Заявка с сайта tvoepererozhdenie.ru" . PHP_EOL;
if (!empty($name)) {
	$amo_msg .= 'Имя:' . $name . PHP_EOL;
}
if (!empty($phone)) {
	$amo_msg .= 'Телефон:' . $phone . PHP_EOL;
}
if (!empty($email)) {
	$amo_msg .= 'Email:' . $email . PHP_EOL;
}
if (!empty($utm_source)) {
	$amo_msg .= 'utm_source:' . $utm_source . PHP_EOL;
}
if (!empty($utm_medium)) {
	$amo_msg .= 'utm_medium:' . $utm_medium . PHP_EOL;
}
if (!empty($utm_campaign)) {
	$amo_msg .= 'utm_campaign:' . $utm_campaign . PHP_EOL;
}
if (!empty($utm_content)) {
	$amo_msg .= 'utm_content:' . $utm_content . PHP_EOL;
}
if (!empty($utm_term)) {
	$amo_msg .= 'utm_term:' . $utm_term . PHP_EOL;
}

$sendAmo = new SendAmo("", $phone, $email, $name, $amo_msg);
$sendAmo->setUTM($_SESSION["utm_source"], $_SESSION["utm_medium"], $_SESSION["utm_campaign"], $_SESSION["utm_content"], $_SESSION["utm_term"]);
$sendAmo->start();
// END AmoCRM integration




//Прикрепить файл
if (!empty($_FILES['image']['tmp_name'])) {
	//путь загрузки файла
	$filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
	//грузим файл
	if (copy($_FILES['image']['tmp_name'], $filePath)) {
		$fileAttach = $filePath;
		$body .= '<p><strong>Файл во вложении</strong>';
		$mail->addAttachment($fileAttach);
	}
}


$mail->Body = $body;

//Отправляем
if (!$mail->send()) {
	$message = 'Ошибка';
} else {
	$message = 'Данные отправлены!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
