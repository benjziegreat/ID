
function doUpdateCategoryList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update category list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateCategoryMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update category list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdatePositionList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update position list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigratePositionMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update position list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateEmployeeList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update employee list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateEmployeeMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update employee list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateBranchList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update branch list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateBranchMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update branch list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateContractorList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update contractor list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateContractorMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update contractor list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateServiceList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update service list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateServiceMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update service list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateShippingCompanyList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update shipping company list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateShippingCompanyMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update shipping company list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateStockAccGroupMasterList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update stock accessories group list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateStockAccessoriesGroupMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update stock accessories group list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateStockMasterList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update stock master list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateStockMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update stock master list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateStockGroupList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update stock group list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateStockGroup&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update stock group list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateStockGroupingList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update stock grouping list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateStockGrouping&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update stock grouping list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateDROrderControllerList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update DR Order Controller list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateDROrderController&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update DR Order Controller list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateCustomerList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update Customer Master list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateCustomerMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update Customer Master list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateAgariServicesList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update Agari Services list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateAgariServicesMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update Agari Services list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateAgariMasterList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update Agari Master list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateAgariServicesMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update Agari Master list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}

function doUpdateAgariAcquiredServicesMasterList(event){
    
    if (event.ctrlKey){
        return;
    }
    
    if (confirm("This will start update Acquired Agari Services Master list. Do you want to continue?")){

        $.ajax({
            url:"../../../models/mod.datamigrator.php?ACTION=MigrateAgariAcquiredServicesMaster&GETRETURN=1",
            type:"POST",
            success: function(jsonReturn){
                if (jsonReturn == "Success"){
                    alert("Finish update Acquired Agari Services Master list.");
                }
                else{
                    alert("Error saving record! Please contact your system administrator for assistance.");
                }
            },
            async: false
        });
        
    }
}
