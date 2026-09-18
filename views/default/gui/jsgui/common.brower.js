var DivisionForm = (function(div_code,div_name,obj_divCode,obj_divName){
    this.values = {};
    this.frame = $("<div>",{
        id: "_div-dialog-browser_",
        style: 'display: none;'
    });
    this.content  = "<div class='container'>" +
        "<div style='clear:both;height: 20px;'>" +
        "</div><div class='row-fluid'>" +
        "<div class='col-xs-12' style='padding: 0px;'>" +
        "<input type='text' class='form-control' id='_txt-input-search_' placeholder='Search Division'>"+
        "</div>" +
        "</div>" +
        "<div style='clear:both;height: 10px;'></div><div class='row'>" +
        "<div class='col-xs-12'>" +
        "<div id='-div-dialog-division-list'>" +
        "<table id='_table-dialog-division-list_'></table>"+
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
        var id = $("div#_div-dialog-browser_ table#_table-dialog-division-list_").getGridParam('selrow');
        if(id==null){
            msgBox("No item selected!","System Message","stop","ok",270,240,function(v){
                return false;
            });
            return false;
        }else{
            var rv = $("div#_div-dialog-browser_ table#_table-dialog-division-list_").getRowData(id);
            div_code=rv.div_code;
            div_name=rv.div_name;
            $("div#_div-dialog-browser_").dialog('close');
        }
    });

    $("div#_div-dialog-browser_ input#_txt-input-search_").keyup(event,function(){
        $("div#_div-dialog-browser_ table#_table-dialog-division-list_").setGridParam({
            postData: {
                ACTION: 'loadListDivision',
                GETPARAM:{
                    _searchKey: $("#_txt-input-search_").val(),
                    _isActive: 1
                }
            }
        }).trigger('reloadGrid');
    });

    $("div#_div-dialog-browser_").dialog('close');
    $("div#_div-dialog-browser_").dialog({
        title: 'Division Browser',
        width: 950,
        height: 600,
        autoOpen: true,
        modal: true,
        resizable: true,
        open: function(){
            $(this).find('input').val('');
            $("div#_div-dialog-browser_ table#_table-dialog-division-list_").jqGrid('GridUnload');
            $("div#_div-dialog-browser_ table#_table-dialog-division-list_").jqGrid({
                url: '../../../models/mod.ntchrms.common.browser.php',
                datatype: 'json',
                async: false,
                mtype: 'GET',
                postData: {
                    ACTION: 'loadListDivision',
                    GETPARAM:{
                        _searchKey: $("#_txt-input-search_").val(),
                        _isActive: 1
                    }
                },
                colModel:[
                    {
                        name: 'div_code',
                        index: 'div_code',
                        hidden: true
                    },
                    {
                        name: 'div_name',
                        index: 'div_name',
                        hidden: false,
                        width: 260,
                        label: "DivisionName"
                    },
                    {
                        name: 'ModifiedBy',
                        index: 'ModifiedBy',
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
                sortname: 'div_name',
                multiboxonly: false,
                viewrecords: true,
                footerrow: false,
                userDataOnFooter: false,
                onSelectRow: function(id){
                },
                ondblClickRow: function(id){
                    var rv = $(this).getRowData(id);
                    div_code=rv.div_code;
                    div_name=rv.div_name;
                    $("div#_div-dialog-browser_").dialog('close');
                }
            });
        },
        close: function(){
            if($.trim(div_code) !="" && $.trim(div_name) !=""){
                $("#"+obj_divCode).val(div_code);
                $("#"+obj_divName).val(div_name);
            }
            $(this).remove();
        }
    });

    this.getDivCode = (function(){
        return div_code;
    });
    this.getDivName = (function(){
        return div_name;
    });
});
var DepartmentForm = (function(dept_code,dept_name,obj_deptCode,obj_deptName,_searchKey){
    this.values = {};
    this.frame = $("<div>",{
        id: "_div-dialog-browser_",
        style: 'display: none;'
    });
    this.content  = "<div class='container'>" +
        "<div style='clear:both;height: 20px;'>" +
        "</div><div class='row-fluid'>" +
        "<div class='col-xs-12' style='padding: 0px;'>" +
        "<input type='text' class='form-control' id='_txt-input-search_' placeholder='Search Department'>"+
        "</div>" +
        "</div>" +
        "<div style='clear:both;height: 10px;'></div><div class='row'>" +
        "<div class='col-xs-12'>" +
        "<div id='-div-dialog-department-list'>" +
        "<table id='_table-dialog-department-list_'></table>"+
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
        var id = $("div#_div-dialog-browser_ table#_table-dialog-department-list_").getGridParam('selrow');

        if(id==null){
            msgBox("No item selected!","System Message","stop","ok",270,240,function(v){
                return false;
            });
            return false;
        }else{
            var rv = $("div#_div-dialog-browser_ table#_table-dialog-department-list_").getRowData(id);
            dept_code=rv.dept_code;
            dept_name=rv.dept_name;
            $("div#_div-dialog-browser_").dialog('close');
        }
    });

    $("div#_div-dialog-browser_ input#_txt-input-search_").keyup(event,function(){
        $("div#_div-dialog-browser_ table#_table-dialog-department-list_").setGridParam({
            postData: {
                ACTION: 'loadListDepartment',
                GETPARAM:{
                    _searchKey: $("#_txt-input-search_").val(),
                    _isActive: 1,
                    _divisionCode: _searchKey
                },
                TYPE: 'BROWSER'
            }
        }).trigger('reloadGrid');
    });

    $("div#_div-dialog-browser_").dialog('close');
    $("div#_div-dialog-browser_").dialog({
        title: 'Department Browser',
        width: 950,
        height: 600,
        autoOpen: true,
        modal: true,
        resizable: true,
        open: function(){
            $(this).find('input').val('');
            $("div#_div-dialog-browser_ table#_table-dialog-department-list_").jqGrid('GridUnload');
            $("div#_div-dialog-browser_ table#_table-dialog-department-list_").jqGrid({
                url: '../../../models/mod.ntchrms.common.browser.php',
                datatype: 'json',
                async: false,
                mtype: 'GET',
                postData: {
                    ACTION: 'loadListDepartment',
                    GETPARAM:{
                        _searchKey: $("#_txt-input-search_").val(),
                        _isActive: 1,
                        _divisionCode: _searchKey
                    },
                    TYPE: 'BROWSER'
                },
                colModel:[
                    {
                        name: 'div_code',
                        index: 'div_code',
                        hidden: true
                    },
                    {
                        name: 'div_name',
                        index: 'div_name',
                        hidden: true,
                        width: 260,
                        label: "DivisionName"
                    },
                    {
                        name: 'dept_code',
                        index: 'dept_code',
                        hidden: true
                    },
                    {
                        name: 'dept_name',
                        index: 'dept_name',
                        hidden: false,
                        width: 260,
                        label: "Department Name"
                    },
                    {
                        name: 'active',
                        index: 'active',
                        hidden:false,
                        width: 63,
                        label: "IsActive",
                        edittype: 'checkbox',
                        editoptions: {value: '1:0', defaultValue: '0'},
                        formatoptions: {disabled: false},
                        formatter: function(cellvalue, options, rowObject) {
                            var chkID = "Row" + options.rowId + "active";
                            var chkValue = (cellvalue == 1 ? "checked='checked'" : "");
                            return '<input id="' + chkID + '" type="checkbox"' + chkValue + ' disabled value = "' + cellvalue + '" offval="0">';
                        },
                        unformat: function(cellvalue, options, cell) {
                            return $("input:checkbox", cell).prop("checked") ? 1 : 0;
                        },
                        align: 'center'
                    },
                    {
                        name: 'ModifiedBy',
                        index: 'ModifiedBy',
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
                sortname: 'div_name',
                multiboxonly: false,
                viewrecords: true,
                footerrow: false,
                userDataOnFooter: false,
                onSelectRow: function(id){
                },
                ondblClickRow: function(id){
                    var rv = $(this).getRowData(id);
                    dept_code=rv.dept_code;
                    dept_name=rv.dept_name;
                    $("div#_div-dialog-browser_").dialog('close');
                }
            });
        },
        close: function(){
            if($.trim(dept_code) != "" && $.trim(dept_name) != ""){
                $("#"+obj_deptCode).val(dept_code);
                $("#"+obj_deptName).val(dept_name);
            }
            $(this).remove();
        }
    });

    this.getDeptCode = (function(){
        return dept_code;
    });
    this.getDeptName = (function(){
        return dept_name;
    });
});