@include('layouts.header')
  @include('pages.check')
@include('layouts.footer')

<script type="text/javascript">
$(function(){
  // Réserver une place
   $(".reserv").click(function(){
      var offre = $(this).attr('id');
      $.ajax({
         url:'readoff',
         method:'get',
         data:{offre:offre},
         dataType:'json',
         success:function(data){
            $('.transp').text(data.transp);
            $('.destin').text(data.destin);
            $('.place').text(data.place);
            $('.prix').text(data.price);
            $('.unite').text(data.unite);
            $('.uniteOf').val(data.unite);
            $('.profile').attr('src',data.profile);
            $('.idoff').val(data.idoff);
            $('.idtransp').val(data.idtransp);
            $('.teltransp').val(data.teltransp);
         },
         error:function(data){
           console.log('error');
         }
      });

   });

  // Montant total à payer
    $('.qtecmd').keyup(function(){
      var qte = $('.qtecmd').val();
      var montant = $('.prix').text();
      $(".payer").text(qte*montant);
    });

  //Lancement de la reservation
  $('.reservBtn').click(function(){
    var idoff = $('.idoff').val();
    var idtransp = $('.idtransp').val();
    var arret = $('.arret').val();
    var qte = $('.qtecmd').val();
    var place = $('.place').text();
    var telT = $('.teltransp').val();
    var unite = $('.uniteOf').val();
    var data = {idoff:idoff,idtransp:idtransp,arret:arret,qte:qte,place:place,telT:telT,unite:unite};
    if (qte!='' && arret!='') {
      $.ajax({
        url:'saveReserv',
        data:data,
        method:'GET',
        dataType:'json',
        success:function(data){
          if (data.code==1) {
            // window.location='mon_comptes';
            Swal.fire({
              icon: 'success',
              title: 'Félication...',
              text: "Réservation validée avec succès",
              footer: "<a href='mon_comptes' class='text-warning'>Voir mes reservations</a>"
            })
          }
          if (data.code==2) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: "Vous n'avez pas de compte Grenier",
              footer: "<a href='sign' class='text-warning'>S'inscrire ou Se connecter</a>"
            })
          }

          if (data.code==3) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: "Nous n'avons que "+place+" disponible"
            })
          }

        },
        error:function(data){
          console.log(data);
        }
      });
    }else{

      if (arret=='') {
        Swal.fire({
         icon: 'error',
         title: 'Oops...',
         text: "Veuilez préciser le point d'arrêt"
        })
      }
      if(qte==''){
        Swal.fire({
         icon: 'error',
         title: 'Oops...',
         text: "Veuilez préciser le nombre de place"
        })
      }

    }

  });

  //Boutton d'annulement de la commande
  $('.annulBtn').click(function(){
    var arret = $('.arret').val('');
    var qte = $('.qtecmd').val('');
    $(".payer").text('0');
  });

  // Filtrage automatique
  $(".grenierCheck").click(function(){
     $(".grenierCheck").text("Recherche en cours...");
     var arrive = $('.arriveSelect').children("option:selected").val();
     var depart = $('.departSelect').children("option:selected").val();
     var unite  = $('.uniteSelect').children("option:selected").val();
     data = {arrive:arrive,depart:depart,unite:unite};
     // $(".offresZone").html("<p>Bonjour</p>");
  });

});
</script>
