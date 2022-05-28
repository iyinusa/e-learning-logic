
//'use strict';
(function(window) {

var globalConfigData;
var globalMeta;


window.addEventListener("message", function (d){ 
            if(d.data.name == "readytorecieve"){

                d.source.postMessage({name:"updategotten", meta:globalMeta},d.origin)
                  
        }
        }, false);


var globalClosePopup;
window.addEventListener("message", function (d){ 

            if(d.data.name == "allcontentloaded"){

                ////console.log('100299300394049', d.data);
                 document.body.removeChild( document.getElementsByClassName('spinner-container')[0]);
                 if(globalConfigData && globalConfigData.onopen){
                    globalConfigData.onopen();
                }

                function icheckNext(err, msg){
                    d.source.postMessage({name:"icheckcomplete", check_error:err, check_error_message:msg},d.origin);
                }
                if(globalConfigData && globalConfigData.onintegritycheck){

                    globalConfigData.onintegritycheck(d.data.hash, icheckNext);

                }else{
                    icheckNext();
                }

            }

            if(d.data.name == "charge_complete"){

                if(globalConfigData && globalConfigData.chargecomplete){
                    globalConfigData.chargecomplete(d.data.type,d.data.data); 
                }

            }


            if(d.data.name == "charge_init"){

                if(globalConfigData && globalConfigData.chargeinit){
                    globalConfigData.chargeinit(d.data.type,d.data.timestamp); 
                }

            }

    		if(d.data.name == "opop"){

                    //console.log(d, "OPOP MESSAGE");
    			    if(globalConfigData && globalConfigData.callback)
    				    globalConfigData.callback(d.data); 

                    if(globalConfigData && globalConfigData.redirect_url && d.data.success){
                        //console.log(globalConfigData);
                        if(globalConfigData.redirect_post){

                            document.body.innerHTML += '<form method="POST" id="redform"><textarea name="resp" id="json"></textarea></form>';
                            document.getElementById('redform').setAttribute('action', globalConfigData.redirect_url);
                            document.getElementById('json').value = JSON.stringify(d.data);
                            document.getElementById('redform').submit();
                        }
                        else{

                        if(globalConfigData.redirect_no_json){
                            window.location.href = globalConfigData.redirect_url;
                        }else{
                        //window.location.href = globalConfigData.redirect_url + "?resp=" + JSON.stringify(d.data);
                        document.body.innerHTML += '<form method="GET" id="redform"><textarea name="resp" id="json"></textarea></form>';
                            document.getElementById('redform').setAttribute('action', globalConfigData.redirect_url);
                            document.getElementById('json').value = JSON.stringify(d.data);
                            document.getElementById('redform').submit();
                        }

                        }
                    }
    	}
    	}, false);

         

        function closePopup(){

            if(document.getElementById('flwpugpaidid'))
                document.body.removeChild( document.getElementById('flwpugpaidid') );

            if(globalConfigData && globalConfigData.onclose){
                globalConfigData.onclose();
            }

        }
        globalClosePopup = closePopup;

    	window.addEventListener("message", function (d){ 
    		if(d.data.name == "closeiframe"){

    				closePopup();
    				 
    	}
    	}, false);


        window.addEventListener("message", function (d){ 
            if(d.data.name == "vbvcomplete"){

                    // var a = document.getElementById('OTPsubmit');
                     //a.setAttribute('href', d.data.authurl);
                     //a.setAttribute('target','blank_');
                     //a.click();
                     //window.open(d.data.authurl);
                     //console.log(d);
                     if(globalConfigData &&  globalConfigData.callback)
                        globalConfigData.callback(d.data);

                     if(globalConfigData && globalConfigData.redirect_url && (d.data.respcode == "00" || d.data.respcode == "0") ){
                       if(globalConfigData.redirect_post){

                            document.body.innerHTML += '<form method="POST" id="redform"><textarea name="resp" id="json"></textarea></form>';
                            document.getElementById('redform').setAttribute('action', globalConfigData.redirect_url);
                            document.getElementById('json').value = JSON.stringify(d.data);
                            document.getElementById('redform').submit();
                        }
                        else{
                         
                            if(globalConfigData.redirect_no_json){
                            window.location.href = globalConfigData.redirect_url;
                        }else{
                        //window.location.href = globalConfigData.redirect_url + "?resp=" + JSON.stringify(d.data);
                        document.body.innerHTML += '<form method="GET" id="redform"><textarea name="resp" id="json"></textarea></form>';
                            document.getElementById('redform').setAttribute('action', globalConfigData.redirect_url);
                            document.getElementById('json').value = JSON.stringify(d.data);
                            document.getElementById('redform').submit();
                        }

                        }
                     }
                     
        }
        }, false);

document.addEventListener("DOMContentLoaded", function(event) {
   // //console.log("DOM fully loaded and parsed");
     function generateQueryString(obj) {
    	var str = [];
    	for( var prop in obj )
    	{
    		if(obj.hasOwnProperty(prop) ) {
    			var v = obj[prop];
                v = encodeURIComponent(v);
    			str.push(prop + "=" + v);
    		}
    	}
    	return (str.join("&"));
    }



    function loadIframe (data) { 

        /*Show spinner*/
        var spinnerContainer = document.createElement('div');
        var spinner = document.createElement('div');
        spinnerContainer.setAttribute('class', 'spinner-container');
        spinner.setAttribute('class', 'spinner');
        spinnerContainer.appendChild(spinner);
        document.body.appendChild(spinnerContainer);

        var pageStyle = document.createElement('style');
        if(pageStyle)
        {
        pageStyle.appendChild( document.createTextNode('.spinner-container{height:100%;width:100%;position:fixed;top:0;left:0;background-color:rgba(0,0,0,.75); z-index:999}.spinner{width:40px;height:40px;margin-top:-20px; margin-left:-20px; position:fixed; top:50%; left:50%; background-color:#fff;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}') ); 
        document.getElementsByTagName('head')[0].appendChild(pageStyle);
        }




    	globalConfigData = data;
    	var getpaidiframe = document.createElement('iframe');
    	getpaidiframe.setAttribute('style', 'position:fixed; top:0; left:0; z-index:9999');
    	getpaidiframe.setAttribute('allowTransparency', 'true');
    	getpaidiframe.setAttribute('width', '100%');
    	getpaidiframe.setAttribute('height', '100%');  
    	getpaidiframe.setAttribute('id', 'flwpugpaidid'); 

    	var _data = JSON.parse( JSON.stringify( data) );
    	delete _data.callback;  //callback is not required as a query string to pass
    	delete _data.onclose;   //onclose is not required as a query string to pass
    	delete _data.onpaymentinit; 
    	delete _data.onvalidateotpinit;
        delete _data.meta;
        //delete _data.onintegritycheck;

    	getpaidiframe.src = 'https://api.ravepay.co/flwv3-pug/getpaidx/api/pbfui?' + generateQueryString(_data);
    	////console.log(getpaidiframe.outerHTML.replace(/amp;/g,''));
    	//ahref.appendChild(getpaidiframe);

        //Uncomment this later
    	//document.body.insertAdjacentHTML('afterbegin', getpaidiframe.outerHTML.replace(/amp;/g,''));

        /*
        setTimeout(function (){
 document.body.appendChild(getpaidiframe);
        }, 2000)*/
        document.body.appendChild(getpaidiframe);
       
        getpaidiframe.onload = function (){ 
           // document.body.removeChild( document.getElementsByClassName('spinner-container')[0]);
           //document.getElementsByClassName('spinner-container')[0].setAttribute('style', 'display:none');
        }
    }

    function extractAttributes(element, attributes) {
    	var obj = {};
    	attributes
    		.forEach( function (attrib){
    			var aa = element.getAttribute('data-'+attrib);
    			if(aa)
    			obj[attrib] = aa;
    		});
    	return obj;
    }

    function extractMetaInfo(element) {
        var attributes = element.attributes;
        var atrlen = attributes.length;
        var metas = [];
        for(var x = 0; x < atrlen; x++)
        {
            var attrib = attributes[x];
            if(attrib.name.match(/^data-meta-/)){
                metas.push(
                    {
                        metaname:attrib.name.replace('data-meta-', ''),
                        metavalue:attrib.value
                    }
                );
            }
        }

        //=== Handle sideffects\\
        x = null;
        atrlen = null;
        //======================\\
        return metas
    }

    var ahref = document.querySelector('.flwpug_getpaid');

    //if anchor tag exists .. 
   if(ahref){
    var iframeData = {};
    iframeData = extractAttributes(ahref, ['PBFPubKey', 'txref', 'amount', 'customer_email', 'customer_phone', 'customer_lastname', 'customer_firstname', 'currency', 'country', 'customer_fullname', 'callback', 'onclose', 'onvalidateotpinit', 'onpaymentinit', 'redirect_url','pay_button_text', 'custom_title', 'custom_description', 'custom_logo', 'default_account', 'payment_method', 'exclude_banks', 'settlement_token', 'recurring_stop', 'integrity_hash', 'redirect_post', 'redirect_no_json']);
    ////console.log(iframeData, "hello from iframeData");
    //iframeData.PBFPubKey = ahref.getAttribute('data-flwpugkey');
    //iframeData.txref = ahref.getAttribute('data-txref');
    //iframeData.amount = ahref.getAttribute('data-amount');
    //iframeData.customer_email = ahref.getAttribute('data-customer_email');
    globalMeta = extractMetaInfo(ahref);

    var paybutton = document.createElement('button');
    //paybutton.innerText = ahref.innerText || "PAY NOW";
    paybutton.innerText = iframeData.pay_button_text || "PAY NOW";
    ahref.innerText = "";

    paybutton.setAttribute('style', 'color:#fff;background-color:#0a2740;border-color:#142a3e;/*padding:10px;*/display:inline-block;padding:6px12px;margin-bottom:0;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1pxsolidtransparent;border-radius:4px;');

    paybutton.setAttribute('type','button');

    paybutton.addEventListener('click', function (e) {

    	/*
    	<iframe style="" allowTransparency="true" 
    	width="100%" height="100%" 
    	src="http://localhost:9329/flwv3-pug/getpaid/api?PBFPubKey=k983398abhsjd&txref=flwgp9930&amount=9900">
    	</iframe>
    	*/
    	 loadIframe(iframeData);

    });
    ahref.appendChild(paybutton);
    //ahref.insertAdjacentHTML('beforebegin', paybutton.outerHTML);
}

    window.getpaidSetup = function (config) {
        globalMeta = config.meta;
    	loadIframe (config);
        return {
            close:globalClosePopup
        }
    }

  });
})(window);


/*

var spinnerContainer = document.createElement('div');
var spinner = document.createElement('div');
spinnerContainer.setAttribute('class', 'spinner-container');
spinner.setAttribute('class', 'spinner');
spinnerContainer.appendChild(spinner);
document.body.appendChild(spinnerContainer);



<div class="spinner-container"><div class="spinner"></div></div>
*/

