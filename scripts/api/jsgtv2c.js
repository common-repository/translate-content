/* 
 Java Script Google translate REST API v2 Client
 @Description REST API client for Google translate v2 API with support JSON processing of messages
 - supported languages
 - detection of language
 - translate of text
 @Require JSHTTPCLIENT Project https://sourceforge.net/p/jshttpclient
 @Autor Juraj Puchký - Devtech
 @Home http://www.devtech.cz
 @SVN  svn checkout svn://svn.code.sf.net/p/jsgtv2c/code/trunk jsgtv2c-code
 @Donation 5$ over there -> https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H2T85LJ5L9XVL  then i can give more time to improove code.
 @Licence GPLv3 or later
 */

/**
 * 
 * @param {type} APIKey
 * @returns {Jsgtv2cTranslate}
 */
function Jsgtv2cTranslate(APIKey) {
    this.translatedText = new String();
    this.sourceLanguage = new String();
    this.translations = new Array();
    this.targetLanguage = new String();
    this.text = new String();
    this.customGoogleTranslateApiHandler = null;
    this.httpClient = new HTTPClient();

    function Jsgtv2cTranslateHTTPHandler(client) {
        this.client = client;

        this.onFinally = function(result) {
            var json = window.JSON;
            var res = json.parse(result);
            if (res.error !== null && res.error !== undefined) {
                for (var error in res.error.errors) {
                    throw "Google API: " + res.error.errors[error].message;
                }
            } else {
                this.client.setTranslatedText(res.data.translations[0].translatedText);
                this.client.translations = res.data.translations;
            }
        };
    }


    this.doTranslate = function() {
        var params = new HTTPParams();
        params.add('q', this.text);
        params.add('source', this.sourceLanguage);
        params.add('target', this.targetLanguage);
        this.httpClient.customHTTPHandler = new Jsgtv2cTranslateHTTPHandler(this);
        this.httpClient.processRequestImmedietaly = true;
        this.httpClient.get(this.serviceURL, params);
    };


    this.getText = function() {
        return this.text;
    };

    this.setText = function(text) {
        this.text = text;
    };

    this.setTranslatedText = function(translatedText) {
        this.translatedText = translatedText;
        if (this.customGoogleTranslateApiHandler !== null) {
            if (this.customGoogleTranslateApiHandler.onTranslatedTextChanged !== undefined && this.customGoogleTranslateApiHandler.onTranslatedTextChanged !== null) {
                this.customGoogleTranslateApiHandler.onTranslatedTextChanged(this);
            }
        }
    };

    this.getTranslatedText = function() {
        return this.translatedText;
    };

    this.getSourceLanguage = function() {
        return this.sourceLanguage;
    };

    this.getTargetLanguage = function() {
        return this.targetLanguage;
    };

    this.setSourceLanguage = function(sourceLanguage) {
        this.sourceLanguage = sourceLanguage;
    };

    this.setTargetLanguage = function(targetLanguage) {
        this.targetLanguage = targetLanguage;
    };

    this.serviceURL = 'https://www.googleapis.com/language/translate/v2?key=' + APIKey;

}

/**
 * 
 * @param {type} APIKey
 * @returns {Jsgtv2cDetect}
 */
function Jsgtv2cDetect(APIKey) {
    this.detectedLanguages = new Array();
    this.text = new String();
    this.customGoogleTranslateApiHandler = null;
    this.httpClient = new HTTPClient();

    function Jsgtv2cDetectHTTPHandler(client) {
        this.client = client;

        this.onFinally = function(result) {
            var json = window.JSON;
            var res = json.parse(result);
            if (res.error !== null && res.error !== undefined) {
                for (var error in res.error.errors) {
                    throw "Google API: " + res.error.errors[error].message;
                }
            } else {
                this.client.setDetectedLanguages(res.data.detections);
            }
        };
    }


    this.doDetection = function() {
        var params = new HTTPParams();
        params.add('q', this.text);
        this.httpClient.customHTTPHandler = new Jsgtv2cDetectHTTPHandler(this);
        this.httpClient.processRequestImmedietaly = true;
        this.httpClient.get(this.serviceURL, params);
    };

    this.getDetectedLanguages = function() {
        return this.detectedLanguages;
    };

    this.getText = function() {
        return this.text;
    };

    this.setText = function(text) {
        this.text = text;
    };

    this.setDetectedLanguages = function(detections) {
        this.detectedLanguages = detections;
        if (this.customGoogleTranslateApiHandler !== null) {
            if (this.customGoogleTranslateApiHandler.onDetectedLanguagesChanged !== undefined && this.customGoogleTranslateApiHandler.onDetectedLanguagesChanged !== null) {
                this.customGoogleTranslateApiHandler.onDetectedLanguagesChanged(this);
            }
        }
    };

    this.serviceURL = 'https://www.googleapis.com/language/translate/v2/detect?key=' + APIKey;
}

/**
 * 
 * @param {type} APIKey
 * @returns {Jsgtv2cSupportedLanguages}
 */
function Jsgtv2cSupportedLanguages(APIKey) {
    this.supportedLanguages = new Array();
    this.targetLanguage = new String();
    this.customGoogleTranslateApiHandler = null;
    this.httpClient = new HTTPClient();

    function Jsgtv2cSupportedLanguagesHTTPHandler(client) {
        this.client = client;

        this.onFinally = function(result) {

            var json = window.JSON;
            var res = json.parse(result);

            if (res.error !== null && res.error !== undefined) {
                for (var error in res.error.errors) {
                    throw "Google API: " + res.error.errors[error].message;
                }
            } else {
                this.client.setSupportedLanguages(res.data.languages);
            }
        };
    }

    this.doCalculateOfSupportedLanguages = function() {
        var params = new HTTPParams();
        params.add('target', this.targetLanguage);
        this.httpClient.customHTTPHandler = new Jsgtv2cSupportedLanguagesHTTPHandler(this);
        this.httpClient.processRequestImmedietaly = true;
        this.httpClient.get(this.serviceURL, params);
    };

    this.getSupportedLanguages = function() {
        return this.supportedLanguages;
    };

    this.getTargetLanguage = function() {
        return this.targetLanguage;
    };

    this.setTargetLanguage = function(target) {
        this.targetLanguage = target;
    };

    this.setSupportedLanguages = function(languages) {
        this.supportedLanguages = languages;
        if (this.customGoogleTranslateApiHandler !== null) {
            if (this.customGoogleTranslateApiHandler.onSupportedLanguagesChanged !== undefined && this.customGoogleTranslateApiHandler.onSupportedLanguagesChanged !== null) {
                this.customGoogleTranslateApiHandler.onSupportedLanguagesChanged(this);
            }
        }
    };

    this.serviceURL = 'https://www.googleapis.com/language/translate/v2/languages?key=' + APIKey;
}

