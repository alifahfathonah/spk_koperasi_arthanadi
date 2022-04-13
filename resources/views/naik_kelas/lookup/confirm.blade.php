  <p>
      Apakah anda yakin melakukan proses kenaikan kelas siswa? <br>
      <small><i>Setelah anda menekan ya, proses tidak dapat dibatalkan</i></small>
  </p>
  <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
      <button id="submit-posting" type="submit" class="btn btn-success">Ya</button>
  </div>

  <script type="text/javascript">
    //<![CDATA[
    (function( $ ){		
        
        $( document ).ready(function(e) {
                  
            $("#submit-posting").on("click", function(e){
              e.preventDefault();						
                    
              var data_post = $("#form_postings").serializeArray();
              $.post($("#form_postings").attr("action"), data_post, function( response, status, xhr ){
                if( response.status == "error"){
                  $.alert_warning(response.message);
                  return false
                }
                
                $.alert_success( response.message );
                
                setTimeout(function(){
                  document.location.href = "{{ url('siswa/naik_kelas') }}";        
                }, 500);  
                
              })	
            });
                    
          });
      })( jQuery );
    //]]>
    </script>