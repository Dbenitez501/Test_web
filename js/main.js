$(document).ready(function () {
    $('#example').DataTable({
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        searchPanes: {
            cascadePanes: true,
            dtOpts: {
                dom: 'tp',
                paging: 'true',
                pagingType: 'numbers',
                searching: true,
            }
        },
        columnDefs: [{
            searchPanes: {
                show: true
            },
            targets: [6, 8]
        }
        ],

        //para usar los botones   
        responsive: "true",
        dom: 'BfrtlipP',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                //estilos para el excel
                excelStyles: {
                    //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                    //template:"green_medium" 

                    "template": [
                        "blue_medium",
                        "header_green",
                        "title_medium"
                    ]

                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10; //<-- set fontsize to 16 instead of 10
                    doc.defaultStyle.alignment = 'center';
                },
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
            },
        ],
        "lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10,
    });
});


$(document).ready(function () {
    $('#example2').DataTable({
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        searchPanes: {
            cascadePanes: true,
            dtOpts: {
                dom: 'tp',
                paging: 'true',
                pagingType: 'numbers',
                searching: true,
            }
        },
        columnDefs: [{
            searchPanes: {
                show: true
            },
            targets: [6, 10]
        }
        ],

        //para usar los botones   
        responsive: "true",
        dom: 'BfrtlipP',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                //estilos para el excel
                excelStyles: {
                    //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                    //template:"green_medium" 

                    "template": [
                        "blue_medium",
                        "header_green",
                        "title_medium"
                    ]

                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                },
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10; //<-- set fontsize to 16 instead of 10
                    doc.defaultStyle.alignment = 'center';
                },
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-secondary',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                },
            },
        ],
        "lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10,
    });
});


$(document).ready(function () {
    $('#example3').DataTable({
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        searchPanes: {
            cascadePanes: true,
            dtOpts: {
                dom: 'tp',
                paging: 'true',
                pagingType: 'numbers',
                searching: true,
            }
        },
        columnDefs: [{
            searchPanes: {
                show: true
            },
            targets: [1, 2, 5]
        }
        ],

        //para usar los botones   
        responsive: "true",
        dom: 'BfrtlipP',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                //estilos para el excel
                excelStyles: {
                    //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                    //template:"green_medium" 

                    "template": [
                        "blue_medium",
                        "header_green",
                        "title_medium"
                    ]

                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10; //<-- set fontsize to 16 instead of 10
                    doc.defaultStyle.alignment = 'center';
                },
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-secondary',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
            },
        ],
        "lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10,
    });
});


$(document).ready(function () {
    $('#example4').DataTable({
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        searchPanes: {
            cascadePanes: true,
            dtOpts: {
                dom: 'tp',
                paging: 'true',
                pagingType: 'numbers',
                searching: true,
            }
        },
        columnDefs: [{
            searchPanes: {
                show: true
            },
            targets: [4, 5]
        }
        ],

        //para usar los botones   
        responsive: "true",
        dom: 'BfrtlipP',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                //estilos para el excel
                excelStyles: {
                    //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                    //template:"green_medium" 

                    "template": [
                        "blue_medium",
                        "header_green",
                        "title_medium"
                    ]

                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10; //<-- set fontsize to 16 instead of 10
                    doc.defaultStyle.alignment = 'center';
                },
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-secondary',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
            },
        ],
        "lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10,
    });
});

$(document).ready(function () {
    $('#example5').DataTable({
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        searchPanes: {
            cascadePanes: true,
            dtOpts: {
                dom: 'tp',
                paging: 'true',
                pagingType: 'numbers',
                searching: true,
            }
        },
        columnDefs: [{
            searchPanes: {
                show: true
            },
            targets: [1, 2, 4, 6, 7, 8]
        }
        ],

        //para usar los botones   
        responsive: "true",
        dom: 'BfrtlipP',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                //estilos para el excel
                excelStyles: {
                    //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                    //template:"green_medium" 

                    "template": [
                        "blue_medium",
                        "header_green",
                        "title_medium"
                    ]

                },
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                orientation: 'landscape',
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10; //<-- set fontsize to 16 instead of 10
                    doc.defaultStyle.alignment = 'center';
                },
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-secondary',
                orientation: 'landscape',
            },
        ],
        "lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10,
    });
});



$(document).ready(function () {
    $('#example6').DataTable({
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        searchPanes: {
            cascadePanes: true,
            dtOpts: {
                dom: 'tp',
                paging: 'true',
                pagingType: 'numbers',
                searching: true,
            }
        },
        columnDefs: [{
            searchPanes: {
                show: true
            },
            targets: [4, 5]
        }
        ],

        //para usar los botones   
        responsive: "true",
        dom: 'BfrtlipP',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                //estilos para el excel
                excelStyles: {
                    //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                    //template:"green_medium" 

                    "template": [
                        "blue_medium",
                        "header_green",
                        "title_medium"
                    ]

                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10; //<-- set fontsize to 16 instead of 10
                    doc.defaultStyle.alignment = 'center';
                },
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
            },
        ],
        "lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10,
    });
});