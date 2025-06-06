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

    public static function input($type, $inputName, $labelName, $inputAttrs = [], $labelAttrs = [])
    {
        $inputAttrString = null;
        $labelAttrString = null;

        if (!empty($inputAttrs)) {
            foreach ($inputAttrs as $name => $value) {
                $inputAttrString .= sprintf('%s="%s"', $name, $value);
            }
        }

        if (!empty($labelAttrs)) {
            foreach ($labelAttrs as $name => $value) {
                $labelAttrString .= sprintf('%s="%s"', $name, $value);
            }
        }

        $xhtml = sprintf(
            '<div class="mb-3">
                <label class="form-label" %s>%s</label>
                <input type="%s" multiple name="%s" class="form-control" %s</div>
            </div>',
            $labelAttrString,
            $labelName,
            $type,
            $inputName,
            $inputAttrString,
        );
        return $xhtml;
    }

    public static function select($inputName, $options, $currentValue, $labelName)
    {
        $xhtmlOption = null;
        foreach ($options as $value => $text) {
            $selected = ($currentValue == $value) ? 'selected' : '';
            $xhtmlOption .= sprintf('<option value="%s" %s>%s</option>', $value, $selected, $text);
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
