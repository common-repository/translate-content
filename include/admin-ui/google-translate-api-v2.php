<?php
global $TRANSLATECONTENT_plugin_url_path;
global $TRANSLATECONTENT_plugin_version;
global $TRANSLATECONTENT_google_api;

$TRANSLATECONTENT_google_api = get_option("TRANSLATECONTENT_google_api");

switch ($_POST["action"]) {
    case "updateAPI":
        $TRANSLATECONTENT_google_api["apiKey"] = isset($_POST["translate-content-apiKey"]) ? $_POST["translate-content-apiKey"] : "";
        update_option("TRANSLATECONTENT_google_api", $TRANSLATECONTENT_google_api);
        break;
    default:
}
?>
<h2><img width="32" height="32" src="<?php print $TRANSLATECONTENT_plugin_url_path . "/images/translate-content-64x64.png"; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php print __("Translate content", "translate-content") . " " . $TRANSLATECONTENT_plugin_version; ?></h2>
<h3><?php _e("Google translate API v2 account settings", "translate-content"); ?></h3>
<hr>
<form method="POST">
    <input type="hidden" name="action" value="updateAPI"/>
    <label for="translate-content-apiKey"><?php _e('API key for Google translate API v2 from https://code.google.com/apis/console', 'translate-content'); ?></label>
    <input id="translate-content-apiKey" name="translate-content-apiKey" value="<?php echo $TRANSLATECONTENT_google_api["apiKey"]; ?>"/>
    <input type="submit" value="<?php _e("Update", "translate-content"); ?>"/>    
</form>
