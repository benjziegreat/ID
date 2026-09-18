<script>
    function popupDivIframe(event, div) {
        if (event.ctrlKey)
            return;

        $('html').find("#" + div).remove();
        $('html').append('<div id="' + div + '" style="display:none;"><div id="divIframeContainer"></div></div>');

        $('#' + div).dialog("destroy");
        $('#' + div).dialog("close");
        $('#' + div).dialog({
            title: '',
            autoOpen: false,
            resizable: true,
            width: '960px',
            height: 490,
            modal: true,
            open: function(event) {

                $(this).dialog('option', 'position', ['middle', 126]);
                $(this).focus();
                $("#divIframeContainer").contents().remove();
                var iframe = document.createElement('iframe');
                $(iframe).attr({
                    'src': 'http://nkym.com.ph/accessories.html',
                    'width': 800,
                    'height': 425
                });

                $('#divIframeContainer').append($(iframe));

            }
        });
        $('#' + div).show();
        $('#' + div).dialog("open");
    }

http://nkym.com.ph/nkymweb_previous/products_featuresA.php

http://nkym.com.ph/accessories.html

http://nkym.com.ph/sim_en/


    function popupDivIframe(event, div, link,title) {
        if (event.ctrlKey)
            return;

        $('html').find("#" + div).remove();
        $('html').append('<div id="' + div + '" style="display:none;"><div id="divIframeContainer"></div></div>');

        $('#' + div).dialog("destroy");
        $('#' + div).dialog("close");
        $('#' + div).dialog({
            title: title,
            draggable: true,
            autoOpen: false,
            resizable: true,
            width: '960px',
            height: 550,
            modal: true,
            open: function(event) {

                $(this).dialog('option', 'position', ['middle', 100]);
                $(this).focus();
                $('div[aria-labelledby*="divContainerPopup"][style*="display: block;"]').css('z-index','99999');
                $("#divIframeContainer").contents().remove();
                var iframe = document.createElement('iframe');
                $(iframe).attr({
                    'src': '' + link + '',
                    'width': 900,
                    'height': 450
                });

                $('#divIframeContainer').append($(iframe));

            }
        });
        $('#' + div).show();
        $('#' + div).dialog("open");
    }

    popupDivIframe('', 'divContainerPopup','http://nkym.com.ph/accessories.html','Product Features');


</script>