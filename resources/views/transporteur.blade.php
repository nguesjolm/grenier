@include('layouts.header')
  @include('pages.transporteur')
@include('layouts.footer')
<script type="text/javascript">
$(function(){
  // Verification de tel
  $("#tel").blur(function(){
     var tel = $("#tel").val();
     var nb  = tel.length;
     if (nb==10) {
        regtel = 1;
     }
     else{
       Swal.fire({icon: 'error',
                  text: 'Numéro de téléphone incorrecte:10 chiffres!',
                });
      $("#tel").val("");
     }
  });

  // Verification de nom
  $("#nom").blur(function(){
     var nom = $("#nom").val();
     var nbN  = nom.length;
     if (nbN<3)
     {
       Swal.fire({icon: 'error',
                  text: 'Le nom doit avoir 3 caractères minimum',
                });
       $("#nom").val('');
      }
      else
      {
        regnom = 1;
      }
  });


    // Verifcatipon prenom
    $("#prenom").blur(function(){
       var nom = $("#prenom").val();
       var nbP  = nom.length;
       if (nbP<3)
       {
         Swal.fire({icon: 'error',
                    text: 'Le prenom doit avoir 3 caractères minimum',
                  });
         $("#prenom").val('');
        }
        else
        {
          regprenom = 1;
        }
    });




});
</script>
