//Handling of validation for master,liner/airline,job....etc
var report  = new function() {

    this.success  = 0;

    // Print function for close after task
    /*this.pageprint = function (){
        $('#printBtnDiv').html('');
        $('#emailDiv').html('');
        $('#maildiv').html('');
        $('.scr').removeClass('scrl');
        $('.scr').addClass('noscrl');
        window.print();
        window.close();
    };*/

    /* Function 1 : HTML table to Excel */
    this.tableToExcel = (function () {          
        var uri = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:spreadsheet" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {            

            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();            
        }
    })()


    /* Function 2 : HTML table to Excel */
    this.exportData = function (table, filename) {
        /* Get the HTML data using Element by Id */
        var table = document.getElementById(table);
     
        /* Declaring array variable */
        var rows =[];
     
          //iterate through rows of table
        for(var i=0,row; row = table.rows[i];i++){
             var str = '';
            //rows would be accessed using the "row" variable assigned in the for loop
            //Get each cell value/column from the row              
            var curTr = row.getAttribute("data-sel");
            if(curTr && 1 == curTr){        
                for(var j=0; j<row.cells.length; j++){ 
                    //columns
                    columnN = 'column'+j;
                    //column texts
                    columnN = row.cells[j].innerText;
                    //Store value to avoid ''
                    if(0 == j)
                        str     = columnN;
                    else //Store values
                        str     = str+','+columnN;
                }

                /* add a new records in the array */
                rows.push(
                    [
                        str
                    ]
                );   
            }  
        }
        csvContent = "data:text/csv;charset=utf-8,";
         /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
        rows.forEach(function(rowArray){
            row = rowArray.join(",");
            csvContent += row + "\r\n";
        });
 
        /* create a hidden <a> DOM node and set its download attribute */
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", filename+".csv");
        document.body.appendChild(link);
         /* download the data file named "Stock_Price_Report.csv" */
        link.click();
    }
    

}