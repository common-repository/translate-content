/* 
 Java Script HTTP Client
 @Description  This object can send HTTP requests to given Web servers.
 It can queue HTTP requests to be sent to remote servers given the URLs.
 The object can handle one request at time fetching the next URL on the queue.
 The requests can be sent via HTTP GET or POST methods using XMLHttpRequest objects or equivalent on each browser.
 An handler object can be registered to handle different types of events like initailization, errors, progress and completion.
 supported
 XMLHttpRequest
 MSXML2.XMLHTTP.6.0,
 MSXML2.XMLHTTP.5.0,
 MSXML2.XMLHTTP.4.0,
 MSXML2.XMLHTTP.3.0,
 MSXML2.XMLHTTP.2.0,
 MSXML2.XMLHTTP,                
 Microsoft.XMLHTTP
 @File jshttpclient.js
 @Autor Juraj Puchký - Devtech <sjurajpuchky@seznam.cz>
 @Home http://www.devtech.cz, https://sourceforge.net/p/jshttpclient
 @SVN  svn checkout svn://svn.code.sf.net/p/jshttpclient/code/trunk jshttpclient
 @Donation 2$ over there -> https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F7LQTUFF5WCXL  then i can give more time to improove code.
 @Version 1.0.0
 @Created 9.10.2012
 @Licence GPLv3 or later AND Disabled persons license as lex specialis
 */

/**
 * @Desctiption you can use following fields to enable optional functionality
 * skipWhenEverIsLocked - will return false after invoking request get() or post() when ever is object in use
 * throwExceptionWhenEverIsLocked - will throw an exception after invoking request get() or post() when ever is object in use
 * putIntoQueryQueueWhenEverIsLocked - 
 * useFifo - use FIFO in queue
 * asynchronous - you can enable or disable asynchonous mode on object XMLHttpRequest
 * @returns {HTTPClient}
 */

function HTTPClient() {
    this.requestQueue = new HTTPRequestQueue();
    this.requestObject = null;
    this.lastestRequest = null;
    this.lock = false;
    // Configuration set

    this.useDefaultHeadersForPOST = true;
    this.customHTTPHeaders = new HTTPHeaders();
    this.skipWhenEverIsLocked = true;
    this.throwExceptionWhenEverIsLocked = false;
    this.throwExceptionWhenEverIsHTTPError = false;
    this.showAlertWhenEverIsHTTPError = false;
    this.throwExceptionWhenEverIsException = false;
    this.processRequestImmedietaly = false;
    this.asynchronous = true;
    this.customHTTPHandler = null;
    this.defaultHTTPHandler = new HTTPResponseHandler();


    this.SUPPORTED_XMLHTTP_IMPLEMENTATIONS = [
        'MSXML2.XMLHTTP.6.0',
        'MSXML2.XMLHTTP.5.0',
        'MSXML2.XMLHTTP.4.0',
        'MSXML2.XMLHTTP.3.0',
        'MSXML2.XMLHTTP.2.0',
        'MSXML2.XMLHTTP',
        'Microsoft.XMLHTTP'
            ];



    this.get = function(url) {
        return this.get(url, new HTTPParams());
    };

    this.get = function(url, httpParams) {
        if (this.lock) {
            if (this.skipWhenEverIsLocked) {
                return false;
            }
            if (this.throwExceptionWhenEverIsLocked) {
                throw 'This instance of object HTTPClient is already in use.';
            }
        }

        this.requestQueue.add(url, 'GET', httpParams);
        if (this.processRequestImmedietaly) {
            return this.next();
        }

    };
    this.next = function() {
        this.lock = true;
        if (this.requestObject === null) {
            throw 'XMLHttpRequest was not created.';
        }

        try {
            this.lastestRequest = this.requestQueue.last();
        } catch (e) {
            return false;
        }

        if (this.lastestRequest === null && this.lastestRequest === undefined) {
            return false;
        } else {


            this.requestObject.onreadystatechange = function() {
                this.httpClient.defaultCallback(this.httpClient);
            };


            if (this.lastestRequest.method === 'POST') {
                this.requestObject.open(this.lastestRequest.method, this.lastestRequest.url, this.asynchronous);
                if (this.useDefaultHeadersForPOST) {
                    this.requestObject.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    this.requestObject.setRequestHeader('Content-length', this.lastestRequest.httpParams.size());
                    this.requestObject.setRequestHeader('Connection', 'close');
                }
                var headers = this.customHTTPHeaders.toArray();
                for (var header in headers) {
                    this.requestObject.setRequestHeader(headers[header].key, headers[header].value);
                }
                this.requestObject.send(this.lastestRequest.httpParams.toString());
            }

            if (this.lastestRequest.method === 'GET') {
                if (this.lastestRequest.httpParams !== undefined && this.lastestRequest.httpParams !== null && this.lastestRequest.httpParams.size() > 0) {
                    var url = new String(this.lastestRequest.url);
                    if (url.indexOf('?') !== -1) {
                        this.requestObject.open(this.lastestRequest.method, this.lastestRequest.url + '&' + this.lastestRequest.httpParams.toString(), this.asynchronous);
                    } else {
                        this.requestObject.open(this.lastestRequest.method, this.lastestRequest.url + '?' + this.lastestRequest.httpParams.toString(), this.asynchronous);
                    }
                } else {
                    this.requestObject.open(this.lastestRequest.method, this.lastestRequest.url, this.asynchronous);
                }
                var headers = this.customHTTPHeaders.toArray();
                for (var header in headers) {
                    this.requestObject.setRequestHeader(headers[header].key, headers[header].value);
                }
                this.requestObject.send(null);
            }
            return true;
        }
    };


    this.post = function(url, httpParams) {

        if (this.lock) {
            if (this.skipWhenEverIsLocked) {
                return false;
            }
            if (this.throwExceptionWhenEverIsLocked) {
                throw 'This instance of object HTTPClient is already in use.';
            }
        }

        this.requestQueue.add(url, 'POST', httpParams);
        if (this.processRequestImmedietaly) {
            return this.next();
        }
    };
    this.getReadyState = function() {
        return this.requestObject.readyState;
    };

    this.getStatus = function() {
        return this.requestObject.status;
    };

    this.getStatusText = function() {
        return this.requestObject.statusText;
    };

    this.getResponseHeader = function(header) {
        return this.requestObject.getResponseHeader(header);
    };

    this.getResponseText = function() {
        return this.requestObject.responseText;
    };

    function HTTPResponseHandler() {

        this.onInitializing = function(httpClient) {
            if (httpClient.customHTTPHandler !== null && httpClient.customHTTPHandler.onInitializing !== null && httpClient.customHTTPHandler.onInitializing !== undefined) {
                httpClient.customHTTPHandler.onInitializing();
            }
        };

        this.onError = function(httpClient, status, statusText) {
            if (httpClient.throwExceptionWhenEverIsHTTPError) {
                throw status + ": " + statusText;
            }
            if (httpClient.showAlertWhenEverIsHTTPError) {
                alert(status + ": " + statusText);
            }
            if (httpClient.customHTTPHandler !== null && httpClient.customHTTPHandler.onError !== null && httpClient.customHTTPHandler.onError !== undefined) {
                httpClient.customHTTPHandler.onError(status, statusText);
            }
        };

        this.onProgress = function(httpClient, responseText, contentLength) {
            if (httpClient.customHTTPHandler !== null && httpClient.customHTTPHandler.onProgress !== null && httpClient.customHTTPHandler.onProgress !== undefined) {
                httpClient.customHTTPHandler.onProgress(responseText, contentLength);
            }
        };

        this.onFinally = function(httpClient, result) {
            if (httpClient.customHTTPHandler !== null && httpClient.customHTTPHandler.onFinally !== null && httpClient.customHTTPHandler.onFinally !== undefined) {
                httpClient.customHTTPHandler.onFinally(result);
            }
            httpClient.lock = false;
        };
    }
    ;

    this.abortCurrentQuery = function() {
        this.lock = false;
    };

    this.defaultCallback = function(httpClient) {
        try {
            switch (httpClient.getReadyState()) {
                case 1:
                    httpClient.defaultHTTPHandler.onInitializing(httpClient);
                    break;
                case 2:
                    if (httpClient.getStatus() !== 200) {
                        httpClient.defaultHTTPHandler.onError(httpClient, httpClient.getStatus(), httpClient.getStatusText());
                        httpClient.abortCurrentQuery();
                    }
                    break;
                case 3:

                    httpClient.defaultHTTPHandler.onProgress(httpClient, httpClient.getResponseText(), httpClient.getResponseText().length);
                    break;
                case 4:
                    httpClient.defaultHTTPHandler.onFinally(httpClient, httpClient.getResponseText());
                    break;
            }
        } catch (e) {
            if (httpClient.throwExceptionWhenEverIsException) {
                throw e.message;
            }
        }
    };
    // Init

    try {
        this.requestObject = new XMLHttpRequest();
    } catch (e) {
        var status = false;
        var implementation = 0;
        while (status || implementation > this.SUPPORTED_XMLHTTP_IMPLEMENTATIONS.length) {
            try {
                this.requestObject = new ActiveXObject(this.SUPPORTED_XMLHTTP_IMPLEMENTATIONS[implementation]);
                status = true;
            } catch (e) {
            }
            implementation++;
        }
        if (!status) {
            throw 'Can\'t create object XMLHttpRequest.';
        }
    }

    this.requestObject.httpClient = this;
}

/**
 * 
 * 
 * @returns {HTTPRequestQueue}
 */
function HTTPRequestQueue() {
    this.requests = new Array();

    this.add = function(url, method, httpParams, callback) {
        this.requests[this.requests.length] = new HTTPRequest(url, method, httpParams, callback);
        return this.requests.length;
    };

    this.last = function() {
        if (this.size() > 0) {
            var request = new HTTPRequest(this.requests[this.requests.length - 1].url, this.requests[this.requests.length - 1].method, this.requests[this.requests.length - 1].httpParams);
            this.requests.pop();
            return request;
        } else {
            return null;
        }
    };

    this.size = function() {
        return this.requests.length;
    };

    this.first = function() {
        if (this.size() > 0) {
            var request = new HTTPRequest(this.requests[0].url, this.requests[0].method, this.requests[0].httpParams);
            this.requests.shift();
            return request;
        } else {
            return null;
        }
    };
}

/**
 * 
 * @returns {HTTPParams}
 */
function HTTPParams() {
    this.objects = new Array();

    function Pair(key, value) {
        this.key = key;
        this.value = value;
    }

    this.add = function(key, value) {
        this.objects.push(new Pair(key, value));
    };

    this.toString = function() {
        var collection = '', i;
        for (i = 0; i < this.objects.length - 1; i++) {
            collection += this.objects[i].key + '=' + this.encode(this.objects[i].value) + '&';
        }
        if (this.objects.length > 0) {
            collection += this.objects[i].key + '=' + this.encode(this.objects[i].value);
        }
        return collection;
    };

    this.size = function() {
        return this.toString().length;
    };

    this.encode = function(str) {
        return encodeURIComponent(str).replace(/~/g, '%7E').replace(/\'/g, '%27').replace(/!/g, '%21').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/\ /g, '%20');
    };
}
/**
 * 
 * @returns {HTTPHeaders}
 */
function HTTPHeaders() {
    this.objects = new Array();

    function HeaderRecord(key, value) {
        this.key = key;
        this.value = value;
    }

    this.add = function(key, value) {
        this.objects.push(new HeaderRecord(key, value));
    };

    this.toArray = function() {
        return this.objects;
    };

    this.size = function() {
        return this.objects.length;
    };
}

function HTTPRequest(url, method, httpParams) {
    this.url = url;
    this.method = method;
    this.httpParams = httpParams;
}

