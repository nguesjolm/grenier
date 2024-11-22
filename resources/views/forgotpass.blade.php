@include('layouts.header')
  @include('pages.forgotpass')
@include('layouts.footer')
<script type="text/javascript">
$(function(){
  // script de gestion
  $('.sendPass').click(function(){
     var nom = $("#nom").val();
     var prenom = $("#prenom").val();
     var tel = $("#tel").val();
     if (nom!=""&&prenom!=""&&tel!="") {
        $.ajax({
          url:'passRecp',
          method:'GET',
          data:{nom:nom,prenom:prenom,tel:tel},
          dataType:'json',
          success:function(data){
            if (data.code=='1') {
              Swal.fire("Mot de passe: "+data.pass);
            }
            else{
              Swal.fire("Ce compte n'existe pas !");
            }
          },
          error:function(data){
            console.log(data);
          }
        });
     }
     else {
       Swal.fire({icon: 'error',
                  text: 'Veuilez remplir le formulaire',
                });
     }
  });



});

</script>
