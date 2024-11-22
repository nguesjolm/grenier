@include('layouts.header')
  @include('pages.sign')
@include('layouts.footer')

<script type="text/javascript">
$(function(){
   // Connection au compte
   $(".loginCpt").click(function(){
     var tel = $("#tel").val();
     var password = $("#password").val();
     $.ajax({
       url:'login',
       method:'GET',
       data:{tel:tel,password:password},
       dataType:'json',
       success:function(data){
         if (data.code==1) {
           window.location="mon_comptes";
         }
         else if (data.code==2) {
           Swal.fire('Mot de passe incorrecte');
         }else if (data.code==0) {
           Swal.fire('Veuillez remplir le formulaire');
         }
         else {
           Swal.fire('Numéro de téléphone incorrecte');
         }
       },
       error:function(data){console.log("Error");}
     });
   });

});
</script>
