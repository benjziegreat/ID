var NGC_CUSTOM_EXPORT = (function(options){
    var ul = "<div><ul>";
    var vld = true;
    if($.trim(options.COLUMNS)==""){
        ul += "<li>Column Names</li>";
        vld = false;
    }
    if($.trim(options.QUERY)==""){
        ul += "<li>Query for Export</li>";
        vld = false;
    }
    if($.trim(options.DATABASE)==""){
        ul += "<li>Database</li>";
        vld = false;
    }
    if($.trim(options.HOST)==""){
        ul += "<li>Server</li>";
        vld = false;
    }
    if($.trim(options.USER)==""){
        ul += "<li>username</li>";
        vld = false;
    }
    if($.trim(options.PASSWORD)==""){
        ul += "<li>password</li>";
        vld = false;
    }
    if($.trim(options.COLUMNS_FORMATS)==""){
        ul += "<li>Column Formats('String' or 'Number')</li>";
        vld = false;
    }
    if($.trim(options.COLUMNS_TOTAL)==""){
        ul += "<li>is Columns has Totals?(true or false)</li>";
        vld = false;
    }
    if($.trim(options.ACTION)==""){
        ul += "<li>ACTION</li>";
        vld = false;
    }
    if($.trim(options.WORKSHEET_NAME)==""){
        ul += "<li>WORKSHEET NAME</li>";
        vld = false;
    }
    if(!vld){
        msgBox(ul,"Please supply the following...","stop","ok",0,0,function(val){
            if(val==1){
                return;
            }
        })
        return;
    }else{
        var frm = "<form id='frmDownload' ACTION='"+options.ACTION+"' method='POST' style='display: none;'>";
        frm += "<input type='hidden' name='COLUMNS' value='"+JSON.stringify(options.COLUMNS)+"'>";
        frm += '<input type="hidden" name="QUERY" value="'+options.QUERY+'">';
        frm += "<input type='hidden' name='DATABASE' value='"+options.DATABASE+"'>";
        frm += "<input type='hidden' name='HOST' value='"+options.HOST+"'>";
        frm += "<input type='hidden' name='USER' value='"+options.USER+"'>";
        frm += "<input type='hidden' name='PASSWORD' value='"+options.PASSWORD+"'>";
        frm += "<input type='hidden' name='COLUMNS_FORMATS' value='"+JSON.stringify(options.COLUMNS_FORMATS)+"'>";
        frm += "<input type='hidden' name='COLUMNS_TOTAL' value='"+JSON.stringify(options.COLUMNS_TOTAL)+"'>";
        frm += "<input type='hidden' name='WORKSHEET_NAME' value='"+options.WORKSHEET_NAME.substring(0,30)+"'>";
        frm += "<input type='hidden' name='HEADERS' value='"+JSON.stringify(options.HEADERS)+"'>";
        frm += "<input type='hidden' name='ALIGNMENTS' value='"+JSON.stringify(options.ALIGNMENTS)+"'>";
        frm += "<input type='hidden' name='COLUMNWIDTH' value='"+JSON.stringify(options.COLUMNWIDTH)+"'>";
        frm += "<input type='hidden' name='CONTENT_TEXT_COLOR' value='"+options.CONTENT_TEXT_COLOR+"'>";
        frm += "<input type='hidden' name='CONTENT_BACKGROUND_COLOR' value='"+options.CONTENT_BACKGROUND_COLOR+"'>";
        frm += "<input type='hidden' name='HEADER_BACKGROUND_COLOR' value='"+options.HEADER_BACKGROUND_COLOR+"'>";
        frm += "<input type='hidden' name='HEADER_TEXT_COLOR' value='"+options.HEADER_TEXT_COLOR+"'>";
        frm += "<input type='hidden' name='AUTOFILTER' value='"+options.AUTOFILTER+"'>";
        frm += "<input type='hidden' name='LETTERFREEZ' value='"+options.LETTERFREEZ+"'>";
        frm += "<input type='hidden' name='VALUE_BLANK' value='"+options.VALUE_BLANK+"'>";
        frm += "<input type='hidden' name='VALUE_COLOR' value='"+JSON.stringify(options.VALUE_COLOR)+"'>";
        frm += "<input type='hidden' name='VALUE_COLOR_NAME' value='"+options.VALUE_COLOR_NAME+"'>";
        frm += "<input type='hidden' name='HAS_COLOR_CONDITION' value='"+options.HAS_COLOR_CONDITION+"'>";
        frm += "<input type='hidden' name='VALUE_COLOR_BLANK' value='"+options.VALUE_COLOR_BLANK+"'>";
        frm += "<input type='hidden' name='FILE_NAME' value='"+options.FILE_NAME+"'>";
        frm += "<input type='submit' value='submit'>";
        frm += "</form>";

        $("body").append(frm);

        $("#frmDownload").submit();
        $("#frmDownload").remove();
    }
});
