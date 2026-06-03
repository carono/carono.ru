<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $body = '';
    public string $verifyCode = '';

    public function rules(): array
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            [['name', 'subject'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['body'], 'string', 'min' => 10],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'subject' => 'Тема',
            'body' => 'Сообщение',
        ];
    }

    public function contact(string $email): bool
    {
        if (!$this->validate()) {
            return false;
        }
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->name])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject('[carono.ru] ' . $this->subject)
            ->setTextBody("От: {$this->name} <{$this->email}>\n\n{$this->body}")
            ->send();
    }
}
