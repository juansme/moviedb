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
                var arr = [json[i].picture, json[i].title, json[i].released_at, '<button load data-target="#edit" data-url="'+ json[i].base +'movies/load/'+ json[i].id +'" class="btn btn-primary btn-xs">EDITAR</button> <button delete data-url="'+ json[i].base +'movies/delete/'+ json[i].id +'" class="btn btn-danger btn-xs">ELIMINAR</button>']
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
$('.search').each(function(index, el) {
    $(el).devbridgeAutocomplete({
        serviceUrl: $(el).data('url'),
        dataType: 'json',
        minChars: 1,
        transformResult: function(response) {
            if (response){
                return {
                    suggestions: $.map(response, function(dataItem) {
                        return { value: dataItem.name, data: dataItem.id, object: dataItem };
                    })
                };
            } else {
                return {
                    suggestions: []
                };
            }
        },
        beforeRender: function (container, suggestions) {
            container.find('.autocomplete-suggestion').each(function(i, suggestion){
                var text = $(suggestion).text();
                $(suggestion).html(suggestions[i].object.picture + text);
            });
        },
        onSearchComplete: function (query, suggestions) {
            if (suggestions.length < 1)
                new Noty({
                    theme: 'bootstrap-v3',
                    type: 'warning',
                    layout: 'bottomRight',
                    progressBar: false,
                    timeout: 6000,
                    text: 'No se encontraron resultados.'
                }).show();
        },
        onSelect: function (suggestion) {
            var input = $(el);
            input.val('');
            switch (input.data('type')) {
                case 'director':
                    input.hide();
                    $(input.data('target')).append(mapThumbnail(suggestion.object, input.data('type')));
                    break;
                case 'actors':
                    if ($(input.data('target')).find('input[value='+ suggestion.object.id +']').length === 0) {
                        $(input.data('target')).append(mapThumbnail(suggestion.object, input.data('type')));
                    }
                    break;
            }
        }
    }); 
});
$('body').on('click', 'button.remover', function(event) {
    event.preventDefault();
    if ($(this).is('[data-url]')) {
        var that = $(this);
        var uri = $(this).is('[director]') ? 'movies/removeDirector/' : 'movies/removeActor/';
        $.ajax({
            url: $(this).data('url') + uri + $(this).data('value'),
            cache: false,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                switch (response['type']) {
                    case 'success':
                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'success',
                            layout: 'bottomRight',
                            progressBar: false,
                            timeout: 6000,
                            text: response['message']
                        }).show();
                        that.is('[director]') && that.closest('form').find('input.search[data-type=director]').show();
                        that.closest('div.thumbnail').remove();
                        break;
                    case 'warning':
                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'warning',
                            layout: 'bottomRight',
                            progressBar: false,
                            timeout: 6000,
                            text: response['message']
                        }).show();
                        that.is('[director]') && that.closest('form').find('input.search[data-type=director]').show();
                        that.closest('div.thumbnail').remove();
                        break;
                    case 'error':
                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'error',
                            layout: 'bottomRight',
                            progressBar: false,
                            timeout: 6000,
                            text: response['message']
                        }).show();
                        break;
                }
            }
        });
    } else {
        $(this).is('[director]') && $(this).closest('form').find('input.search[data-type=director]').show();
        $(this).closest('div.thumbnail').remove();
    }
});