$(document).ready(function() {

    // const editor = new $.fn.dataTable.Editor({
    //     ajax: {
    //         url: window.userEditorUrl,
    //         type: "POST",
    //         headers: {"X-CSRF-Token": window.tokenCsrf}
    //     },
    //     table: "#user-table",
    //     idSrc: "id",
    //     serverSide: true,
    //     fields: [
    //         {
    //             label: "Nombre",
    //             name: "name"
    //         },
    //         {
    //             label: 'Apellido',
    //             name: 'surname'
    //         },
    //         {
    //             label: 'Usuario',
    //             name: 'username'
    //         }
    //     ]
    // });

    // // Activate an inline edit on click of a table cell
    // $('#user-table').on('click', 'tbody td:not(:first-child)', function (e) {
    //     editor.inline(this);
    // });


    // $('#user-table thead th').each(function() {
    //     var title = $(this).text();
    //     if (title != "") {
    //         $(this).html('<input type="text" placeholder="' + title + '" />');
    //     }
    //
    // });

    const table$ = $('#user-table');
    const datatable = table$.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: window.userDatatableUrl
        },
        columns: [
            //     {
            //     data: 'id',
            //     name: 'id',
            //     render: function (data, type, row) {
            //         if (row.user_type === 2) {
            //             return '<a class="btn btn-sm" href="' + window.domainUrl + '/permission/' + data + '"> <i class="fas fa-user-shield"></i> </a>';
            //         } else {
            //             return '';
            //         }
            //     }
            // },
            //     {data: 'id', name: 'id'},
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'surname',
                name: 'surname'
            },
            {
                data: 'username',
                name: 'username'
            },
            {
                data: 'country',
                name: 'country',
                render: function(data) {
                    if (data === 'BO') {
                        return 'Bolivia';
                    } else if (data === 'CO') {
                        return 'Colombia';
                    } else if (data === 'PE') {
                        return 'Peru';
                    } else if (data === 'BRA') {
                        return 'Brazil';
                    }
                    return '';
                }
            },
            {
                data: 'user_type',
                name: 'user_type',
                class: 'short',
                render: function(data) {
                    if (data === "1") {
                        return 'Superadministrador';
                    } else if (data === "2") {
                        return 'Administrador';
                    } else if (data === "3") {
                        return 'Trabajador';
                    } else if (data === "4") {
                        return 'Supervisor';
                    }
                    return '';
                }
            },
            {
                data: 'company.name',
                name: 'company.name'
            },
            {
                data: null,
                orderable: false,
                sortable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<button class="btn btn-xs btn-info" data-user-id="' + row.id + '" data-toggle="modal" data-target="#edit"><i class="fas fa-user-edit"></i></button>';
                }

            }
        ]
    });

    // table.columns().every(function() {
    //     var that = this;
    //
    //     $('input', this.header()).on('keyup change clear', function() {
    //         if (that.search() !== this.value) {
    //             that.search(this.value).draw();
    //         }
    //     });
    // });
    //
    // $('#edit').on('show.bs.modal', function(event) {
    //     var button = $(event.relatedTarget);
    //     var user_id = button.data('user-id');
    //     var modal = $(this);
    //     $.ajax({
    //         type: "GET",
    //         url: window.domainUrl + "/" + user_id,
    //         headers: { "X-CSRF-Token": window.tokenCsrf },
    //         success: function(result) {
    //
    //             modal.find('.modal-body #user_id').val(result.id);
    //             modal.find('.modal-body #name').val(result.name);
    //             modal.find('.modal-body #surname').val(result.surname);
    //             modal.find('.modal-body #username').val(result.username);
    //             modal.find('.modal-body #user_type').val(result.user_type);
    //             if (result.company_id != null) {
    //                 modal.find('.modal-body #company_id').val(result.company_id);
    //             }
    //
    //             modal.find('.modal-body #country').val(result.country);
    //             if (result.user_type === 3) {
    //                 modal.find('.modal-body #app_code').val(result.app_code);
    //             } else {
    //                 $('#app-zone').hide();
    //             }
    //
    //         },
    //         error: function(xhr) {
    //             console.error("no se pudo obtener los datos");
    //         }
    //     });
    //
    // });
});
