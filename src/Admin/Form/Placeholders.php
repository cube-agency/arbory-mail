<?php

namespace CubeAgency\ArboryMail\Admin\Form;

use Arbory\Base\Admin\Form\Fields\AbstractField;
use Arbory\Base\Html\Elements\Element;
use Arbory\Base\Html\Html;
use Illuminate\Http\Request;

class Placeholders extends AbstractField
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @return Element
     */
    public function render()
    {
        $list = [];
        foreach ($this->items as $placeholder) {
            $list[] = Html::li(':' . $placeholder)
                ->addAttributes([
                    'style' => 'font-weight: bold; margin-right: 10px; border: 1px solid #d4d4d4; padding: 0 5px;'
                ]);
        }

        return Html::div([
            Html::ul($list)->addAttributes(['style' => 'margin: 0; display: flex; padding: 0;list-style-type: none;']),
        ])->addAttributes(['style' => 'clear:both; padding: 12px 0; width:100%;']);
    }

    /**
     * @param array $items
     * @return Placeholders
     */
    public function setPlaceholders(array $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param Request $request
     */
    public function beforeModelSave(Request $request)
    {

    }
}
