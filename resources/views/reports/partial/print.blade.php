<div class="row" id="print-btn">
    <div class="d-flex justify-content-center">
        <button type="button" class="btn btn-success" onclick='printPage("print-btn");'>
            Print
        </button>
    </div>
</div>

<script>
    const printPage = (printBtn) => {
       if (window.print) {              
            document.querySelector('#'+printBtn).style.display = 'none';
            window.print(); 
            document.querySelector('#'+printBtn).style.display = 'block';                          
        } else {
          console.log("Printing is not supported in this browser.");
        } 
    }        
</script>