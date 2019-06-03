<?php

namespace CubeAgency\ArboryMail\Http\Controllers\Admin;

use Arbory\Base\Admin\Form;
use Arbory\Base\Admin\Form\FieldSet;
use Arbory\Base\Admin\Grid;
use Arbory\Base\Admin\Tools\ToolboxMenu;
use Arbory\Base\Admin\Traits\Crudify;
use CubeAgency\ArboryMail\Admin\Form\Placeholders;
use CubeAgency\ArboryMail\Mail\Mail;
use CubeAgency\ArboryMail\Notifications\TranslatableNotification;
use CubeAgency\ArboryMail\Repositories\MailRepository;
use Illuminate\Routing\Controller;

class MailTemplatesController extends Controller
{
    use Crudify;

    /**
     * @var string
     */
    protected $resource = Mail::class;

    /**
     * @var MailRepository
     */
    protected $repository;

    /**
     * MailTemplatesController constructor
     *
     * @param MailRepository $repository
     */
    public function __construct(MailRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Form $form
     * @return Form
     */
    protected function form(Form $form)
    {
        $form->setFields(function (FieldSet $fields) use ($form) {
            $mail = $form->getModel();
            if ($mail->exists && $mail->type && is_subclass_of($mail->type, TranslatableNotification::class)) {
                /** @var TranslatableNotification $notificationClass */
                $notificationClass = $mail->type;
                $placeholders = $notificationClass::getPlaceholders();
            }

            if (!empty($placeholders)) {
                $fields->add((new Placeholders('placeholders'))->setPlaceholders($placeholders))
                    ->setLabel(trans('arbory-mail::mail.placeholders'));
            }

            $fields->text('subject')->setLabel(trans('arbory-mail::mail.subject'))->translatable();
            $fields->richtext('html')->setLabel(trans('arbory-mail::mail.html'))->translatable();
            $fields->textarea('plain')->setLabel(trans('arbory-mail::mail.plain'))->translatable();

        });

        return $form;
    }

    /**
     * @param Grid $grid
     * @return Grid
     */
    public function grid(Grid $grid)
    {
        $grid->setColumns(function (Grid $grid) {
            $grid->column('subject', trans('arbory-mail::mail.subject'));
            $grid->column('type', trans('arbory-mail::mail.type'));
        });

        return $grid->tools([])->paginate(false);
    }

    /**
     * @param \Arbory\Base\Admin\Tools\ToolboxMenu $tools
     */
    protected function toolbox(ToolboxMenu $tools)
    {
        $model = $tools->model();

        $tools->add('edit', $this->url('edit', $model->getKey()));
    }
}
