@include('layouts.header')
  @include('pages.signup')
@include('layouts.footer')
<script type="text/javascript">
 $(function(){
  // Variables
  var regtel;
  var regnom;
  var regprenom;
  var password

	// Création de compte
	 $(".createcount").click(function(){
	 	    var nom      = $("#nom").val();
        var prenom   = $("#prenom").val();
        var tel      = $("#tel").val();
        var password = $("#password").val();
        console.log("nom:"+nom+" prenom:"+prenom+" tel:"+tel);
        if(regtel==regnom==regprenom==1&&password!="")
        {
           $.ajax({
           	 url:'creatcount',
           	 data:{nom:nom,prenom:prenom,tel:tel,password:password},
           	 method:'GET',
           	 dataType:'json',
           	 success:function(data){
               if (data.code==1)
               {
                 window.location="mon_comptes";
               }
               else {
                 Swal.fire('Ce Numéro existe dejà');
               }
             },
           	 error:function(data){console.log("error");}
           })
        }
        else
        {
          // sweet alert
          Swal.fire('Veuilez remplir correctement le formulaire');
        }
	 });

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
      }
      else
      {
        regprenom = 1;
      }
  });


  });
</script>
