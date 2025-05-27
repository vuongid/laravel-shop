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

    public static function input($type, $InputName, $labelName)
    {
        $xhtml = sprintf(
            '<div class="mb-3">
                <label class="form-label">%s</label>
                <input type="%s" class="form-control" name="%s" </div>
            </div>',
            $labelName,
            $type,
            $InputName,
        );
        return $xhtml;
    }

    public static function select($inputName, $values, $currentValue, $labelName)
    {
        $xhtmlOption = null;
        foreach ($values as $value => $name) {
            $xhtmlOption .= sprintf('<option value="%s">%s</option>', $value, $name);
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
