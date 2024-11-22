{{-- @php
  session_destroy();
@endphp --}}
@if (isset($_SESSION['tel']) AND !empty($_SESSION['tel']))
  @include('layouts.header')
    @include('pages.entreprise')
  @include('layouts.footer')
@else
  @include('layouts.header')
    @include('pages.grenier')
  @include('layouts.footer')
@endif

<script type="text/javascript">
$(function(){
   /*Gestion des Offres*/
      // Supprimer une offre
      $(".delOff").click(function(){
        var id = $(this).attr("id");
        Swal.fire({
          title: 'GESTION DE COMPTE',
          text: "Voulez-vous supprimer cette offre?",
          icon: 'error',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'non',
          confirmButtonText: 'oui , supprimer!',
          backdrop: `rgba(240,15,83,0.4)`
        }).then((result) => {
            if (result.value)
            {
              $.ajax({
                url:'delOf',
                method:'GET',
                data:{idOf:id},
                dataType:'json',
                success:function(data){
                  if (data.code==2) {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Offre Supprimée avec succès',
                      showConfirmButton: false,
                      timer: 1500
                    });
                    window.location="mon_comptes";
                  }
                },
                error:function(data){
                   console.log('error');
                }
              });

            }
        })

      });

      // Boutton de publiction
      $(".send").click(function(){
        $(this).text("Chargement en cours...");
      });


});
</script>
