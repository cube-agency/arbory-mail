<?php

namespace CubeAgency\ArboryMail\Repositories;

use CubeAgency\ArboryMail\Mail\Mail;
use Illuminate\Support\Collection;
use Intervention\Image\Exception\NotFoundException;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class MailRepository
{
    /**
     * @var Collection
     */
    protected $templates;

    /**
     * MailRepository constructor
     */
    public function __construct()
    {
        $this->templates = new Collection();
        $this->loadFromConfig();
    }

    /**
     * @return void
     */
    private function loadFromConfig()
    {
        $defined = config('arbory-mail.templates');

        foreach ($defined as $template) {
            if (class_exists($template)) {
                $mail = Mail::query()->firstOrCreate(['type' => $template]);
                $this->templates->push($mail);
            }
        }
    }

    /**
     * @param string $templateName
     * @return mixed
     * @throws \Exception
     */
    public function getTemplate(string $templateName)
    {
        $template = $this->templates->where('type', $templateName)->first();
        if (empty($template)) {
            throw new \Exception('Could not load translatable mail for ' . static::class );
        }

        return $template;
    }
}