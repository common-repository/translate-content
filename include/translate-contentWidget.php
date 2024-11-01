<?php
/*
  Widget Name: Translate content Widget
  Plugin URI: http://www.devtech.cz/
  Description: Help users to put Translate content api as a widget
  Version: 1.0.0
  Author: Juraj Puchký
  Author URI: http://www.devtech.cz/
 */

class TRANSLATECONTENT_Widget extends WP_Widget {

    /** constructor */
    function TRANSLATECONTENT_Widget() {
        parent::WP_Widget('', 'Translate content', array('description' => __('Help users to use Translate content APIs for translate content, in basic version uses to translate Javscript API, Google Widget.', 'translate-content')), array('width' => 400));
    }

    function display($args = false) {
        self::widget($args, NULL);
    }

    /** @see WP_Widget::widget */
    function widget($args = array(), $instance) {

        global $TRANSLATECONTENT_plugin_url_path;

        $defaults = array(
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        );

        $args = wp_parse_args($args, $defaults);
        extract($args);
        $title = (isset($instance) && isset($instance['title'])) ? esc_attr($instance['title']) : '';
        $pageLanguage = (isset($instance) && isset($instance['pageLanguage'])) ? esc_attr($instance['pageLanguage']) : 'auto';
        $logo = (isset($instance) && isset($instance['hide-google-logo'])) ? esc_attr($instance['hide-google-logo']) : false;
        $style = (isset($instance) && isset($instance['style'])) ? esc_attr($instance['style']) : 'google.translate.TranslateElement.InlineLayout.SIMPLE';
        $poweredby = (isset($instance) && isset($instance['poweredby'])) ? esc_attr($instance['poweredby']) : false;
        $autoDisplay = (isset($instance) && isset($instance['display-google-auto'])) ? esc_attr($instance['display-google-auto']) : false;
        echo $before_widget;

        if ($title) {
            echo $before_title . $title . $after_title;
        }

        // Dynamic content of widget
        ?>
        <div id="google_translate_element"></div>
        <script type="text/javascript">
            function TRANSLATECONTENTElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: '<?php echo $pageLanguage; ?>',
                    autoDisplay: <?php echo $autoDisplay ? "true" : "false"; ?>,
                    layout: <?php echo $style; ?>
                }, 'google_translate_element');
            }
        </script><script src="http://translate.google.com/translate_a/element.js?cb=TRANSLATECONTENTElementInit"></script>
        <?php
        echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['style'] = esc_attr($new_instance['style']);
        $instance['hide-google-logo'] = esc_attr($new_instance['hide-google-logo']);
        $instance['display-google-auto'] = esc_attr($new_instance['display-google-auto']) ? true : false;
        $instance['pageLanguage'] = esc_attr($new_instance['pageLanguage']);
        $instance['poweredby'] = esc_attr($new_instance['poweredby']);
        update_option("hide-translate-content-logo", esc_attr($instance['hide-google-logo']) ? true : false);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = (isset($instance) && isset($instance['title'])) ? esc_attr($instance['title']) : '';
        $pageLanguage = (isset($instance) && isset($instance['pageLanguage'])) ? esc_attr($instance['pageLanguage']) : 'auto';
        $logo = (isset($instance) && isset($instance['hide-google-logo'])) ? (esc_attr($instance['hide-google-logo']) ? true : false) : false;
        $autoDisplay = (isset($instance) && isset($instance['display-google-auto'])) ? esc_attr($instance['display-google-auto']) : false;
        $style = (isset($instance) && isset($instance['style'])) ? esc_attr($instance['style']) : 'google.translate.TranslateElement.InlineLayout.SIMPLE';
        $poweredby = (isset($instance) && isset($instance['poweredby'])) ? esc_attr($instance['poweredby']) : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'translate-content'); ?></label> 
            <input class="widefat" 
                   id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" 
                   type="text" 
                   value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('pageLanguage'); ?>"><?php _e('Source language:', 'translate-content'); ?></label> 
            <select class="widefat" 
                    id="<?php echo $this->get_field_id('pageLanguage'); ?>" 
                    name="<?php echo $this->get_field_name('pageLanguage'); ?>" >
                <option value="auto" <?php if ($pageLanguage == "auto") echo "selected"; ?> ><? _e('Detect language', 'translate-content'); ?></option>
                <option value="af" <?php if ($pageLanguage == "af") echo "selected"; ?> >Afrikaans</option>
                <option value="sq" <?php if ($pageLanguage == "sq") echo "selected"; ?> >Albanian</option>
                <option value="ar" <?php if ($pageLanguage == "ar") echo "selected"; ?> >Arabic</option>
                <option value="be" <?php if ($pageLanguage == "be") echo "selected"; ?> >Belarusian</option>
                <option value="bg" <?php if ($pageLanguage == "bg") echo "selected"; ?> >Bulgarian</option>
                <option value="ca" <?php if ($pageLanguage == "ca") echo "selected"; ?> >Catalan</option>
                <option value="zh-CN" <?php if ($pageLanguage == "zh-CN") echo "selected"; ?> >Chinese (Simplified)</option>
                <option value="zh-TW" <?php if ($pageLanguage == "zh-TW") echo "selected"; ?> >Chinese (Traditional)</option>
                <option value="hr" <?php if ($pageLanguage == "hr") echo "selected"; ?> >Croatian</option>
                <option value="cs" <?php if ($pageLanguage == "cs") echo "selected"; ?> >Czech</option>
                <option value="da" <?php if ($pageLanguage == "da") echo "selected"; ?> >Danish</option>
                <option value="nl" <?php if ($pageLanguage == "nl") echo "selected"; ?> >Dutch</option>
                <option value="en" <?php if ($pageLanguage == "en") echo "selected"; ?> >English</option>
                <option value="eo" <?php if ($pageLanguage == "eo") echo "selected"; ?> >Esperanto</option>
                <option value="et" <?php if ($pageLanguage == "et") echo "selected"; ?> >Estonian</option>
                <option value="tl" <?php if ($pageLanguage == "tl") echo "selected"; ?> >Filipino</option>
                <option value="fi" <?php if ($pageLanguage == "fi") echo "selected"; ?> >Finnish</option>
                <option value="fr" <?php if ($pageLanguage == "fr") echo "selected"; ?> >French</option>
                <option value="gl" <?php if ($pageLanguage == "gl") echo "selected"; ?> >Galician</option>
                <option value="de" <?php if ($pageLanguage == "de") echo "selected"; ?> >German</option>
                <option value="el" <?php if ($pageLanguage == "el") echo "selected"; ?> >Greek</option>
                <option value="ht" <?php if ($pageLanguage == "ht") echo "selected"; ?> >Haitian Creole</option>
                <option value="iw" <?php if ($pageLanguage == "iw") echo "selected"; ?> >Hebrew</option>
                <option value="hi" <?php if ($pageLanguage == "hi") echo "selected"; ?> >Hindi</option>
                <option value="hu" <?php if ($pageLanguage == "hu") echo "selected"; ?> >Hungarian</option>
                <option value="is" <?php if ($pageLanguage == "is") echo "selected"; ?> >Icelandic</option>
                <option value="id" <?php if ($pageLanguage == "id") echo "selected"; ?> >Indonesian</option>
                <option value="ga" <?php if ($pageLanguage == "ga") echo "selected"; ?> >Irish</option>
                <option value="it" <?php if ($pageLanguage == "it") echo "selected"; ?> >Italian</option>
                <option value="ja" <?php if ($pageLanguage == "ja") echo "selected"; ?> >Japanese</option>
                <option value="ko" <?php if ($pageLanguage == "ko") echo "selected"; ?> >Korean</option>
                <option value="lv" <?php if ($pageLanguage == "lv") echo "selected"; ?> >Latvian</option>
                <option value="lt" <?php if ($pageLanguage == "lt") echo "selected"; ?> >Lithuanian</option>
                <option value="mk" <?php if ($pageLanguage == "mk") echo "selected"; ?> >Macedonian</option>
                <option value="ms" <?php if ($pageLanguage == "ms") echo "selected"; ?> >Malay</option>
                <option value="mt" <?php if ($pageLanguage == "mt") echo "selected"; ?> >Maltese</option>
                <option value="no" <?php if ($pageLanguage == "no") echo "selected"; ?> >Norwegian</option>
                <option value="fa" <?php if ($pageLanguage == "fa") echo "selected"; ?> >Persian</option>
                <option value="pl" <?php if ($pageLanguage == "pl") echo "selected"; ?> >Polish</option>
                <option value="pt" <?php if ($pageLanguage == "pt") echo "selected"; ?> >Portuguese</option>
                <option value="ro" <?php if ($pageLanguage == "ro") echo "selected"; ?> >Romanian</option>
                <option value="ru" <?php if ($pageLanguage == "ru") echo "selected"; ?> >Russian</option>
                <option value="sr" <?php if ($pageLanguage == "sr") echo "selected"; ?> >Serbian</option>
                <option value="sk" <?php if ($pageLanguage == "sk") echo "selected"; ?> >Slovak</option>
                <option value="sl" <?php if ($pageLanguage == "sl") echo "selected"; ?> >Slovenian</option>
                <option value="es" <?php if ($pageLanguage == "es") echo "selected"; ?> >Spanish</option>
                <option value="sw" <?php if ($pageLanguage == "sw") echo "selected"; ?> >Swahili</option>
                <option value="sv" <?php if ($pageLanguage == "sv") echo "selected"; ?> >Swedish</option>
                <option value="th" <?php if ($pageLanguage == "th") echo "selected"; ?> >Thai</option>
                <option value="tr" <?php if ($pageLanguage == "tr") echo "selected"; ?> >Turkish</option>
                <option value="uk" <?php if ($pageLanguage == "uk") echo "selected"; ?> >Ukrainian</option>
                <option value="vi" <?php if ($pageLanguage == "vi") echo "selected"; ?> >Vietnamese</option>
                <option value="cy" <?php if ($pageLanguage == "cy") echo "selected"; ?> >Welsh</option>
                <option value="yi" <?php if ($pageLanguage == "yi") echo "selected"; ?> >Yiddish</option>
            </select>            
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:', 'translate-content'); ?></label> 
            <input id="<?php echo $this->get_field_id('style-vertical'); ?>" 
                   name="<?php echo $this->get_field_name('style'); ?>" 
        <?php if ($style == "google.translate.TranslateElement.InlineLayout.VERTICAL") echo "checked"; ?> 
                   value="google.translate.TranslateElement.InlineLayout.VERTICAL" 
                   type="radio">
            <label for="<?php echo $this->get_field_name('style-vertical'); ?>"><?php _e('Vertical', 'translate-content'); ?></label>  
            <input id="<?php echo $this->get_field_name('style-horizontal'); ?>" 
                   name="<?php echo $this->get_field_name('style'); ?>" 
        <?php if ($style == "google.translate.TranslateElement.InlineLayout.HORIZONTAL") echo "checked"; ?> 
                   value="google.translate.TranslateElement.InlineLayout.HORIZONTAL" 
                   type="radio">
            <label for="<?php echo $this->get_field_name('style-horizontal'); ?>"><?php _e('Horizontal', 'translate-content'); ?></label>
            <input id="<?php echo $this->get_field_name('style-dropdown'); ?>" 
                   name="<?php echo $this->get_field_name('style'); ?>" 
        <?php if ($style == "google.translate.TranslateElement.InlineLayout.SIMPLE") echo "checked"; ?> 
                   value="google.translate.TranslateElement.InlineLayout.SIMPLE" 
                   type="radio">
            <label for="<?php echo $this->get_field_name('style-dropdown'); ?>"><?php _e('Dropdown only', 'translate-content'); ?></label>              
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('hide-google-logo'); ?>" 
                   name="<?php echo $this->get_field_name('hide-google-logo'); ?>" 
        <?php if ($logo) echo "checked "; ?> 
                   value="hide-google-logo" 
                   type="checkbox">
            <label for="<?php echo $this->get_field_id('hide-google-logo'); ?>"><?php _e('Hide google logo', 'translate-content'); ?></label>  
        </p>       
        <p>
            <input id="<?php echo $this->get_field_id('display-google-auto'); ?>" 
                   name="<?php echo $this->get_field_name('display-google-auto'); ?>" 
        <?php if ($autoDisplay) echo "checked "; ?> 
                   value="display-google-auto" 
                   type="checkbox">
            <label for="<?php echo $this->get_field_id('display-google-auto'); ?>"><?php _e('Enable automatic translate', 'translate-content'); ?></label>  
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('poweredby'); ?>" 
                   name="<?php echo $this->get_field_name('poweredby'); ?>" 
                   type="checkbox" 
        <?php
        if ($poweredby) {
            echo "checked ";
        }
        ?>
                   value="poweredby" />
            <label for="<?php echo $this->get_field_id('poweredby'); ?>"><?php _e('You can promote us with small link on bottom of ad.', 'translate-content'); ?></label>
        </p>        
        <?php
    }

}
?>
