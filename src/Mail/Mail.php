<?php

namespace CubeAgency\ArboryMail\Mail;

use Arbory\Base\Support\Translate\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * CubeAgency\ArboryMail\Mail\Mail
 *
 * @property int $id
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\CubeAgency\ArboryMail\Mail\MailTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\CubeAgency\ArboryMail\Mail\Mail withTranslation()
 * @mixin \Eloquent
 */
class Mail extends Model
{
    use Translatable;

    /**
     * @var string
     */
    protected $table = 'arbory_mail';

    /**
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    /**
     * @var array
     */
    protected $translatedAttributes = [
        'subject',
        'text'
    ];

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) class_basename($this->type);
    }
}