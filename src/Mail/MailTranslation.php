<?php

namespace CubeAgency\ArboryMail\Mail;

use Illuminate\Database\Eloquent\Model;

/**
 * CubeAgency\ArboryMail\Mail\MailTranslation
 *
 * @property int $id
 * @property int $mail_id
 * @property string|null $subject
 * @property string|null $text
 * @property string $locale
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\MailTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\MailTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\MailTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\MailTranslation whereMailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\MailTranslation whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\MailTranslation whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\MailTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MailTranslation extends Model
{
    /**
     * @var string
     */
    protected $table = 'arbory_mail_translations';

    /**
     * @var array
     */
    protected $fillable = [
        'subject',
        'text',
        'locale',
        'mail_id'
    ];
}