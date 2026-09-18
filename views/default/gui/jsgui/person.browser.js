var Person = (function(_objVariables_,_objElements_){
    this.values = {};
    this.frame = $("<div>",{
        id: "_div-dialog-browser_",
        style: 'display: none;'
    });
    this.content  = "<div class='container'>" +
        "<div style='clear:both;height: 20px;'>" +
        "</div><div class='row-fluid'>" +
        "<div class='col-xs-12' style='padding: 0px;'>" +
        "<input type='text' class='form-control' id='_txt-input-search_' placeholder='Search'>"+
        "</div>" +
        "</div>" +
        "<div style='clear:both;height: 10px;'></div><div class='row'>" +
        "<div class='col-xs-12'>" +
        "<div id='-div-dialog-person-list'>" +
        "<table id='_table-dialog-person-list_'></table>"+
        "</div>"+
        "</div>" +
        "</div>" +
        "<div style='clear:both;height: 20px;'></div><div class='row-fluid'>" +
        "<div class='col-xs-12 text-right' style='padding: 0px;'>" +
        "<button name='_btn-dialog-cancel_' class='btn btn-info btn-lg standard'><span class='glyphicon glyphicon-remove'></span><label>Cancel</label></button>"+
        "<button name='_btn-dialog-save_' class='btn btn-info btn-lg standard'><span class='glyphicon glyphicon-save'></span><label>Ok</label></button>"+
        "</div>" +
        "</div>" +
        "</div>";

    $("body").append(this.frame);

    $(this.frame).append(this.content);

    $("div#_div-dialog-browser_ button[name='_btn-dialog-cancel_']").click(event,function(){
        $("div#_div-dialog-browser_").dialog('close');
    });
    $("div#_div-dialog-browser_ button[name='_btn-dialog-save_']").click(event,function(){
        var id = $("div#_div-dialog-browser_ table#_table-dialog-person-list_").getGridParam('selrow');

        if(id==null){
            msgBox("No item selected!","System Message","stop","ok",270,240,function(v){
                return false;
            });
            return false;
        }else{
            var rv = $("div#_div-dialog-browser_ table#_table-dialog-person-list_").getRowData(id);
            $.each(rv,function(k,v){
                _objVariables_[k]=v;
            });
            $("div#_div-dialog-browser_").dialog('close');
        }
    });

    $("div#_div-dialog-browser_ input#_txt-input-search_").keyup(event,function(){
        $("div#_div-dialog-browser_ table#_table-dialog-person-list_").setGridParam({
            postData: {
                ACTION: 'loadListperson',
                GETPARAM:{
                    _searchKey: $("#_txt-input-search_").val()
                }
            }
        }).trigger('reloadGrid');
    });

    $("div#_div-dialog-browser_").dialog('close');
    $("div#_div-dialog-browser_").dialog({
        title: 'Person Browser',
        width: 950,
        height: 600,
        autoOpen: true,
        modal: true,
        resizable: true,
        open: function(){
            $(this).find('input').val('');
            $("div#_div-dialog-browser_ table#_table-dialog-person-list_").jqGrid('GridUnload');
            $("div#_div-dialog-browser_ table#_table-dialog-person-list_").jqGrid({
                url: '../../../models/mod.ntchrms.common.browser.php',
                datatype: 'json',
                async: false,
                mtype: 'GET',
                postData: {
                    ACTION: 'loadListperson',
                    GETPARAM:{
                        _searchKey: $("#_txt-input-search_").val()
                    },
                    TYPE: 'BROWSER'
                },
                colModel:[
                    {
                        name: 'EmpID',
                        index: 'EmpID',
                        hidden: false,
                        width: 100,
                        label:'EmpID'
                    },
                    {
                        name: 'EmpName',
                        index: 'EmpName',
                        hidden: false,
                        width: 260,
                        label: "EmpName"
                    },
                    {
                        name: 'l_name',
                        index: 'l_name',
                        hidden: true
                    },
                    {
                        name: 'f_name',
                        index: 'f_name',
                        hidden: true
                    },
                    {
                        name: 'm_name',
                        index: 'm_name',
                        hidden: true
                    },
                    {
                        name: 'date_hired',
                        index: 'date_hired',
                        hidden: false,
                        width: 149,
                        label: "DateHired"
                    }
                ],
                width: $(this).parent().width()-10,
                height: 350,
                jsonReader: {
                    repeatitems: false
                },
                cellsubmit: 'clientArray',
                autowidth: true,
                shrinkToFit: true,
                rownumbers: true,
                sortorder: 'ASC',
                sortname: 'EmpName',
                multiboxonly: false,
                viewrecords: true,
                footerrow: false,
                userDataOnFooter: false,
                onSelectRow: function(id){
                },
                ondblClickRow: function(id){
                    var rv = $(this).getRowData(id);
                    $.each(rv,function(k,v){
                        _objVariables_[k]=v;
                    });
                    $("div#_div-dialog-browser_").dialog('close');
                },
                loadComplete:function(){
                    var keys = $(this).getGridParam('colModel');
                    console.log("Your Object Elements Params must equal to the following...\n");
                    $.each(keys,function(k,v){
                        if(v.name != 'rn'){
                            console.log(v.name+"\n");
                        }
                    });
                }
            });
        },
        close: function(){
            $.each(_objElements_,function(k,v){
                if(_objVariables_[$.trim(v).replace(/(txt|chk)/ig,'')] != ""){
                    if(v.match(/chk/ig) !=null){
                        $("#"+v).attr('checked',parseInt(_objVariables_[$.trim(v).replace(/chk/ig,'')])==1);
                    }else{
                        $("#"+v).val(_objVariables_[$.trim(v).replace(/txt/ig,'')]);
                    }
                }
            });
            $(this).remove();
        }
    });
});