<?php

namespace CubeAgency\ArboryMail\Notifications;

use CubeAgency\ArboryMail\Mail\Mail;
use CubeAgency\ArboryMail\Repositories\MailRepository;
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
    public $htmlView = 'arbory-mail::html';

    /**
     * @var string
     */
    public $plainView = 'arbory-mail::plain';

    /**
     * @return Mail|\Illuminate\Database\Eloquent\Model|null|object|static
     * @throws \Exception
     */
    protected function getTranslationResource()
    {
        if (empty($this->mail)) {
            $this->mail = Mail::query()
                ->where('type', static::class)
                ->first();

            if (empty($this->mail)) {
                $this->mail = resolve(MailRepository::class)
                    ->getTemplate(static::class);
            }

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
    protected function getTranslatedHtml()
    {
        return $this->replacePlaceholders($this->getTranslationResource()->html);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getTranslatedPlain()
    {
        return $this->replacePlaceholders($this->getTranslationResource()->plain);
    }

    /**
     * Replaces variable placeholders
     * with real values
     *
     * @param string $data
     * @return string
     */
    protected function replacePlaceholders(?string $data)
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
        return $this
            ->view($this->htmlView, [
                'html' => $this->getTranslatedHtml()
            ])
            ->text($this->plainView, [
                'text' => $this->getTranslatedPlain()
            ])
            ->subject($this->getTranslatedSubject());
    }
}