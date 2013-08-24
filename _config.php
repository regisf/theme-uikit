<?php
/*
 * Configuration file for UIKit dotclear theme
 */
if (!defined('DC_CONTEXT_ADMIN')) { return; }

$settings = $core->blog->settings->addNamespace('uikit');
$themes = array('default', 'almost-flat', 'gradient');
$should_be_triggered = false;

if ( ! empty($_POST['theme']))
{
    $theme_saved = $_POST['theme'];
    $settings->put('theme',  $theme_saved, 'string');
    $should_be_triggered = true;
}
else
{
    $theme_saved = $settings->get('theme') or false;
    if (!$theme_saved) {
        $theme_saved = 'default';
    }
}

if ( ! empty($_FILES['icon']))
{
    if ( ! empty($_FILES['icon']['name']))
    {
        $core->media = new dcMedia($core);
        $media_id = $core->media->uploadFile(
            $_FILES['icon']['tmp_name'],
            $_FILES['icon']['name'],
            'uikit-icon',
            false,
            true
        );
        $fileurl = $core->media->getFile($media_id)->file_url;
        $settings->put('icon', $fileurl, 'string');
        $should_be_triggered = true;
    }
}

if ( ! isset($fileurl))
{
    $fileurl = $settings->get('icon') or false;
    if ( ! $fileurl)
    {
        unset($fileurl);
    }
}

if ( ! empty($_POST['iconclass']))
{
    $iconclass = trim($_POST['iconclass']);
    if ($iconclass != '' && $settings->get('iconclass') != '') {
        $settings->put('iconclass', $iconclass, 'string');
        $should_be_triggered = true;
    }
}
else
{
    $iconclass = $settings->get('iconclasss') or false;
    if ( ! $iconclass)
    {
        $iconclass = '';
    }
}

if ( ! empty($_POST['use_postsstats']))
{
    $settings->put('use_postsstats', true, 'boolean');
    $should_be_triggered = true;
}
else
{
    $settings->put('use_postsstats', false, 'boolean');
    $should_be_triggered = true;
}

$usePS = $settings->get('use_postsstats');

if ($should_be_triggered) {
    $core->blog->triggerBlog();
}

?>
<fieldset>
    <legend><?= __('Theme'); ?></legend>
    <div>
        <?= __("Which theme do you want to use?"); ?>
    </div>
        <div>
            <label style="display: inline-block"><?= __('UIKit theme :') ?> </label>
            <select name="theme">
            <?php foreach($themes as $theme): ?>
            <option value="<?= $theme ?>"<?php if ($theme_saved == $theme): ?> selected="selected"<?php endif; ?>><?= $theme; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
</fieldset>

<fieldset>
    <legend><?= __("Display icon") ?></legend>
    <div>
        <?= __("May be you wich to display a front icon. This file will also be used as favicon.") ?>
    </div>
    <div>
        <label><?= __("File to upload") ?></label>
        <input type="file" name="icon" />
    </div>
    <?php if (isset($fileurl)) : ?>
    <div>
        <img src="<?= $fileurl ?>" class="avatar" alt="<?= __('Icon for the web site'); ?>" />
    </div>
    <div>
        <label><?= __('Image tag class name'); ?></label>
        <input type="text" name="iconclass" value="<?= $iconclass ?>" />
    </div>
    <?php endif; ?>
</fieldset>
<fieldset>
    <legend><?= __("Use postsStats"); ?></legend>
    <?php if ($core->plugins->moduleExists('postsStats')): ?>
    <div>
        <p><?= __("postsStats is installed in your plugins. Do you which to use it ?") ?></p>
        <input type="checkbox" name="use_postsstats" id="use_postsstats" <?php if ($usePS == true): ?>checked="checked"<?php endif; ?> />
        <label for="use_postsstats" style="display: inline-block;"><?= __('Use postsStats'); ?></label>
    </div>
    <?php else: ?>
        <p><?= __('postStats allow to count views per post. It may be found '); ?>
            <a href="https://github.com/christophercrouzet/dotclear-plugins-postsStats">
            <?= __("here (original by Christopher Crouzet)") ?>
            </a>
            <?= __('or') ?>
            <a href="https://github.com/regisf/dotclear-plugins-postsStats">
                <?= __("here for my fork") ?>
            </a>
        </p>
    <?php endif; ?>
</fieldset>
