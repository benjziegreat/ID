<script type="text/javascript" src="jquery-2.1.0.js"></script>
<script language="javascript" type="text/javascript" src="jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.meterGaugeRenderer.min.js"></script>
<style>
    body{ background-color: #020202; }
    canvas{border:1px solid red;}
</style>
<script>
$(function(){
    var canvas=document.getElementById("canvas");
    var ctx=canvas.getContext("2d");
    var imageObj = new Image();
    imageObj.onload = function () {

        canvas.width=imageObj.width;
        canvas.height=imageObj.height;
        ctx.drawImage(imageObj, 0,0);

        var imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        var pixels = imgData.data; // get pixel data
        for (var i = 0; i < pixels.length; i +=4)
        {
            var r = pixels[i ];
            var g = pixels[i + 1]
            var b = pixels[i  + 2];

            if (r>250 && g>250 && b>250) {
                pixels[i + 3] = 0;
                //count++;
            }   
        }
        ctx.putImageData(imgData, 0, 0);
    }
    imageObj.src="2009-0418-5.png";

}); // end $(function(){});
</script>

</head>

<body>
    <canvas id="canvas" width=300 height=300></canvas>
</body>
</html>