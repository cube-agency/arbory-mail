<?php

namespace CubeAgency\ArboryMail\Repositories;

use CubeAgency\ArboryMail\Mail\Mail;
use Illuminate\Support\Collection;

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
}