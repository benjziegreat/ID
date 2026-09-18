<?php

//THIS IS FOR DEVELOPMENT BY NELSON GABRIEL CAñete
set_time_limit(0);
ini_set('memory_limit', '8249M');

class N_EXPORT_EXCEL {

    public function __construct() {
        
    }

    public function N_WORKBOOK() {
        echo '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";
    }

    public function N_WORKBOOK_CLOSE() {
        echo '</Workbook>';
    }

    public function N_DOCUMENT_PROPERTIES($props) {
        if ($props == '') {
            echo '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
						  <Author>Nelson Gabriel Cañete</Author>
						  <LastAuthor>Nelson Gabriel Cañete</LastAuthor>
						  <Created>2014-08-07T20:46:06Z</Created>
						  <LastSaved>2014-08-10T07:40:23Z</LastSaved>
						  <Company>Nakayama Technology Corporation</Company>
						  <Version>12.00</Version>
						 </DocumentProperties>
				' . "\n";
        } else {
            $this->PROP_Author = $props["Author"];
            $this->PROP_LastAuthor = $props["LastAuthor"];
            $this->PROP_Created = $props["Created"];
            $this->PROP_LastSaved = $props["LastSaved"];
            $this->PROP_Company = $props["Company"];
            $this->PROP_Version = $props["Version"];
        }
    }

    public function N_OFFICE_DOCUMENT_SETTINGS($settings) {
        if ($settings === '') {
            echo '<OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
						  <RelyOnVML/>
						  <AllowPNG/>
						  <Colors>
						   <Color>
						    <Index>39</Index>
						    <RGB>#E3E3E3</RGB>
						   </Color>
						  </Colors>
						 </OfficeDocumentSettings>
				' . "\n";
        } else {
            echo $settings;
        }
    }

    public function N_EXCEL_WORKBOOK() {
        echo '<ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
					  <WindowHeight>7935</WindowHeight>
					  <WindowWidth>15195</WindowWidth>
					  <WindowTopX>120</WindowTopX>
					  <WindowTopY>135</WindowTopY>
					  <ProtectStructure>False</ProtectStructure>
					  <ProtectWindows>False</ProtectWindows>
					</ExcelWorkbook>
			' . "\n";
    }

    public function N_WORKSHEET($name) {
        echo '<Worksheet ss:Name="' . $name . '">' . "\n";
    }

    public function N_WORKSHEET_CLOSE() {
        echo '</Worksheet>';
    }

    public function N_TABLE($cols, $query, $db, $host, $user, $pass, $colformats, $coltotal, $headers) {
        $con = mysql_connect($host, $user, $pass);
        $db = mysql_select_db($db, $con);

        $result = mysql_query($query, $con);
        $cntr = 0;
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $cntr++;
        }
        // $_POST["WORKSHEET_NAME"]

        echo '<Names>\n<NamedRange ss:Name="_FilterDatabase" ss:RefersTo="' . ('=\'' . ($_POST["WORKSHEET_NAME"]) . '\'!R' . (count($headers) + 1) . 'C1:R' . ($cntr + count($headers) + 2) . 'C' . count($cols)) . '" ss:Hidden="1"/></Names>';
        echo '<Table ss:ExpandedColumnCount="' . (count($cols) + 1000000) . '" ss:ExpandedRowCount="1000000000" x:FullColumns="1" x:FullRows="1" ss:DefaultRowHeight="15">' . "\n";
        for ($x = 0; $x < count($cols); $x++) {
            echo '<Column ss:AutoFitWidth="1" ss:Width="106" />' . "\n";
        }
        //IF WITH EXTRA HEADERS
        if (count($headers) > 0) {
            foreach ($headers as $key => $value) {
                echo '<Row ss:AutoFitHeight="0">' . "\n";
                echo '<Cell ss:StyleID="s0000004" ss:MergeAcross="' . ($value["COLSPAN"]) . '" ss:MergeDown="' . ($value["ROWSPAN"]) . '"><Data ss:Type="String">' . $value["NAME"] . '</Data></Cell>' . "\n";
                echo "</Row>\n";
            }
        }

        echo '<Row ss:AutoFitHeight="0" ss:Height="35">' . "\n";
        foreach ($cols as $cl) {
            if ($cl == "Steel Crate No/ Fumigation Date") {
                echo '<Cell ss:StyleID="s64"><Data ss:Type="String">' . $cl . '</Data><NamedCell ss:Name="_FilterDatabase"/></Cell>' . "\n";
            } else {
                echo '<Cell ss:StyleID="s0000004"><Data ss:Type="String">' . $cl . '</Data><NamedCell ss:Name="_FilterDatabase"/></Cell>' . "\n";
            }
        }
        echo "</Row>\n";
        $cntr = 0;
        $xcntr = 0;

        mysql_free_result($result);
        $result = mysql_query($query, $con);

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            echo '<Row ss:AutoFitHeight="0">' . "\n";
            $xcntr = 0;
            foreach ($row as $key => $value) {
                $stylid = $colformats[$xcntr] == "String" ? "s00000001" : "s00000002";
                if ($stylid == "s00000001") {
                    echo '<Cell><Data ss:Type="' . ($colformats[$xcntr]) . '">' . mb_convert_encoding($value, 'UTF-8') . '</Data><NamedCell ss:Name="_FilterDatabase"/></Cell>' . "\n";
                } else {
                    echo '<Cell><Data ss:Type="' . ($colformats[$xcntr]) . '">' . mb_convert_encoding($value, 'UTF-8') . '</Data><NamedCell ss:Name="_FilterDatabase"/></Cell>' . "\n";
                }
                $xcntr++;
            }
            echo "</Row>\n";
            $cntr++;
        }
        //TOTAL
        echo '<Row ss:AutoFitHeight="0">' . "\n";
        $xcntr = 0;
        foreach ($coltotal as $cl) {
            if ($xcntr == 0) {
                if ($cl) {
                    echo '<Cell ss:StyleID="s71"><Data ss:Type="String">Total</Data></Cell>' . "\n";
                } else {
                    echo '<Cell></Cell>' . "\n";
                }
            } else {
                if ($cl) {
                    echo '<Cell ss:StyleID="s73" ss:Formula="=SUM(R[-' . ($cntr) . ']C:R[-1]C)"></Cell>' . "\n";
                } else {
                    echo '<Cell></Cell>' . "\n";
                }
            }
            $xcntr++;
        }
        echo "</Row>\n";
        echo "</Table>\n";
        echo '<AutoFilter x:Range="R' . (count($headers) + 1) . 'C1:R' . ($cntr + count($headers) + 2) . 'C' . count($cols) . '" xmlns="urn:schemas-microsoft-com:office:excel"></AutoFilter>';
        mysql_close($con);
        mysql_free_result($result);
    }

    public function N_WORKSHEET_OPTION($h, $v) {
        echo '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
				   <PageSetup>
				    <Header x:Margin="0.3"/>
				    <Footer x:Margin="0.3"/>
				    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
				   </PageSetup>
				   <Unsynced/>
				   <Print>
				    <ValidPrinterInfo/>
				    <HorizontalResolution>300</HorizontalResolution>
				    <VerticalResolution>300</VerticalResolution>
				   </Print>
				   <Selected/>
				   <FreezePanes/>
				   <FrozenNoSplit/>
				   <SplitHorizontal>' . $h . '</SplitHorizontal>
				   <SplitVertical>' . $v . '</SplitVertical>
				   <TopRowBottomPane>' . $h . '</TopRowBottomPane>
				   <ActivePane>2</ActivePane>
				   <Panes>
				    <Pane>
				     <Number>3</Number>
				    </Pane>
				    <Pane>
				     <Number>2</Number>
				     <ActiveRow>1</ActiveRow>
				     <ActiveCol>1</ActiveCol>
				    </Pane>
				   </Panes>
				   <ProtectObjects>False</ProtectObjects>
				   <ProtectScenarios>False</ProtectScenarios>
				  </WorksheetOptions>
  			' . "\n";
    }

    public function N_STYLES() {
        echo '
				<Styles>
				  <Style ss:ID="Default" ss:Name="Normal">
				   <Alignment ss:Vertical="Bottom"/>
				   <Borders/>
				   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
				   <Interior/>
				   <NumberFormat/>
				   <Protection/>
				  </Style>
				  <Style ss:ID="s0000002" ss:Name="Comma">
				   <NumberFormat ss:Format="_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"/>
				  </Style>
				  <Style ss:ID="s0000004">
				   <NumberFormat ss:Format="@"/>
				   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#244062" ss:Bold="1"/>
				   <Alignment ss:Vertical="Center" ss:Horizontal="Center"/>
				   <Interior ss:Color="#E3E3E3" ss:Pattern="Solid"/>
				  </Style>
				  <Style ss:ID="s0000003">
				   <NumberFormat ss:Format="@"/>
				  </Style>
				  <Style ss:ID="s00000001" ss:Parent="s0000003">
				   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
				  </Style>
				  <Style ss:ID="s64">
				  <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#244062" ss:Bold="1"/>
				   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
				   <Interior ss:Color="#E3E3E3" ss:Pattern="Solid"/>
				   <NumberFormat ss:Format="@"/>
				  </Style>
				  <Style ss:ID="s67">
				   <NumberFormat ss:Format="_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"/>
				  </Style>
				  <Style ss:ID="s71">
				   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FF0000"
				    ss:Bold="1"/>
				   <NumberFormat ss:Format="@"/>
				  </Style>
				  <Style ss:ID="s72">
				   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FF0000"
				    ss:Bold="1"/>
				  </Style>
				  <Style ss:ID="s73">
				   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FF0000"
				    ss:Bold="1"/>
				   <NumberFormat ss:Format="_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"/>
				  </Style>
				  <Style ss:ID="m0000000999">
				   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FF0000"
				    ss:Bold="1"/>
				    <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
				   <NumberFormat ss:Format="_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"/>
				  </Style>
				  <Style ss:ID="m0000000777">
				   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FF0000"
				    ss:Bold="1"/>
				   <NumberFormat ss:Format="_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"/>
				  </Style>
				  <Style ss:ID="m000000045">
				   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:Rotate="45"/>
				   <Borders>
				    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
				   </Borders>
				  </Style>
				  <Style ss:ID="m000000090">
				   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:Rotate="90"/>
				   <Borders>
				    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
				   </Borders>
				  </Style>
				  <Style ss:ID="m0000000900">
				   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:Rotate="-90"/>
				   <Borders>
				    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
				   </Borders>
				  </Style>
				  <Style ss:ID="m0000000450">
				   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:Rotate="-45"/>
				   <Borders>
				    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
				   </Borders>
				  </Style>
				  <Style ss:ID="m000000060">
				   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:Rotate="60"/>
				   <Borders>
				    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
				   </Borders>
				  </Style>
				  <Style ss:ID="m0000000600">
				   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:Rotate="-60"/>
				   <Borders>
				    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
				    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
				   </Borders>
				  </Style>
				 </Styles>' . "\n";
    }

    public function N_OUTPUT() {
        $FILE_N = $_POST["FILE_NAME"] == "" ? $_POST["WORKSHEET_NAME"] : $_POST["FILE_NAME"];
        header("Cache-Control: ");
        header("Content-type: Application/vnd.ms-excel;Charset: UTF-8;");
        header('Content-Disposition: attachment; filename="' . $FILE_N . '.xls"');
        $this->N_WORKBOOK();
        $this->N_DOCUMENT_PROPERTIES('');
        $this->N_OFFICE_DOCUMENT_SETTINGS('');
        $this->N_EXCEL_WORKBOOK();
        $this->N_STYLES();
        $this->N_WORKSHEET($_POST["WORKSHEET_NAME"]);
        $this->N_TABLE(json_decode($_POST["COLUMNS"], true), $_POST["QUERY"], $_POST["DATABASE"], $_POST["HOST"], $_POST["USER"], $_POST["PASSWORD"], json_decode($_POST["COLUMNS_FORMATS"], true), json_decode($_POST["COLUMNS_TOTAL"], true), json_decode($_POST["HEADERS"], true));
        $this->N_WORKSHEET_OPTION(count(json_decode($_POST["HEADERS"], true)) + 1, 0);
        $this->N_WORKSHEET_CLOSE();
        $this->N_WORKBOOK_CLOSE();
    }

}

$model = new N_EXPORT_EXCEL();
$model->N_OUTPUT();
?>