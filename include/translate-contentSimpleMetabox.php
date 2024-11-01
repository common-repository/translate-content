<?php
/*
  Widget Name: Translate content Simple Metabox
  Plugin URI: http://www.devtech.cz/
  Description: Help users to put Translate content api as a metabox
  Version: 1.0.0
  Author: Juraj Puchký
  Author URI: http://www.devtech.cz/
 */

function TRANSLATECONTENTSimpleMetabox_addMetabox() {
    add_meta_box(
            'translate-content-metabox', __('Simple translate', 'translate-content'), 'TRANSLATECONTENTSimpleMetabox_drawBox', 'post', 'side', 'default'
    );
    add_meta_box(
            'translate-content-metabox', __('Simple translate', 'translate-content'), 'TRANSLATECONTENTSimpleMetabox_drawBox', 'page', 'side', 'default'
    );
}

/* Prints the box content */

function TRANSLATECONTENTSimpleMetabox_drawBox($post) {
    global $TRANSLATECONTENT_plugin_url_path;
    global $TRANSLATECONTENT_google_api;

    $TRANSLATECONTENT_google_api = get_option("TRANSLATECONTENT_google_api");
    $TRANSLATECONTENT_simpleMetabox = get_option("TRANSLATECONTENT_simpleMetabox");

    wp_nonce_field(plugin_basename(__FILE__), 'translate-contentSimpleMetabox');
    ?>
    <script type="text/javascript" src="<?php echo $TRANSLATECONTENT_plugin_url_path; ?>/scripts/api/jshttpclient.js"></script>
    <script type="text/javascript" src="<?php echo $TRANSLATECONTENT_plugin_url_path; ?>/scripts/api/jsgtv2c.js"></script>
    <script type="text/javascript">
        var apiKey = '<?php echo $TRANSLATECONTENT_google_api["apiKey"]; ?>';
        if (apiKey === '') {
            alert('<?php _e("Setup your API-Key in menu", "translate-content"); ?>');
        }
        var supportedLanguages = new Jsgtv2cSupportedLanguages(apiKey);
        var detect = new Jsgtv2cDetect(apiKey);
        var translate = new Jsgtv2cTranslate(apiKey);
        var original = new String();
        var selected = false;


        function CustomGoogleTranslateHandler() {
            this.onSupportedLanguagesChanged = function(client) {
                e = document.getElementById("translate-contentMetabox-targetLanguage");
                languages = client.getSupportedLanguages();
                e.innerHTML = "";
                for (var lang in languages) {
                    e.innerHTML += "<option value='" + languages[lang].language + "'>" + languages[lang].name + "</option>" + "\n";
                }
            };

            this.onDetectedLanguagesChanged = function(client) {
                e = document.getElementById("detection");
                detections = client.getDetectedLanguages();
                for (var detc in detections) {
                    for (var d in detections[detc]) {
                        e.innerHTML += detections[detc][d].language + "<br>";
                    }
                }
            };

            this.onTranslatedTextChanged = function(client) {
                translation = client.getTranslatedText();
                var ed = window.tinymce.activeEditor ? window.tinymce.activeEditor : window.tinymce.editors.content;
                if (selected) {
                    ed.selection.setContent(translation);
                } else {
                    ed.setContent(translation);
                }
            };
        }

        function init() {
            detect.customGoogleTranslateApiHandler = new CustomGoogleTranslateHandler();
            detect.setText("Hello world");
            detect.doDetection();
        }

        function updateTargetLanguages() {
            var e = document.getElementById('translate-contentMetabox-sourceLanguage');
            supportedLanguages.customGoogleTranslateApiHandler = new CustomGoogleTranslateHandler();
            supportedLanguages.setTargetLanguage(e.value);
            supportedLanguages.doCalculateOfSupportedLanguages();
        }

        function translateContent() {
            var ed = window.tinymce.activeEditor ? window.tinymce.activeEditor : window.tinymce.editors.content;
            var sle = document.getElementById('translate-contentMetabox-sourceLanguage');
            var tle = document.getElementById('translate-contentMetabox-targetLanguage');
            var tb = document.getElementById('translate-contentMetabox-translatebutton');
            var rb = document.getElementById('translate-contentMetabox-revertbutton');

            tb.disabled = true;
            rb.disabled = false;

            original = ed.getContent();
            source = ed.getContent();

            if (ed.selection.getContent().length > 0) {
                selected = true;
                source = ed.selection.getContent();
            } else {
                selected = false;
            }

            translate.customGoogleTranslateApiHandler = new CustomGoogleTranslateHandler();
            translate.setSourceLanguage(sle.value);
            translate.setTargetLanguage(tle.value);
            translate.setText(source);
            translate.doTranslate();

            return false;
        }


        function revertContent() {
            var ed = window.tinymce.activeEditor ? window.tinymce.activeEditor : window.tinymce.editors.content;
            ed.setContent(original);
            var tb = document.getElementById('translate-contentMetabox-translatebutton');
            var rb = document.getElementById('translate-contentMetabox-revertbutton');
            
            tb.disabled = false;
            rb.disabled = true;            
            return false;
        }

        // Automatic load supported languages
        if (window.addEventListener) {
            window.addEventListener("load", function() {
                updateTargetLanguages();
            });
        } else if (window.attachEvent) {
            window.attachEvent("onload", function() {
                updateTargetLanguages();
            });
        } else if (window.onload) {
            window.onload = function() {
                updateTargetLanguages();
            };
        }

    </script>
    <select 
        id="translate-contentMetabox-sourceLanguage" 
        name="translate-contentMetabox-sourceLanguage" onchange="javascript:updateTargetLanguages();">
        <option value="auto" <?php if ($TRANSLATECONTENT_simpleMetabox["sourceLanguage"] == "auto") echo "selected"; ?>><?php _e("Detect language", "translate-content"); ?></option>        
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
    <input id="translate-contentMetabox-translatebutton" type="button" value="<?php _e("Translate", "translate-content"); ?>" onclick="javascript:translateContent();"/>    
    <select id="translate-contentMetabox-targetLanguage" 
            name="translate-contentMetabox-targetLanguage">        
    </select>            
    <input id="translate-contentMetabox-revertbutton" type="button" value="<?php _e("Revert", "translate-content"); ?>" onclick="javascript:revertContent();"/>
    <?php
}

function TRANSLATECONTENTSimpleMetabox_savePostdata($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!wp_verify_nonce($_POST['translate-contentSimpleMetabox'], plugin_basename(__FILE__)))
        return;

    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return;
    }
    else {
        if (!current_user_can('edit_post', $post_id))
            return;
    }
}
?>
