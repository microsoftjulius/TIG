
<!--Jquery code for date time picker-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap -->
<script src="{{ asset('bootstrap/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Chart.js -->
{{-- <script src="{{ asset('bootstrap/vendors/Chart.js/dist/Chart.min.js')}}"></script> --}}
<!-- DateJS -->
<script src="{{ asset('bootstrap/vendors/DateJS/build/date.js')}}"></script>
<!--For the Tables-->
<!-- Datatables -->
<script src="{{ asset('bootstrap/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('bootstrap/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
{{-- <script src="{{ asset('bootstrap/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script> --}}
<script src="{{ asset('bootstrap/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('bootstrap/build/js/custom.min.js')}}"></script>
<!-- MDB core JavaScript -->
<!--multiselect checkboxes-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

<script type="text/javascript">
$( function() {
    //$( "#datepicker" ).datepicker();
    jQuery('#datetimepicker').datetimepicker({format:'d.m.Y H:i',
    inline:false,
    lang:'ru'});
    } );
        function countChars(obj){
            var maxLength = 160;   
            var strLength = obj.value.length;
            var firstMessage = maxLength ;
            
            if(firstMessage == 160){
            document.getElementById("charNum").innerHTML = obj.value.length+'<span style="color:red;">(You have reached limit of 160 characters for 1 message)</span>';
        }else{
            document.getElementById("charNum").innerHTML = firstMessage+'characters [1message is 160 characters,2messages 310 characters]';
        }
        
        if (strLength === maxLength){
            document.getElementById("charNum").innerHTML = obj.value.length+'<span style="color:red;">(You have reached limit of 160 characters for 1 message)</span>';
        } 
        else{
            document.getElementById("charNum").innerHTML = strLength+'characters [1message is 160 characters,2messages 310 characters]';
        } 
        
    }
    $('text').maxlength({
            alwaysShow: true,
            threshold: 10,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger",
            separator: ' out of ',
            preText: 'You write ',
            postText: ' chars.',
            validate: true,
            placement: 'bottom-left'
    });
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
    function addRow(tableID) {
    
        var table = document.getElementById(tableID);
    
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
            var cell2 = row.insertCell(0);
        cell2.innerHTML = rowCount;
    
        var cell3 = row.insertCell(1);
        var element2 = document.createElement("input");
        element2.type = "text";
        element2.name = "txtbox[]";
        cell3.appendChild(element2);
    
        var cell3 = row.insertCell(2);
        var element2 = document.createElement("input");
        element2.type = "text";
        element2.name = "txtbox[]";
        cell3.appendChild(element2);
    
        var cell3 = row.insertCell(3);
        var element2 = document.createElement("input");
        element2.type = "text";
        element2.name = "txtbox[]";
        cell3.appendChild(element2);
    }
    
    function deleteRow(tableID) {
        try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
    
        for(var i=0; i<rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if(null != chkbox && true == chkbox.checked) {
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
        }catch(e) {
            alert(e);
        }
    }
</script>
