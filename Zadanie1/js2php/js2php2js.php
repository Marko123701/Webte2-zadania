<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>js2php</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
     $(document).ready(function(){
        $('#tlacidlo').on("click", function(){
          var prem1 = "Ahoj";
          var prem2 = "svet!";
          
          $.ajax({
              type:"POST",
              url: "js2php.php",
              data: "var1=" + prem1 + "&var2=" + prem2,
              dataType:'json',
              success: function(udaje){
                console.log(udaje);
                $( "#sem" ).append( udaje );
              }
          });
          /*
          $.post( "js2php.php", 
                  "var1=" + prem1 + "&var2=" + prem2, 
                  function(udaje){
                    $( "#sem" ).append( udaje );  });
          */
});});  

    </script>
 </head>
 <body>
  <input type="button" value="Klikni sem" id="tlacidlo"> 
  <div id="sem"></div>
 </body>
</html>

