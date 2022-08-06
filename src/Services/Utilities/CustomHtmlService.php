<?php

namespace Laraflow\Core\Services\Utilities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\HtmlString;
use Laraflow\Core\Abstracts\Service\Service;

/**
 * Class CustomHtmlService
 */
class CustomHtmlService extends Service
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
            $HTML .= ($options['on'] == $model->$field) ? ' checked' : '';
        } else {
            $HTML .= ($options['on'] == $current_value) ? ' checked' : '';
        }
        $HTML .= '>';

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
            ->links(Config::get('core.paginate_location') . $type . '-paginate');
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
        foreach (Config::get('core.popup_actions') as $action => $layout) {
            if (in_array($action, $actions)) {
                $HTML .= view($layout, [
                    'model' => $modelName,
                ]);
            }
        }

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

        return new HtmlString(($eventIcons[$event] ?? '<i class="fas fa-user bg-secondary" data-toggle="tooltip" data-placement="top" title="Undefined"></i>'));
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
        $HTML = '';
        if (count($tags) > 0) {
            $HTML = "<div class='d-inline-block'>";
            $icon = ($icon_class !== null) ? "<i class='{$icon_class} mr-1'></i>" : null;
            foreach ($tags as $tag) {
                $HTML .= "<span class='ml-1 badge badge-pill p-2 d-block d-md-inline-block " . UtilityService::randomBadgeBackground() . "'>{$icon} {$tag}</span>";
            }
            $HTML .= '</div>';
        }

        return new HtmlString($HTML);
    }
}
