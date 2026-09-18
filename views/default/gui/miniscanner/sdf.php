<script>
function LoadIDData(data) {
           
                    $('#idContainer').contents().remove();
            for (var i = 0; i < data.length; i++) {
            // console.log(data[i]);
            var fullname = data[i].fname.toString().toUpperCase() + ' ' + ($.trim(data[i].mname) == "." ? "" : data[i].mname.toString().toUpperCase().slice(0, 1) + ".") + ' ' + data[i].lname.toString().toUpperCase();
            var strDivID = '<div style="text-align:center;display:inline-block;" id="div_print_id' + i + '">\n\
                     <div style="width:auto;">\n\
                           <div id="_front" style="display:inline-block;border-right:black solid thin;   padding: 10px 20px 30px 20px;">\n\
                              <div id="div_img_id_front" style="border-radius:10px;border:#999 dashed 0.5px;width: 5.34cm;height: 8.35cm;position:relative;float:left;">\n\
                                  <img id="img_front" src="../../../../CJC_IDSYSTEM/documents/zzzIDSetupImage/Front'+data[i].setupid+'.png?' + new Date() + '" style="border-radius:5px;width: 5.30cm;height: 8.35cm;" alt="Emp ID">\n\
                                  <div id="emp_pic' + i + '" style="width: 95px;height:95px;top:0px;position:absolute;margin-top: 76px;right: 10px;text-align: center;">\n\
                                      <img src="../../../documents/EmployeePictures/' + data[i].emp_id + '.png" style="width: 95px;height: 95px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt="">\n\
                                  </div> \n\
                                  <div class="class_barcode' + i + '" style="top:0px;position:absolute;font-weight: bold;text-align: center;width: 100%;    margin-top: 233px;left: 0px;-webkit-transform: scale(1,0.9081);"> \n\
                                    <!-- <img id="barcode' + i + '" style="width: auto;height:auto;"/>-->\n\
                                      <img id="barcode' + i + '" style="width: 180px;height:25px;"/>   \n\
                                  </div> \n\
                                  <div id="emp_name' + i + '" style="top:0px;position:absolute;margin-top: 177px;font-weight: bold;margin-left: 0px;text-align: right;right: 1px; width: 80%; -webkit-transform: scale(0.89051,1.013570);"> \n\
                                     <span style="font-size:10px;">' + fullname + '</span>\n\
                                   </div> \n\
                                 <div id="emp_id' + i + '" style="top:0px;position:absolute;margin-top: 214.4px;font-weight: bold;text-align: left;left: 7px;width: 32%;font-size: 9px;-webkit-transform: scale(0.781,0.8950102570);">\n\
                                     <span style=" font-size: 11px;">' + data[i].emp_id + '</span> \n\
                                 </div> \n\
                                 <div id="emp_idtype' + i + '" style="top:0px;position:absolute;margin-top: 216.2px;font-weight: bold;text-align: center;left: 68px;font-size: 9px;width: 60%;-webkit-transform: scale(1.00516999,1.0140357);"> \n\
                                     <span>' + data[i].category + '</span>\n\
                                 </div> \n\
                                 <div id="emp_position' + i + '" style="top:0px;position:absolute;margin-top: 192px;font-weight: bold;margin-left: 0px;text-align: right;right: 1px; width: 80%; -webkit-transform: scale(0.89051,1.013570);"> \n\
                                     <span style="font-size:10px;" >' + padLeft(data[i].designation, fullname.length, " ") + '</span>\n\
                                 </div> \n\
                                 <div id="emp_pressignature' + i + '" style="display:none;top:0px;position:absolute;margin-top: 274px;/* margin-left: 83px; */text-align: center;width: 210px;">\n\
                                     <img src="../../../documents/PresidentSignature/PresidentSignature.png" style="width: 128px;height: 20px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> \n\
                                 </div> \n\
                                 <div id="emp_presidentname' + i + '" style="display:none;top:0px;position:absolute;margin-top: 293px;font-weight: bold;margin-left: 0px;text-align: center;width: 220px; -webkit-transform: scale(0.781,0.81570);">\n\
                                      <span style="color:#3d0b0c;font-size: 12px;">BR. ELLAKIM P. SOSMEÑA, S.C.</span> \n\
                                 </div> \n\
                                 <div id="emp_president' + i + '" style="display:none;top:0px;position:absolute;margin-top: 303px;font-weight: bold;text-align: center;width: 220px;-webkit-transform: scale(0.71,0.75);">\n\
                                      <span style=" font-size: 11px; color: #3d0b0c; "> President</span>\n\
                                 </div> \n\
                             </div>\n\
                          </div>\n\
                          <div id="_back" style="display: inline-block;    padding: 10px 0px 30px 20px;"> \n\
                             <div id="div_img_id_back" style="border-radius:10px;border:#999 dashed 0.5px;width: 5.34cm;height: 8.35cm;position:relative;float:right;"> \n\
                                <img id="img_back" src="../../../../CJC_IDSYSTEM/documents/zzzIDSetupImage/BACK'+data[i].setupid+'.png?' + new Date() + '" style="border-radius:5px;width: 5.30cm;height:8.35cm;" alt="Emp ID">\n\
                                 <div id="s_SSS' + i + '" style="position: absolute;top: 0;margin-top: 25px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175);font-weight: bold;"> <span>' + data[i].sssgsisno.toString() + '</span></div>\n\
                                 <div id="s_tinno' + i + '" style="position: absolute;top: 0;margin-top: 45px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>' + data[i].tinno.toString() + '</span></div>\n\
                                 <div id="s_philhealth' + i + '" style="position: absolute;top: 0;margin-top: 64px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>' + data[i].philno.toString() + '</span></div> \n\
                                <div id="s_birthdate' + i + '" style="position: absolute;top: 0;margin-top: 83px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;">  <span>' + data[i].birthdatevalue.toString() + '</span></div>\n\
                                 <div id="p_civil' + i + '' + i + '" style="position: absolute;top: 0;margin-top: 103px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>' + data[i].status.toString() + '</span></div>\n\
                                 <div id="s_mother' + i + '" style="position: absolute;top: 0;margin-top: 143px;left: -10px;font-size: 12px;width: 110%;text-align: left;-webkit-transform: scale(0.81,0.9175); font-weight: bold;"> <span>' + data[i].contact_guardian.toString().toUpperCase() + '</span></div>\n\
                                 <div id="p_address' + i + '" style="position: absolute; top: 0;margin-top: 157px; left:-10px; font-size: 11px; width: 110%; text-align: left; transform: scale(0.81, 0.9175); font-weight: bold;"> <span>' + data[i].contact_address.toString() + '</span></div>\n\
                                 <div id="p_cellno' + i + '" style="position: absolute; top: 0;margin-top:197px; left: 55px; font-size: 12px; width: 80%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span>' + data[i].contactno.toString() + ' </span></div>\n\
                                 <div id="emp_signature' + i + '" style="width: 100%;position: relative;top: 0;margin-top: -56px;-webkit-transform: scale(0.91,0.975); font-weight: bold;">\n\
                                     <img src="../../../documents/EmployeeSignature/' + data[i].emp_id + '.png?Thu Sep 03 2015 21:51:26 GMT-0700 (Pacific Daylight Time)" style="width: 160px;height: 35px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> \n\
                                 </div> \n\
                            </div>\n\
                         </div> \n\
                      </div> \n\
                  </div>';
                     $('#idContainer').append(strDivID);
                     $('img[id="barcode' + i + '"]').map(function(index, elem) {
                     $(elem).JsBarcode(data[i].emp_id, {width: 1, height: 50, displayValue: false, fontSize: 14, format: 'CODE39', font:"Arial,sans-serif"});
                              $(elem).css({"width":"171px", "height":"26px"});
                      });
                    if (file_exists("../../../documents/EmployeePictures/" + data[i].emp_id + ".png")) {
                             $('#emp_pic' + i + ' img').attr("src", '../../../documents/EmployeePictures/' + data[i].emp_id + ".png" + "?time=" + new Date());
                    } else {
                        //Picture not exist.
                        $('#emp_pic' + i + ' img').attr("src", '../../../documents/EmployeePictures/nopic.png' + "?time=" + new Date());
                    }
                     if (file_exists("../../../documents/EmployeeSignature/" + data[i].emp_id + ".png")) {
                        $('#emp_signature' + i + ' img').attr("src", '../../../documents/EmployeeSignature/' + data[i].emp_id + ".png" + "?time=" + new Date());
                    } else {
                        //Picture not exist.
                        $('#emp_signature' + i + ' img').attr("src", '../../../documents/EmployeeSignature/nopic.png' + "?time=" + new Date());
                    }
//                    $('div[id="s_mother' + i + '"]').map(function(index, elem) {
//                        fitTextInBox(elem);
//                    });
                }
               loadXYSetupID(data);
             
            }
            </script>