@include('layouts.header')
  @include('pages.adminlog')
@include('layouts.footer')

<!-- Script de gestion de la page -->
<script type="text/javascript">
 $(function(){
 	// Connection au backoffice
     $(".adminLog").click(function(){
     	 var mail = $(".email").val();
     	 var password = $(".password").val();
     	 console.log("mail:"+mail+ "pass:"+password);
     	 $.ajax({
     	 	url:'logAd',
     	 	method:'GET',
     	 	data:{mail:mail,pass:password},
     	 	dataType:'json',
     	 	success:function(data){
				console.log(data.code);
     	 	    if (data.code==1) {
                 window.location="dashboard";
                }else if (data.code==2) {
                    Swal.fire({icon: 'error',
                           text: "Vous n'êtes pas autorisé",
                     });
                }
     	 	},
     	 	error:function(){
     	 		console.log("erreur d'ouverture de compte");
     	 	}
     	 })
     });

 });
</script>
