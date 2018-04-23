$(document).ready(function () {
    $("#registerForm .alert").hide();
    $("div.profile .alert").hide();
});
$(window).resize(function(event) {
    popupTop();
});
$('.popup').click(function(event) {
    if (event.target !== this)
    return;
    $(this).hide();
});
$('.popup-close').click(function(event) {
    $(this).closest('div.popup').hide();
});
$('body').on('click', '[data-toggle*="popup"]', function(event) {
    $($(this).data('target')).find('form').trigger('reset');
    // $($(this).data('target')).find('select').trigger('chosen:updated');
    $($(this).data('target')).find('span.help-block').html('');
    $($(this).data('target')).find('div.form-group').removeClass('has-error');
    $($(this).data('target')).find('div.cast-area').html('');
    $($(this).data('target')).find('input.search').show();
    $($(this).data('target')).show();
    popupTop();
});
function popupTop() {
    $('.popup .panel').each(function(index, el) {
        var popup_height = $(el).height();
        $(el).css('margin-top', 'calc((100vh - '+ popup_height +'px)/2)');
    });
}
$('body').on('input', '#datatables-search', function(event) {
    if ($(this).val().length > 1 || $(this).val() == '')
        $('#DataTable').DataTable().ajax.url($('#DataTable').data('url') +'?q='+ $(this).val()).load();
});
$('body').on('submit', 'form.ajax', function(event) {
    event.preventDefault();
    $(this).find('span.help-block').html('');
    var that = $(this);
    $.ajax({
        url: $(this).data('action'),
        contentType: false,
        processData: false,
        cache: false,
        type: 'POST',
        data: new FormData(this),
        dataType: 'json',
        success: function(response) {
            that.find('div.form-group').removeClass('has-error');
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
                    that.closest('div.popup').hide();
                    $('#DataTable').length && $('#DataTable').DataTable().ajax.reload();
                    break;
                case 'validation':
                    var errors = response['message'];
                    for (var field in errors) {
                        $('#'+ field).closest('div.form-group').addClass('has-error');
                        $('#'+ field).closest('div.form-group').find('span.help-block').html(errors[field]);
                    }
                    popupTop();
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
});
$('body').on('click', '[load]', function(event) {
    event.preventDefault();
    var target = $(this).data('target');
    $(target).find('span.help-block').html('');
    $(target).find('form').trigger('reset');
    $.ajax({
        url: $(this).data('url'),
        cache: false,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            switch (response['type']) {
                case 'success':
                    $.each(response['data'], function(key, value){
                        if (key == 'rel') {
                            $('#old-actors').html('');
                            var dir = response.data.rel.director;
                            dir.length && $(target).find('input.search[data-type=director]').hide();
                            for (i in dir) {
                                $('#old-director').html(mapThumbnail(dir[i], 'director', 1));
                            }
                            var act = response.data.rel.actors;
                            for (i in act) {
                                $('#old-actors').append(mapThumbnail(act[i], 'actors', 1));
                            }
                            return true;
                        }
                        if($('#' + key).prop('tagName') == 'SELECT') {
                            if (value != null) {
                                $('#' + key).find('option').prop('selected', false);
                                $('#' + key).find("option[value='"+ value +"']").prop('selected', true);
                                $('#' + key).trigger('chosen:updated');
                                $('#' + key).trigger('change');
                            }
                        } else {
                            if ($('#' + key).attr('type') == 'checkbox') {
                                if (value != null) {
                                    $('#' + key).prop('checked', true);
                                } else {
                                    $('#' + key).prop('checked', false);
                                }
                                $('#' + key).trigger('change');
                            } else {
                                $('#' + key).val(value);
                            }
                        }
                    });
                    $(target).show();
                    popupTop();
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
                    $('#DataTable').length && $('#DataTable').DataTable().ajax.reload();
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
});
$('body').on('click', '[delete]', function(event) {
    event.preventDefault();
    $.ajax({
        url: $(this).data('url'),
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
                    $('#DataTable').length && $('#DataTable').DataTable().ajax.reload();
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
                    $('#DataTable').length && $('#DataTable').DataTable().ajax.reload();
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
});
function mapThumbnail(data, type, ajax = 0) {
    var name = type == 'director' ? 'id_director' : 'actors[]';
    var html = '<div class="thumbnail stack">';
    html += '<button'+ (ajax ? ' data-url="'+ data.base +'"' : '') +' class="remover" data-value="'+ data.id +'"'+ (type == 'director' ? ' director' : '') +'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
    if (!ajax) {
        html += '<input type="hidden" name="'+ name +'" value="'+ data.id +'">';
    }
    html += '<div>'+ data.picture +'</div>';
    html += '<div class="caption">'+ data.name +'</div>';
    html += '</div>';
    return html;
}