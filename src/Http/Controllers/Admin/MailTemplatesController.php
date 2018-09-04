<?php

namespace CubeAgency\ArboryMail\Http\Controllers\Admin;

use Arbory\Base\Admin\Form;
use Arbory\Base\Admin\Form\Fields\Richtext;
use Arbory\Base\Admin\Form\Fields\Text;
use Arbory\Base\Admin\Form\Fields\Textarea;
use Arbory\Base\Admin\Form\Fields\Translatable;
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
     * @param Mail $mail
     * @return Form
     */
    protected function form(Mail $mail)
    {
        $form = $this->module()->form($mail, function (Form $form) use ($mail) {

            if ($mail->exists && $mail->type && is_subclass_of($mail->type, TranslatableNotification::class)) {
                /** @var TranslatableNotification $notificationClass */
                $notificationClass = $mail->type;
                $placeholders = $notificationClass::getPlaceholders();
            }

            if (!empty($placeholders)) {
                $form->addField((new Placeholders('placeholders'))->setPlaceholders($placeholders));
            }

            $form->addField(new Translatable(new Text('subject')))->setLabel(trans('arbory-mail::mail.subject'));
            $form->addField(new Translatable(new Richtext('html')))->setLabel(trans('arbory-mail::mail.html'));
            $form->addField(new Translatable(new Textarea('plain')))->setLabel(trans('arbory-mail::mail.plain'));
        });

        return $form;
    }

    /**
     * @return Grid
     */
    public function grid()
    {
        $grid = $this->module()->grid($this->resource(), function (Grid $grid){
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
