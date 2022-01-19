<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Administración</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
        <!-- <link rel="stylesheet" href="../css/soluciones.css?v=<?php //echo(rand()); ?>"> -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
        <!-- Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!--datables CSS básico-->
        <link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css?v=<?php echo(rand()); ?>"/>
        <!--datables estilo bootstrap 4 CSS-->  
        <link rel="stylesheet"  type="text/css" href="../datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css?v=<?php echo(rand()); ?>">
            
        <!--font awesome con CDN-->  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css?v=<?php echo(rand()); ?>" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <!-- searchPanes -->
        <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchPanes.dataTables.min.css?v=<?php echo(rand()); ?>">
        <!-- select -->
        <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css?v=<?php echo(rand()); ?>">
        <script src="../jquery/jquery-3.3.1.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                let state = false;
                let confId = 10;
                let tipoId = "p";
                cambiarState();

                var tablaGenerada = generarTabla(confId, tipoId, state);

                $("#tipo").change(function(){
                    var tipoId = $("#tipo").val();
                    $.ajax({
                        url: '../include/data_filtrado.php',
                        method: 'post',
                        data: 'tipoId=' + tipoId
                    }).done(function(conferencias){
                        console.log(conferencias);
                        conferencias = JSON.parse(conferencias);
                        $('#conf').empty();
                        $('#conf').append('<option selected="" disabled="">Seleccione una opción</option>');
                        conferencias.forEach(function(conferencia){
                            const id = conferencia.id_presencial || conferencia.id_virtual;                            
                            $('#conf').append('<option id="opt" value=' + id + '>' + conferencia.titulo + ', ' + conferencia.fecha_inicio + '</option>')
                        })
                        state=true;
                        cambiarState();
                    })
                });

                $("#conf").change(function(){
                    confId = $("#conf").val();
                    tipoId = $("#tipo").val();
                    state=false;
                    cambiarState();

                    $('#example5').DataTable().destroy();
                    tablaGenerada = generarTabla(confId, tipoId, state);
                    reloadTable(tablaGenerada);

                    /* $.ajax({
                        url: '../include/data_filtrado.php',
                        method: 'post',
                        data: {confe: confId, tipo: tipoId}
                    }).done(function(personas){
                        console.log(personas);
                        personas = JSON.parse(personas);
                        $('#datos').empty();
                        

                        personas.forEach(function(persona){                            
                            const str = `<tr>
                            <td data-label="Nombre">${persona.nombre}</td>
                            <td data-label="Correo">${persona.correo}</td>
                            <td data-label="Tipo">${persona.tipo}</td>
                            <td data-label="Sexo">${persona.sexo}</td>
                            <td data-label="Asistencia">${persona.asistencia}</td>
                            </tr>`;
                            $('#datos').append(str);
                        })
                        reloadTable(tablaGenerada);
                    }) */
                })

                function cambiarState() {
                    if(state) {
                        $('#titulo').addClass("hidden");
                    } else {
                        $('#titulo').removeClass("hidden");
                    }
                }

                function reloadTable(tabla) {
                    tabla.ajax.reload(null, false);
                }

                function generarTabla(idConf, idTipo, state) {                    
                    var table = $('#example5').DataTable({
                        "processing" : true,
                        "serverSide" : true,
                        "ajax": {
                            url: "../include/generar_DataTable.php",
                            type: "POST",
                            data: {confe: idConf, tipo: idTipo, estado: state}
                        },
                        /* language: {
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
                                searching: false,
                            }
                        },
                        columnDefs: [{
                            searchPanes: {
                                show: true
                            },
                            targets: [2, 3, 4]
                        }
                        ],

                        //para usar los botones   
                        responsive: "true",
                        dom: 'BfrtilpP',
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
                            },
                        ] */
                    });
                    return table;
                }




            });
        </script>

    </head>
    <body>

    <section class="sub-header">
            <nav>
                <a href="../controlador.php"><img src="../img/logo_fime.png"></a>
                <div class="nav-links" id="navLinks">
                    <i class="fas fa-times" onclick="ocultarMenu()"></i>
                    <ul>
                        <li><a href="../controlador.php">INICIO</a></li>
                        <li><a href="https://www.fime.uanl.mx/" target="_blank" rel="noopener noreferrer">FIME</a></li>
                        <li><a href='../include/logout.php'>CERRAR SESIÓN</a></li>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>
            <h1>Administración</h1>
            <p>Panel para administradores</p>
            
        </section>

        <section class="inicio-sesion">
            <div class="row row-sesion">
                <div class="sesion-col">
                    <h2 style="color:#fff;">Filtrado por conferencias</h2>
                    <hr>
                    <div class="usuario-container">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo">
                            <option selected="" disabled="">Seleccione una opción</option>
                            <option value="p">Presencial</option>
                            <option value="v">Virtual</option>
                        </select>
                    </div>
                    <div class="usuario-container">
                        <label for="conf">Conferencia</label>
                        <select name="conf" id="conf">
                            <option selected="" disabled="">Seleccione una opción</option>
                        </select>
                    </div>
                </div>
                
            </div>
        </section>

        <div class="tablas_seccion_conferencias" id="titulo">
                <h2>Registros</h2>
                <br>
                <div class="table-responsive">
                <table id="example5" class="table_v_admin">
                    <thead>    
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Tipo</th>
                            <th>Sexo</th>
                            <th>Asistencia</th>
                        </tr>
                    </thead>            
                </table>
                </div>
        </div>

        <footer>
            <div class="contact-info">
                <h5><span>| A</span>cerca de nosotros</h5>
                <p><i class="fas fa-map-marker-alt"></i>   Av. Universidad S/N, Ciudad Universitaria<br>San Nicolás de los Garza, N. L., C.P. 66455</p>
                <br>
                <p><i class="fas fa-phone-alt"></i>    (52) 81 8329 4020</p>
                <br>
                <p><i class="fas fa-envelope"></i>    contacto@fime.uanl.mx</p>
                <br>
                <a href="https://www.uanl.mx/enlinea/" style="color: #fff;"><i class="fas fa-desktop"></i>   Servicios en línea</a>
            </div>
            <div class="icons">
                <h5><span>| R</span>edes Sociales</h5>
                <a href="https://www.facebook.com/fime.oficial/" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i>Facebook</a>
                <a href="https://www.instagram.com/fime.oficial/?hl=es-la" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i>Instagram</a>
                <a href="https://twitter.com/fime_oficial?lang=es" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i>Twitter</a>
                <a href="https://www.youtube.com/channel/UCfmQiSfgZ5cMDe-kAYplmww/featured" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i>Youtube</a>
            </div>
            <div class="logo-area"><img src="../img/Logos.png" alt=""></div>
        </footer>

        <script>
            //JAVASCRIPT PARA MOSTRAR Y OCULTAR EL MENU
            var navLinks = document.getElementById("navLinks");
            function mostrarMenu(){
                navLinks.style.right = "0";
            }
            function ocultarMenu(){
                navLinks.style.right = "-210px";
            }
        </script>

        <!-- jQuery, Popper.js, Bootstrap JS -->
        
        <script src="../popper/popper.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        
        <!-- datatables JS -->
        <!-- <script type="text/javascript" src="../datatables/datatables.min.js"></script>     -->
        
        <!-- para usar botones en datatables JS -->  
        <!-- <script src="../datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>   -->
        <!-- <script src="../datatables/JSZip-2.5.0/jszip.min.js"></script>     -->
        <!-- <script src="../datatables/pdfmake-0.1.36/pdfmake.min.js"></script>     -->
        <!-- <script src="../datatables/pdfmake-0.1.36/vfs_fonts.js"></script> -->
        <!-- <script src="../datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script> -->

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-html5-1.7.1/b-print-1.7.1/sp-1.3.0/datatables.js"></script>
        
        <!-- código JS propìo-->    
        <script type="text/javascript" src="../js/main.js"></script>  
        
        <!-- searchPanes   -->
    <!-- <script src="https://cdn.datatables.net/searchpanes/1.0.1/js/dataTables.searchPanes.min.js"></script> -->
    <!-- select -->
    <!-- <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script> -->
    </body>
</html>