<?php
global $TRANSLATECONTENT_plugin_url_path;
global $TRANSLATECONTENT_plugin_version;
global $TRANSLATECONTENT_simpleMetabox;

$TRANSLATECONTENT_simpleMetabox = get_option("TRANSLATECONTENT_simpleMetabox");

switch ($_POST["action"]) {
    case "updateMetabox":
        $TRANSLATECONTENT_simpleMetabox["sourceLanguage"] = isset($_POST["translate-content-DefaultSourceLanguage"]) ? $_POST["translate-content-DefaultSourceLanguage"] : "en";
        update_option("TRANSLATECONTENT_simpleMetabox", $TRANSLATECONTENT_simpleMetabox);
        break;
    default:
}
?>
<h2><img width="32" height="32" src="<?php print $TRANSLATECONTENT_plugin_url_path . "/images/translate-content-64x64.png"; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php print __("Translate content", "translate-content") . " " . $TRANSLATECONTENT_plugin_version; ?></h2>
<h3><?php _e("Simple translate metabox settings", "translate-content"); ?></h3>
<hr>

<form method="POST">
    <input type="hidden" name="action" value="updateMetabox"/>
    <label for="translate-content-DefaultSourceLanguage"><?php _e('Default source language for simple translate metabox', 'translate-content'); ?></label>
    <select 
        id="translate-content-DefaultSourceLanguage" 
        name="translate-content-DefaultSourceLanguage">
        <option value="auto" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "auto") echo "selected"; ?>><?php _e("Detect language","translate-content"); ?></option>
        <option value="af" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "af") echo "selected"; ?>>Afrikaans</option>
        <option value="sq" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "sq") echo "selected"; ?>>Albanian</option>
        <option value="ar" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ar") echo "selected"; ?>>Arabic</option>
        <option value="be" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "be") echo "selected"; ?>>Belarusian</option>
        <option value="bg" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "bg") echo "selected"; ?>>Bulgarian</option>
        <option value="ca" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ca") echo "selected"; ?>>Catalan</option>
        <option value="zh-CN" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "zh-CN") echo "selected"; ?>>Chinese (Simplified)</option>
        <option value="zh-TW" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "zh-TW") echo "selected"; ?>>Chinese (Traditional)</option>
        <option value="hr" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "hr") echo "selected"; ?>>Croatian</option>
        <option value="cs" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "cs") echo "selected"; ?>>Czech</option>
        <option value="da" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "da") echo "selected"; ?>>Danish</option>
        <option value="nl" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "nl") echo "selected"; ?>>Dutch</option>
        <option value="en" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "en") echo "selected"; ?>>English</option>
        <option value="eo" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "eo") echo "selected"; ?>>Esperanto</option>
        <option value="et" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "et") echo "selected"; ?>>Estonian</option>
        <option value="tl" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "tl") echo "selected"; ?>>Filipino</option>
        <option value="fi" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "fi") echo "selected"; ?>>Finnish</option>
        <option value="fr" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "fr") echo "selected"; ?>>French</option>
        <option value="gl" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "gl") echo "selected"; ?>>Galician</option>
        <option value="de" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "de") echo "selected"; ?>>German</option>
        <option value="el" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "el") echo "selected"; ?>>Greek</option>
        <option value="ht" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ht") echo "selected"; ?>>Haitian Creole</option>
        <option value="iw" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "iw") echo "selected"; ?>>Hebrew</option>
        <option value="hi" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "hi") echo "selected"; ?>>Hindi</option>
        <option value="hu" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "hu") echo "selected"; ?>>Hungarian</option>
        <option value="is" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "is") echo "selected"; ?>>Icelandic</option>
        <option value="id" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "id") echo "selected"; ?>>Indonesian</option>
        <option value="ga" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ga") echo "selected"; ?>>Irish</option>
        <option value="it" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "it") echo "selected"; ?>>Italian</option>
        <option value="ja" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ja") echo "selected"; ?>>Japanese</option>
        <option value="ko" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ko") echo "selected"; ?>>Korean</option>
        <option value="lv" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "lv") echo "selected"; ?>>Latvian</option>
        <option value="lt" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "lt") echo "selected"; ?>>Lithuanian</option>
        <option value="mk" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "mk") echo "selected"; ?>>Macedonian</option>
        <option value="ms" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ms") echo "selected"; ?>>Malay</option>
        <option value="mt" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "mt") echo "selected"; ?>>Maltese</option>
        <option value="no" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "no") echo "selected"; ?>>Norwegian</option>
        <option value="fa" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "fa") echo "selected"; ?>>Persian</option>
        <option value="pl" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "pl") echo "selected"; ?>>Polish</option>
        <option value="pt" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "pt") echo "selected"; ?>>Portuguese</option>
        <option value="ro" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ro") echo "selected"; ?>>Romanian</option>
        <option value="ru" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "ru") echo "selected"; ?>>Russian</option>
        <option value="sr" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "sr") echo "selected"; ?>>Serbian</option>
        <option value="sk" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "sk") echo "selected"; ?>>Slovak</option>
        <option value="sl" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "sl") echo "selected"; ?>>Slovenian</option>
        <option value="es" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "es") echo "selected"; ?>>Spanish</option>
        <option value="sw" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "sw") echo "selected"; ?>>Swahili</option>
        <option value="sv" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "sv") echo "selected"; ?>>Swedish</option>
        <option value="th" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "th") echo "selected"; ?>>Thai</option>
        <option value="tr" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "tr") echo "selected"; ?>>Turkish</option>
        <option value="uk" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "uk") echo "selected"; ?>>Ukrainian</option>
        <option value="vi" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "vi") echo "selected"; ?>>Vietnamese</option>
        <option value="cy" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "cy") echo "selected"; ?>>Welsh</option>
        <option value="yi" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "yi") echo "selected"; ?>>Yiddish</option>
    </select>     
    <input type="submit" value="<?php _e("Update", "translate-content"); ?>"/>
</form>