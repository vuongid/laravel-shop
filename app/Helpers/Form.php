<?php

namespace App\Helpers;


class Form
{
    public static function show($elements)
    {
        $xhtml = null;

        foreach ($elements as $element) {
            $xhtml .= $element;
        }

        return $xhtml;
    }

    public static function input($type, $inputName, $labelName, $inputValue = null)
    {
        $xhtml = sprintf(
            '<div class="mb-3">
                <label class="form-label">%s</label>
                <input type="%s" class="form-control" name="%s" value="%s"</div>
            </div>',
            $labelName,
            $type,
            $inputName,
            $inputValue,
        );
        return $xhtml;
    }

    public static function select($inputName, $values, $currentValue, $labelName)
    {
        $xhtmlOption = null;
        foreach ($values as $value => $name) {
            $selected = ($currentValue == $value) ? 'selected' : '';
            $xhtmlOption .= sprintf('<option value="%s" %s>%s</option>', $value, $selected, $name);
        }

        $xhtml = sprintf(
            '<div class="mb-3">
                <div class="form-label">%s</div>
                <select class="form-select" name="%s">
                %s
                </select>
            </div>',
            $labelName,
            $inputName,
            $xhtmlOption,
        );
        return $xhtml;
    }
}
