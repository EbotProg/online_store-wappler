<?php

namespace modules;

use \lib\core\FileSystem;
use \lib\core\Module;
use \lib\core\Scope;
use \lib\core\Path;

use \PHPMailer\PHPMailer\PHPMailer;

class mail extends Module
{
    public function setup($options, $name) {
        option_default($options, 'server', 'smtp');
        option_default($options, 'host', 'localhost');
		option_default($options, 'port', 25);
		option_default($options, 'useSSL', FALSE);
		option_default($options, 'username', '');
		option_default($options, 'password', '');

        $options = $this->app->parseObject($options);
        
        $this->app->mail[$name] = $options;

        return $options;
    }

    public function send($options) {
        option_require($options, 'instance');
		option_require($options, 'subject');
		option_require($options, 'fromEmail');
		option_default($options, 'fromName', '');
		option_require($options, 'toEmail');
		option_default($options, 'toName', '');
		option_default($options, 'replyTo', '');
		option_default($options, 'cc', '');
		option_default($options, 'bcc', '');
		option_default($options, 'source', 'static'); // static/file
		option_default($options, 'contentType', 'text'); // text/html
		option_default($options, 'body', '');
        option_default($options, 'bodyFile', '');
		option_default($options, 'embedImages', FALSE);
		option_default($options, 'importance', 1); // 0 low, 1 normal, 2 high
		option_default($options, 'attachments', NULL); // '/file.ext' / ['/file.ext'] / {path:'/file.ext'} / [{path:'/file.ext'}]
        option_default($options, 'baseUrl', '/');

        $options = $this->app->parseObject($options);
        $setup = $this->getSetup($options->instance);

        $mail = new PHPMailer(true);

        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->Host = $setup->host;
        $mail->Port = $setup->port;

        if ($setup->server == 'smtp') {
            $mail->isSMTP();
            
            if ($setup->useSSL) {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            }
            
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            if ($setup->username != '') {
                $mail->SMTPAuth = true;
                $mail->Username = $setup->username;
                $mail->Password = $setup->password;
            }
        } else {
            //$mail->isSendmail();
            $mail->isMail();
        }

        $mail->setFrom($options->fromEmail, $options->fromName);

        $mail->addAddress($options->toEmail, $options->toName);

        if ($options->replyTo != '') {
            $mail->addReplyTo($options->replyTo);
        }

        if ($options->cc != '') {
            foreach (PHPMailer::parseAddresses($options->cc) as $email) {
                $mail->addCC($email['address'], $email['name']);
            }
        }

        if ($options->bcc != '') {
            foreach (PHPMailer::parseAddresses($options->bcc) as $email) {
                $mail->addBCC($email['address'], $email['name']);
            }
        }

        $mail->Subject = $options->subject;

        if ($options->source == 'file') {
            $options->bodyFile = Path::toSystemPath($options->bodyFile);
            $options->baseUrl = Path::toSiteUrl(dirname($options->bodyFile)) . '/';
            $options->body = $this->loadTemplate($options->bodyFile);
        }

        if ($options->contentType == 'html') {
            $mail->msgHTML($options->body, $options->baseUrl);
        } else {
            $mail->Body = $options->body;
        }

        if ($options->attachments) {
            $options->attachments = Path::getFilesArray($options->attachments);

            foreach ($options->attachments as $attachment) {
                $mail->addAttachment($attachment);
            }
        }

        switch ($options->importance) {
            case 0:
                $mail->Priority = 5;
            break;
            case 2:
                $mail->Priority = 1;
            break;
        }

        return $mail->send();
    }

    private function getSetup($name) {
        if (isset($this->app->mail[$name])) {
            return $this->app->mail[$name];
        }

        $path = realpath($this->app->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules/Mailer/' . $name . '.php'));
		if (FileSystem::exists($path)) {
            require(FileSystem::encode($path));
            $data = json_decode($exports);
            return $this->setup($data->options, $name);
		}
		
		throw new \Exception('Mailer "' . $name . '" not found.');
    }

    private function loadTemplate($path) {
        return $this->app->parseObject(file_get_contents($path));
    }
}
