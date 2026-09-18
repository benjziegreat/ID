<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!--<script type="text/javascript" src="website/js/jquery.js"></script>-->
        <script type="text/javascript" src="../miniscanner/jquery-1.11.0.js"></script>
        <script type="text/javascript" src="photobooth_minscanner.js"></script>
        <!--<script type="text/javascript" src="website/js/script.js"></script>-->
        <!--<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>-->
        <link type="text/css" rel="stylesheet" media="screen" href="website/css/page.css" />


        <title>Image Settings</title>
        <style>
            #divPhotoSettings{
                height:500px;
                width:1240px;

            }


            body, html {
                height: 0%;
            }
            .noWebcam{display: none;}
        </style>
        <script>
            var filename = "2009-11-1d1";
            var foldername = "userJSON";
            function loadInitialCanvas(imgtitle, foldername) {
                $('#divPhotoSettings').photobooth().on("image", function (event, dataUrl) {
//                    $("#gallery").show().html('<img src="' + dataUrl + '" >');


                    document.getElementById('img_val').value = dataUrl;
                    document.getElementById('img_filename').value = imgtitle;
                    document.getElementById('img_foldername').value = foldername;

                    var fd = new FormData(document.forms["form1"]);

                    var xhr = new XMLHttpRequest();


                    xhr.upload.onprogress = function (e) {
                        if (e.lengthComputable) {
                            var percentComplete = (e.loaded / e.total) * 100;
                            console.log(percentComplete + '% uploaded');
//                    console.log(e);
                            // alert('Succesfully uploaded');
                            // $('#divPhotoSettings').data("photobooth").destroy();
//                             debugger;

                        }
                    };

                    xhr.onload = function () {
                        debugger;
                        console.log("After load");
                        if (file_exists("../../../../../ID/documents/" + foldername + "/" + imgtitle + ".png")) {
                            parent.$('div[id="emp_signature"] img').removeAttr('src');
                            parent.$('div[id="emp_signature"] img').attr("src", "../../../../../ID/documents/" + foldername + "/" + imgtitle + ".png" + "?time=" + new Date());
                        } else {
                            parent.$('div[id="emp_signature"] img').removeAttr('src');
                            parent.$('div[id="emp_signature"] img').attr("src", '../../../../../ID/documents/' + foldername + '/nopic.png' + "?time=" + new Date());
                        }

// //                            
                        parent.$('div[aria-labelledby$="frmBrowserFromDevice"] span[class="ui-icon ui-icon-closethick"]').click();

                    };
                    xhr.open('POST', 'photosavesignature.php', true);
                    xhr.send(fd);



                }).load(function () {
                    console.log('sdfsdfsdf');
                });
                $('#wrapper').focus();
                // title="If image not loaded in Display area; just click here and scan again."
                $('#divPhotoSettings div[class="blind"]').attr('title', "If image not loaded just click here and scan again.");
            }
            function file_exists(url) {
//        console.log(url);
                // http://kevin.vanzonneveld.net
                // +   original by: Enrique Gonzalez
                // +      input by: Jani Hartikainen
                // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // %        note 1: This function uses XmlHttpRequest and cannot retrieve resource from different domain.
                // %        note 1: Synchronous so may lock up browser, mainly here for study purposes.
                // *     example 1: file_exists('http://kevin.vanzonneveld.net/pj_test_supportfile_1.htm');
                // *     returns 1: '123'
                var req = this.window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
                if (!req) {
                    throw new Error('XMLHttpRequest not supported');
                }

                // HEAD Results are usually shorter (faster) than GET

                req.open('HEAD', url, false);
                req.send(null);
                if (req.status == 200) {
                    return true;
                }

                return false;
            }

            $(document).ready(function () {
                debugger;
                //loadInitialCanvas(filename, foldername);

//                if ($('#divPhotoSettings').data("photobooth").isSupported)
//                {
//                    console.log('sdfsdf');
//                    $('div[id="divPhotoSettings"] canvas').attr('id', 'my_canvas').attr('width', '470').attr('height', '300');
//
//                    $('div[class="warning noWebcam"]').css('display', 'none');
//
//                }

//                CLIPBOARD_CLASS("my_canvas", true);

                /**
                 * image pasting into canvas
                 * 
                 * @param string canvas_id canvas id
                 * @param boolean autoresize if canvas will be resized
                 */

//                $('#divPhotoSettings div[class="photobooth"]').css({'width': '550px', 'height': '400'});
//                $('#divPhotoSettings div[class="photobooth"] canvas').attr('width', '550').attr('height', '400');

                onresize = function () {
                    $('div[class="photobooth"]').css({'width': $(window).width() - 100, 'height': $(window).width() - ($(window).width() * .550)});
                };

            });
            function CLIPBOARD_CLASS(canvas_id, autoresize) {
                var _self = this;
                var canvas = document.getElementById(canvas_id);
                var ctx = document.getElementById(canvas_id).getContext("2d");
                var ctrl_pressed = false;
                var reading_dom = false;
                var text_top = 15;
                var pasteCatcher;
                var paste_mode;

                //handlers
                document.addEventListener('keydown', function (e) {
                    _self.on_keyboard_action(e);
                }, false); //firefox fix
                document.addEventListener('keyup', function (e) {
                    _self.on_keyboardup_action(e);
                }, false); //firefox fix
                document.addEventListener('paste', function (e) {
                    _self.paste_auto(e);
                }, false); //official paste handler

                //constructor - prepare
                this.init = function () {
                    //if using auto
                    if (window.Clipboard)
                        return true;

                    pasteCatcher = document.createElement("div");
                    pasteCatcher.setAttribute("id", "paste_ff");
                    pasteCatcher.setAttribute("contenteditable", "");
                    pasteCatcher.style.cssText = 'opacity:0;position:fixed;top:0px;left:0px;';
                    //  pasteCatcher.style.marginLeft = "-20px";
                    // pasteCatcher.style.width = "10px";
                    document.body.appendChild(pasteCatcher);
                    document.getElementById('paste_ff').addEventListener('DOMSubtreeModified', function () {
                        if (paste_mode == 'auto' || ctrl_pressed == false)
                            return true;
                        //if paste handle failed - capture pasted object manually
                        if (pasteCatcher.children.length == 1) {
                            if (pasteCatcher.firstElementChild.src != undefined) {
                                //image
                                _self.paste_createImage(pasteCatcher.firstElementChild.src);
                            }
                        }
                        $('div[class="warning noWebcam"]').css('display', 'none');
                        //register cleanup after some time.
                        setTimeout(function () {
                            pasteCatcher.innerHTML = '';
                        }, 20);
                    }, false);
                }();
                //default paste action
                this.paste_auto = function (e) {
                    paste_mode = '';
                    pasteCatcher.innerHTML = '';
                    var plain_text_used = false;
                    if (e.clipboardData) {
                        var items = e.clipboardData.items;
                        if (items) {
                            paste_mode = 'auto';
                            //access data directly
                            for (var i = 0; i < items.length; i++) {
                                if (items[i].type.indexOf("image") !== -1) {
                                    //image
                                    var blob = items[i].getAsFile();
                                    var URLObj = window.URL || window.webkitURL;
                                    var source = URLObj.createObjectURL(blob);
                                    this.paste_createImage(source);
                                }
                            }
                            e.preventDefault();
                        } else {
                            //wait for DOMSubtreeModified event
                            //https://bugzilla.mozilla.org/show_bug.cgi?id=891247
                        }
                    }
                    $('div[class="warning noWebcam"]').css('display', 'none');
                };
                //on keyboard press - 
                this.on_keyboard_action = function (event) {
                    k = event.keyCode;
                    //ctrl
                    if (k == 17 || event.metaKey || event.ctrlKey) {
                        if (ctrl_pressed == false)
                            ctrl_pressed = true;
                    }
                    //c
                    if (k == 86) {
                        if (document.activeElement != undefined && document.activeElement.type == 'text') {
                            //let user paste into some input
                            return false;
                        }

                        if (ctrl_pressed == true && !window.Clipboard)
                            pasteCatcher.focus();
                    }
                };
                //on kaybord release
                this.on_keyboardup_action = function (event) {
                    k = event.keyCode;
                    //ctrl
                    if (k == 17 || event.metaKey || event.ctrlKey || event.key == 'Meta')
                        ctrl_pressed = false;
                };
                //draw image
                this.paste_createImage = function (source) {
                    var pastedImage = new Image();
                    pastedImage.onload = function () {
                        if (autoresize == true) {
                            //resize canvas
                            canvas.width = pastedImage.width;
                            canvas.height = 400;
                        } else {
                            //clear canvas
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                        }
                        ctx.drawImage(pastedImage, 0, 0);
                        $('div[class="photobooth"]').css({'width': pastedImage.width + 'px', 'height': pastedImage.height + 'px'});
//    $( '#divPhotoSettings' ).data( "photobooth" ).resize( pastedImage.width, pastedImage.height );    
                        $('div[class="warning noWebcam"]').css('display', 'none');



                        var imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        var pixels = imgData.data; // get pixel data
                        for (var i = 0; i < pixels.length; i += 4)
                        {
                            var r = pixels[i ];
                            var g = pixels[i + 1]
                            var b = pixels[i + 2];

                            if (r > 250 && g > 250 && b > 250) {
                                pixels[i + 3] = 0;
                                //count++;
                            }
                        }
                        ctx.putImageData(imgData, 0, 0);

                    };
                    pastedImage.src = source;
                };
            }
        </script>

    </head>
    <body>

        <div id="wrapper" style="    width: 90%;">			
            <div id="divPhotoSettings"></div>
            <div id="gallery" style="display:none;"></div>
            <div id="target" style="display:none;">
                <!-- Render your page inside of this div. -->
                <canvas id="canvas" class="pad-black"  ></canvas>
            </div>

            <form method="POST" accept-charset="utf-8" name="form1">
                <input type="hidden" name="img_val" id="img_val" value="" />
                <input type="hidden" name="img_filename" id="img_filename" value="" />
                <input type="hidden" name="img_foldername" id="img_foldername" value="" />
            </form>
            <!--
            <h2><a name="dataUrl">Storing dataUrls as image</a></h2>
            The user clicked the camera icon, your <code>onImage()</code> function get's called and receives a dataUrl... now what?

            <h3>In the Browser</h3>

            <h3>Sending the image to the server</h3>

            <h3>Storing the image on the server</h3>
            Storing your dataUrl as an image is easy when you know how. A dataUrl consists of two parts, seperated by a come: a meta-data section at 
            the start and the actual data

            <code>data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAA...</code>

            The String after the comma is base64 encoded binary data. So in order to save it as an image you need to

            1) Split the dataUrl on the first comma
            2) base64 decode the data ( emphasize on DECODE, not encode )
            Every major serverside language has a built in way of doing that. E.g.

            PHP 
            $dataUrlParts = explode( ",", $dataUrl);
            base64_decode( $dataUrlParts[ 1 ] );

            
            Node.js
            var dataUrl = "data:image/jpeg;base64,/9j/4AAQSkZJRgA...";
            var buffer = new Buffer( dataUrl.split( "," )[ 1 ], 'base64');
            require( "fs" ).writeFileSync( "image.jpg", buffer.toString( 'binary' ), "binary" );

            3) Save the result to a file and name it yourImage.png ( or jpeg, depending on the dataUrl type )
            -->
        </div>
        <script type="text/javascript" src="website/js/hijs.js"></script>

    </body>

</html>