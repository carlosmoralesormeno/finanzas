function mensaje(tipo, titulo, texto) {
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: texto
    });
}

function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

function ajax_save(view, form, action, ajax) {
    if (view && form && action) {
        $.ajax({
            data: $('#' + form).serialize(),
            url: 'index.php?view=' + view + '&action=' + action + '&datatype=json',
            dataType: 'json',
            type: 'post',
            success: function (data) {
                if (data) {
                    ajax_reload_page(ajax);
                }

            },
            error: function (errorThrown) {
                console.log(errorThrown)
                mensaje('error', 'Error', 'Ha ocurrido un error al almacenar los datos');
            }
        });
    }
}

function ajax_get(view, action, id) {

    let params = {
        'view': view,
        'action': action,
        'id': id
    };

    if (view && action && id) {
        $.ajax({
            data: params,
            url: 'index.php?view=' + view + '&action=' + action + '&datatype=json&id=' + id,
            type: 'get',
            success: function (data) {
                $('#id').val(data.attributes[0].id);
                $('#date').val(data.attributes[0].date);
                $('#type').val(data.attributes[0].type);
                $('#value').val(data.attributes[0].value);
            }
        });
    }
}

function ajax_delete(view, action, id, ajax) {

    let params = {
        'view': view,
        'action': action,
        'id': id
    };

    if (view && action && id) {

        Swal.fire({
            title: '¿Estas Seguro?',
            text: 'Esto eliminará la transacción',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '¡Si, Borrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    data: params,
                    url: 'index.php?view=' + view + '&action=' + action + '&datatype=json&id=' + id,
                    type: 'get',
                    success: function (data) {
                        ajax_reload_page(ajax)
                        if (data) {
                            mensaje('success', 'Eliminado', 'Se ha eliminado la transacción');
                        }
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown)
                        mensaje('error', 'Error', 'Ha ocurrido un error al almacenar los datos');
                    }
                });
            }
        })
    }
}

function ajax_reload_page(view) {

    let date = getUrlParameter('date');

    if (view) {
        $('#container').load('index.php?view=' + view + '&datatype=ajax'+'&date='+date);
    }
}

jQuery(document).ready(function ($) {


    $('#finance_form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this).attr('id');

        let status = true;

        if (!$('#date').val()) {
            status = false; mensaje('error', 'Comprueba los Datos', 'Debes ingresar la fecha.');
        } else if (!$('#type').val()) {
            status = false; mensaje('error', 'Comprueba los Datos', 'Debes ingresar el tipo.');
        } else if (!$('#value').val()) {
            status = false; mensaje('error', 'Comprueba los Datos', 'Debes ingresar el valor.');
        }

        if (status) {
            ajax_save('finance', form, 'save_json', 'finance');
            $('#new_transaction').modal('hide');
        }

    });

    $('#modal_transaction').on('click', function () {
        $('#id').val('');
        $('#date').val('');
        $('#type').val('');
        $('#value').val('');
        $('#new_transaction').modal('show');
    });

    $('.transaction-edit').on('click', function () {
        let view = $(this).data('view');
        let action = $(this).data('action');
        let id = $(this).data('id');
        ajax_get(view, action, id);
        $('#new_transaction').modal('show');
    });

    $('.transaction-delete').on('click', function () {
        let view = $(this).data('view');
        let action = $(this).data('action');
        let id = $(this).data('id');
        ajax_delete(view, action, id, 'finance');
    });

});