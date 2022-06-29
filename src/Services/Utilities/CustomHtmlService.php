<?php

namespace Laraflow\Core\Services\Utilities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

/**
 * Class CustomHtmlService
 * @package Laraflow\Core\Supports
 */
class CustomHtmlService
{
    /**
     * Switch function for enable and disable status of model
     *
     * @param Model $model
     * @param string $field
     * @param array $options
     * @param mixed|null $current_value
     * @param array $states
     * @return HtmlString
     */
    public static function flagChangeButton(Model $model, string $field, array $options = [], $current_value = null, array $states = []): HtmlString
    {
        //Get Model information
        $model_id = $model->${$model->getKeyName()};
        $model_path = get_class($model); //generate switch states
        $options['on'] = $options['on'] ?? array_shift($options);
        $options['off'] = $options['off'] ?? array_shift($options); //generate switch states colors
        $states['on'] = $states['on'] ?? 'success';
        $states['off'] = $states['off'] ?? 'danger';
        $HTML = "<input class='toggle-class' type='checkbox' ";
        $HTML .= "data-onstyle='" . $states['on'] . "' data-offstyle='" . $states['off'] . "' data-toggle='toggle' data-size='small'";
        $HTML .= "data-model='$model_path' data-id='$model_id' data-field='$field' ";
        $HTML .= "data-on='" . $options['on'] . "' data-off='" . $options['off'] . "'";
        if (is_null($current_value)) {
            $HTML .= ($options['on'] == $model->$field) ? " checked" : "";
        } else {
            $HTML .= ($options['on'] == $current_value) ? " checked" : "";
        }
        $HTML .= ">";

        return new HtmlString($HTML);
    }

    /**
     * Custom pagination query string appending function
     *
     * @param $collection
     * @param string $type [default, simple]
     * @return mixed
     */
    public static function pagination($collection, string $type = 'default')
    {
        return $collection->onEachSide(2)->appends(request()->query())
            ->links('layouts.paginate.' . $type . '-paginate');
    }

    /**
     * Confirmation model popup handler for delete, restore and export
     * authorization confirmation approval.
     *
     * @param string $modelName
     * @param array $actions
     * @return HtmlString
     */
    public static function confirmModal(string $modelName = 'Item', array $actions = []): HtmlString
    {
        $HTML = '';
        if (in_array('delete', $actions)) :
            $HTML .= view("layouts.partials.soft-delete-modal", [
                'model' => $modelName,
            ]);
        endif;

        if (in_array('restore', $actions)) :
            $HTML .= view("layouts.partials.restore-modal", [
                'model' => $modelName,
            ]);
        endif;

        if (in_array('export', $actions)) :
            $HTML .= view("layouts.partials.export-modal", [
                'model' => $modelName,
            ]);
        endif;

        if (in_array('import', $actions)) :
            $HTML .= view("layouts.partials.import-modal", [
                'model' => $modelName,
            ]);
        endif;

        return new HtmlString($HTML);
    }

    /**
     * Audit Operation event icon style provider return string
     *
     * @param string $event
     * @return HtmlString
     */
    public static function eventIcons(string $event): HtmlString
    {
        $eventIcons = [
            'created' => '<i class="fas fa-plus bg-success" data-toggle="tooltip" data-placement="top" title="Created"></i>',
            'updated' => '<i class="fas fa-edit bg-primary" data-toggle="tooltip" data-placement="top" title="Updated"></i>',
            'deleted' => '<i class="fas fa-trash bg-danger" data-toggle="tooltip" data-placement="top" title="Deleted"></i>',
            'restored' => '<i class="fas fa-trash-restore bg-warning" data-toggle="tooltip" data-placement="top" title="Restored"></i>',
        ];

        return new HtmlString($eventIcons[$event] ?? '<i class="fas fa-user bg-secondary" data-toggle="tooltip" data-placement="top" title="Undefined"></i>');
    }

    /**
     * Display tags as inline list items
     *
     * @param array $tags
     * @param string|null $icon_class
     * @return HtmlString
     */
    public static function displayTags(array $tags, string $icon_class = null): HtmlString
    {
        $HTML = "";
        if (count($tags) > 0) :
            $HTML = "<div class='d-inline-block'>";
        $icon = ($icon_class !== null) ? "<i class='{$icon_class} mr-1'></i>" : null;
        foreach ($tags as $tag):
                $HTML .= "<span class='ml-1 badge badge-pill p-2 d-block d-md-inline-block " . UtilityService::randomBadgeBackground() . "'>{$icon} {$tag}</span>";
        endforeach;
        $HTML .= "</div>";
        endif;

        return new HtmlString($HTML);
    }

    /**
     * Display Preloader on Application
     *
     * @return HtmlString
     */
    public static function preloader()
    {
        $HTML = '';

        if (config('backend.preloader') != null):
            $HTML .= ('<div class="preloader flex-column justify-content-center align-items-center">'
                . '<img class="animation__shake" src="' . asset(config('backend.preloader')) . '" height="60" width="60">'
                . '</div>');
        endif;

        return new HtmlString($HTML);
    }
}
