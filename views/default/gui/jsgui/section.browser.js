var SectionForm = (function(vcode,vname,ecode,ename,divCode,depCode){
    this.values = {};
    this.frame = $("<div>",{
        id: "_div-dialog-browser_",
        style: 'display: none;'
    });
    this.content  = "<div class='container'>" +
        "<div style='clear:both;height: 20px;'>" +
        "</div><div class='row-fluid'>" +
        "<div class='col-xs-12' style='padding: 0px;'>" +
        "<input type='text' class='form-control' id='_txt-input-search_' placeholder='Search Section'>"+
        "</div>" +
        "</div>" +
        "<div style='clear:both;height: 10px;'></div><div class='row'>" +
        "<div class='col-xs-12'>" +
        "<div id='-div-dialog-section-list'>" +
        "<table id='_table-dialog-section-list_'></table>"+
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
        var id = $("div#_div-dialog-browser_ table#_table-dialog-section-list_").getGridParam('selrow');

        if(id==null){
            msgBox("No item selected!","System Message","stop","ok",270,240,function(v){
                return false;
            });
            return false;
        }else{
            var rv = $("div#_div-dialog-browser_ table#_table-dialog-section-list_").getRowData(id);
            vcode = rv["sec_code"];
            vname = rv["sec_name"];
            $("div#_div-dialog-browser_").dialog('close');
        }
    });

    $("div#_div-dialog-browser_ input#_txt-input-search_").keyup(event,function(){
        $("div#_div-dialog-browser_ table#_table-dialog-section-list_").setGridParam({
            postData: {
                ACTION: 'loadListSection',
                GETPARAM:{
                    _searchKey: $("#_txt-input-search_").val(),
                    _isActive: 1,
                    _departmentCode: depCode,
                    _divisionCode: divCode
                },
                TYPE: 'BROWSER'
            }
        }).trigger('reloadGrid');
    });

    $("div#_div-dialog-browser_").dialog('close');
    $("div#_div-dialog-browser_").dialog({
        title: 'Section Browser',
        width: 950,
        height: 600,
        autoOpen: true,
        modal: true,
        resizable: true,
        open: function(){
            $(this).find('input').val('');
            $("div#_div-dialog-browser_ table#_table-dialog-section-list_").jqGrid('GridUnload');
            $("div#_div-dialog-browser_ table#_table-dialog-section-list_").jqGrid({
                url: '../../../models/mod.ntchrms.common.browser.php',
                datatype: 'json',
                async: false,
                mtype: 'GET',
                postData: {
                    ACTION: 'loadListSection',
                    GETPARAM:{
                        _searchKey: $("#_txt-input-search_").val(),
                        _isActive: 1,
                        _departmentCode: depCode,
                        _divisionCode: divCode
                    },
                    TYPE: 'BROWSER'
                },
                colModel:[
                    {
                        name: 'sec_code',
                        index: 'sec_code',
                        hidden: false,
                        label:"Section Code"
                    },
                    {
                        name: 'sec_name',
                        index: 'sec_name',
                        hidden: false,
                        width: 260,
                        label: "Section Name"
                    },
                    {
                        name: 'is_active',
                        index: 'is_active',
                        hidden:false,
                        width: 63,
                        label: "IsActive",
                        edittype: 'checkbox',
                        editoptions: {value: '1:0', defaultValue: '0'},
                        formatoptions: {disabled: false},
                        formatter: function(cellvalue, options, rowObject) {
                            var chkID = "Row" + options.rowId + "is_active";
                            var chkValue = (cellvalue == 1 ? "checked='checked'" : "");
                            return '<input id="' + chkID + '" type="checkbox"' + chkValue + ' disabled value = "' + cellvalue + '" offval="0">';
                        },
                        unformat: function(cellvalue, options, cell) {
                            return $("input:checkbox", cell).prop("checked") ? 1 : 0;
                        },
                        align: 'center'
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
                sortname: 'sec_name',
                multiboxonly: false,
                viewrecords: true,
                footerrow: false,
                userDataOnFooter: false,
                onSelectRow: function(id){
                },
                ondblClickRow: function(id){
                    var rv = $(this).getRowData(id);
                    vcode = rv["sec_code"];
                    vname = rv["sec_name"];
                    $("div#_div-dialog-browser_").dialog('close');
                }
            });
        },
        close: function(){
            if($.trim(vcode) != ""){
                $("#"+ecode).val(vcode);
                $("#"+ename).val(vname);
            }
            $(this).remove();
        }
    });
});