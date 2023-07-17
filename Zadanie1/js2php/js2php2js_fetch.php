
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
          
          fetch('js2php_fetch.php', {
            method : 'post',
            body: JSON.stringify({var1: prem1, var2: prem2})
          })
          .then((res) => res.json())
          .then((data) => {console.log(data);
                           $( "#sem" ).append( data );})
          .catch((error) => console.log(error))
});});  


    </script>
 </head>
 <body>
  <input type="button" value="Klikni sem" id="tlacidlo"> 
  <div id="sem"></div>
 </body>
</html>