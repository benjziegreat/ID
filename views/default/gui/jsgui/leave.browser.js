var Leave = (function(_objVariables_,_objElements_,isGrid,tblOptions_){
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
        "<div id='-div-dialog-leave-list'>" +
        "<table id='_table-dialog-leave-list_'></table>"+
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
        var id = $("div#_div-dialog-browser_ table#_table-dialog-leave-list_").getGridParam('selrow');

        if(id==null){
            msgBox("No item selected!","System Message","stop","ok",270,240,function(v){
                return false;
            });
            return false;
        }else{
            var rv = $("div#_div-dialog-browser_ table#_table-dialog-leave-list_").getRowData(id);
            $.each(rv,function(k,v){
                _objVariables_[k]=v;
            });
            $("div#_div-dialog-browser_").dialog('close');
        }
    });

    $("div#_div-dialog-browser_ input#_txt-input-search_").keyup(event,function(){
        $("div#_div-dialog-browser_ table#_table-dialog-leave-list_").setGridParam({
            postData: {
                ACTION: 'loadListLeave',
                GETPARAM:{
                    _searchKey: $("#_txt-input-search_").val()
                }
            }
        }).trigger('reloadGrid');
    });

    $("div#_div-dialog-browser_").dialog('close');
    $("div#_div-dialog-browser_").dialog({
        title: 'Leave Browser',
        width: 950,
        height: 600,
        autoOpen: true,
        modal: true,
        resizable: true,
        open: function(){
            $(this).find('input').val('');
            $("div#_div-dialog-browser_ table#_table-dialog-leave-list_").jqGrid('GridUnload');
            $("div#_div-dialog-browser_ table#_table-dialog-leave-list_").jqGrid({
                url: '../../../models/mod.ntchrms.common.browser.php',
                datatype: 'json',
                async: false,
                mtype: 'GET',
                postData: {
                    ACTION: 'loadListLeave',
                    GETPARAM:{
                        _searchKey: $("#_txt-input-search_").val()
                    },
                    TYPE: 'BROWSER'
                },
                colModel:[
                    {
                        name: 'leave_code',
                        index: 'leave_code',
                        hidden: true,
                        width: 100
                    },
                    {
                        name: 'leave_name',
                        index: 'leave_name',
                        hidden: false,
                        width: 260,
                        label: "Leave NameEN"
                    },
                    {
                        name: 'leave_jap_name',
                        index: 'leave_jap_name',
                        hidden: true
                    },
                    {
                        name: 'leave_type',
                        index: 'leave_type',
                        hidden: false,
                        width: 100,
                        label: "Leave Type",
                        formatter:function(v){
                            return v==1?"With Pay":"Without Pay";
                        },
                        unformat:function(v){
                            return $.trim(v)=='With Pay'?1:0;
                        },
                        align:'center'
                    },
                    {
                        name: 'leave_credit',
                        index: 'leave_credit',
                        hidden: true,
                        width: 100,
                        label: "Leave Credit"
                    },
                    {
                        name: 'IsActive',
                        index: 'IsActive',
                        hidden:false,
                        width: 63,
                        label: "IsActive",
                        edittype: 'checkbox',
                        editoptions: {value: '1:0', defaultValue: '0'},
                        formatoptions: {disabled: false},
                        formatter: function(cellvalue, options, rowObject) {
                            var chkID = "Row" + options.rowId + "IsActive";
                            var chkValue = (cellvalue == 1 ? "checked='checked'" : "");
                            return '<input id="' + chkID + '" type="checkbox"' + chkValue + ' disabled value = "' + cellvalue + '" offval="0">';
                        },
                        unformat: function(cellvalue, options, cell) {
                            return $("input:checkbox", cell).prop("checked") ? 1 : 0;
                        },
                        align: 'center'
                    },
                    {
                        name: 'ModifiedByName',
                        index: 'ModifiedByName',
                        hidden: false,
                        width: 155,
                        label: "ModifiedBy"
                    },
                    {
                        name: 'LastModified',
                        index: 'LastModified',
                        hidden: false,
                        width: 149,
                        label: "LastModified"
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
                sortname: 'leave_code',
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
            console.log(tblOptions_["tbl"]);
            if(isGrid){
                $("#"+tblOptions_["tbl"]).setCell(tblOptions_["row"],_objElements_[0],_objVariables_["leave_code"]);
                $("#"+_objElements_[1]).val(_objVariables_["leave_name"]);
                console.log($("#"+tblOptions_["tbl"]).getRowData());
            }else{
                $.each(_objElements_,function(k,v){
                    if(_objVariables_[$.trim(v).replace(/(txt|chk)/ig,'')] != ""){
                        if(v.match(/chk/ig) !=null){
                            $("#"+v).attr('checked',parseInt(_objVariables_[$.trim(v).replace(/chk/ig,'')])==1);
                        }else{
                            $("#"+v).val(_objVariables_[$.trim(v).replace(/txt/ig,'')]);
                        }
                    }
                });
            }
            $(this).remove();
        }
    });
});