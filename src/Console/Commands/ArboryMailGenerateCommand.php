<?php

namespace CubeAgency\ArboryMail\Console\Commands;

use CubeAgency\ArboryMail\Repositories\MailRepository;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class ArboryMailGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'arbory-mail:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the missing mail classes based on registration in config';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $templates = config('arbory-mail.templates');

        foreach ($templates as $template) {
            $this->makeArboryMail($template);
        }

        // Insert missing templates in database
        resolve(MailRepository::class);

        $this->info('Mail templates generated successfully!');
    }

    /**
     * Make the event and listeners for the given event.
     *
     * @param string $template
     * @return void
     */
    protected function makeArboryMail(string $template)
    {
        if (!Str::contains($template, '\\')) {
            return;
        }

        $this->callSilent('make:arbory-mail', ['name' => $template]);
    }
}
