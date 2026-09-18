<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script type="text/javascript" src="website/js/jquery.js"></script>
        <script type="text/javascript" src="photobooth.js"></script>
        <!--<script type="text/javascript" src="website/js/script.js"></script>-->
        <!--<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>-->
        <link type="text/css" rel="stylesheet" media="screen" href="website/css/page.css" />


        <title>Image Settings</title>
        <style>
            #divPhotoSettings{
                height: 300px;
            }

            body, html {
                height: 0%;
            }
        </style>
        <script>
            var filename = "2009-11-11";
            var foldername = "userJSON";
            function loadInitialCanvas(imgtitle, foldername) {
                $('#divPhotoSettings').photobooth().on("image", function (event, dataUrl) {
                    //$("#gallery").show().html('<img src="' + dataUrl + '" >');


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


                        }
                    };

                    xhr.onload = function () {
                        debugger;
                        console.log("after load");
                        if (file_exists("../../../../../ID/documents/" + foldername + "/" + imgtitle + ".png")) {
                            parent.$("#imgempPic,#emp_pic img").removeAttr('src');
                            parent.$("#imgempPic,#emp_pic img").attr("src", "../../../../../ID/documents/" + foldername + "/" + imgtitle + ".png" + "?time=" + new Date());
                        } else {
                            parent.$("#imgempPic,#emp_pic img").removeAttr('src');
                            parent.$("#imgempPic,#emp_pic img").attr("src", '../../../../../ID/documents/' + foldername + '/nopic.png' + "?time=" + new Date());
                        }

//                            
                        parent.$('div[aria-labelledby$="frmBrowserFromCamera"] span[class="ui-icon ui-icon-closethick"]').click();

                    };
                    xhr.open('POST', 'photosave.php', false);
                    xhr.send(fd);





                });
				$( '#divPhotoSettings' ).data( "photobooth" ).resize( 640, 480 );
                $('#divPhotoSettings ul li:eq(3)').click() //opacity: 1;left: 2px;top: 2px;width: 436px;height: 297px;
//                $('div[class="resizehandle"]').css({'opacity': '1', 'left': '2px', 'top': '2px'})
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
                //loadInitialCanvas(filename, foldername);
//                $('#divPhotoSettings div[class="photobooth"]').css({'width': '550px', 'height': '400'});
//                $('#divPhotoSettings div[class="photobooth"] canvas').attr('width', '550').attr('height', '400');
                onresize = function () {

                };

            });
        </script>

    </head>
    <body>

        <div id="wrapper">			
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