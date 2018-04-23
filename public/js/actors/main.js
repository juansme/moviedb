$('#DataTable tfoot th').each( function () {
    var title = $(this).text();
    if (title != '') {
        $(this).html( '<input type="text" placeholder="Buscar en '+title+'" />' );
    }
} );
var table = $('#DataTable').DataTable({
    dom: 'Bltrip',
    buttons: [],
    responsive: true,
    ajax: {
        url: $('#DataTable').data('url'),
        dataType: "json",
        dataSrc: function ( json ) {
            var data = [];
            for ( var i=0; i<json.length ; i++ ) {
                // var arr = Object.keys(json[i]).map(function(k) { return json[i][k] });
                var arr = [json[i].picture, json[i].name, json[i].birth_date, '<button load data-target="#edit" data-url="'+ json[i].base +'actors/load/'+ json[i].id +'" class="btn btn-primary btn-xs">EDITAR</button> <button delete data-url="'+ json[i].base +'actors/delete/'+ json[i].id +'" class="btn btn-danger btn-xs">ELIMINAR</button>']
                var subdata = [];
                for (j in arr) {
                    subdata.push(arr[j]);
                }
                data.push(subdata);
            }
            return data;
        }
    }
});
table.columns().every( function () {
    var that = this;
    $( 'input', this.footer() ).on( 'input', function () {
        if ( that.search() !== this.value ) {
            that
                .search( this.value )
                .draw();
        }
    } );
} );
$('.datepicker').datetimepicker({format: "YYYY-MM-DD", locale: 'es'});