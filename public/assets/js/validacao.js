$(".btn-delete").on("click", function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    new Swal({
        title: 'Deseja realmente excluir esse item?',
        text: "Não será possivel a recuperação do mesmo.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim'
      }).then((result) => {
          if (result.isConfirmed) {
           window.location.href = url;
          }
      });
});


$(".btn-status").on("click", function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    new Swal({
        title: "Ops!",
        text: "Deseja realmente executar essa ação?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim'
      }).then((result) => {
          if (result.isConfirmed) {
           window.location.href = url;
          }
      });
});



$(".btn-form").on("click", function(e){
    e.preventDefault();
    var url = form=$(this).parents('form');
    new Swal({
        title: "Ops!",
        text: "Deseja realmente executar essa ação?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim'
      }).then(function(result) {
        if (result.value) {
            form.submit();
        }
    });
});

