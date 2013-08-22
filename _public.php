<?php

$core->addBehavior('publicHeadContent', array('uiKit', 'publicHeadcontent'));
$core->tpl->addValue('uiKitIconURL', array('uiKit', 'uiKitIconURL'));

class uiKit
{
    public static function publicHeadContent(dcCore $core)
    {
        $settings = $core->blog->settings->addNamespace('uikit');
        $theme = $settings->get('theme');
        $theme =  $theme == 'default' ? '' : ".$theme";

        echo '<link href="' . $core->blog->settings->system->themes_url .
             "/".$core->blog->settings->system->theme .
             '/uikit/css/uikit' . $theme . '.min.css" rel="stylesheet" />';

        // Ensure CSS override
        echo '<link href="' . $core->blog->settings->system->themes_url .
             "/".$core->blog->settings->system->theme .
             '/style.css" rel="stylesheet" />';

        $icon = $settings->get('icon') or false;
        if ($icon)
        {
            echo '<link rel="icon" type="image/png" href="'. $icon  .'" />';
            echo '<link rel="apple-touch-icon" href="'. $icon .'" />';
        }

    }

    public static function uiKitIconURL($attr)
    {
        global $core;
        $settings = $core->blog->settings->get('uikit') or false;
        if ( ! $settings)
        {
            return '';
        }
        $icon = $settings->get('icon') or false;
        if ( ! $icon)
        {
            return '';
        }
        $iconclass = $settings->get('iconclass') or false;
        if ( ! $iconclass)
        {
            $iconclass = '';
        }

        return '<img src="' . $icon . '" alt="Blog icon" class="' . $iconclass . '" />';
    }
}

