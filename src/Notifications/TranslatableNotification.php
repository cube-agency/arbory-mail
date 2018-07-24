<?php

namespace CubeAgency\ArboryMail\Notifications;

use CubeAgency\ArboryMail\Mail\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

abstract class TranslatableNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    protected static $placeholders = [];

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @var string
     */
    public $view = 'arbory-mail::plain';

    /**
     * @return Mail|\Illuminate\Database\Eloquent\Model|null|object|static
     */
    protected function getTranslationResource()
    {
        if (empty($this->mail)) {
            $this->mail = Mail::query()
                ->where('type', static::class)
                ->first();

            $this->mail->setDefaultLocale($this->getLocale());
        }

        return $this->mail;
    }

    /**
     * Override with needed locale, if default model
     * translation locale is not correct
     *
     * @return bool
     */
    protected function getLocale()
    {
        return app()->getLocale();
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getTranslatedSubject()
    {
        return $this->replacePlaceholders($this->getTranslationResource()->subject);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getTranslatedText()
    {
        return $this->replacePlaceholders($this->getTranslationResource()->text);
    }

    /**
     * Replaces variable placeholders
     * with real values
     *
     * @param string $data
     * @return string
     */
    protected function replacePlaceholders(string $data)
    {
        foreach ($this->values as $placeholder => $value) {
            $data = str_replace(':' . $placeholder, $value, $data);
        }
        return $data;
    }

    /**
     * @param string $key
     * @param string $value
     */
    protected function setValue(string $key, string $value)
    {
        if (!in_array($key, static::$placeholders)) return;
        $this->values[$key] = $value;
    }

    /**
     * @return array
     */
    public static function getPlaceholders()
    {
        return static::$placeholders;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        return $this->view($this->view, [
                'html' => $this->getTranslatedText()
            ])->subject($this->getTranslatedSubject());
    }
}