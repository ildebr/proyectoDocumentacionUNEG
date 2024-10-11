<x-app-layout>
    <style>
        .hide{
            display: none;
        }

        .plan-row:nth-of-type(2n){
            background-color: #eeeeee;
        }
        th,td{
            width: 100%;
            max-width: 130px !important;
        }
        /* .dt-scroll-body{
            max-height: auto !important;
        }
        tr th:first-of-type, tr td:first-of-type{
            max-width: 70px !important;
        }
        tr th:nth-of-type(3), tr td:nth-of-type(3){
            max-width: 80px !important;
        }  */

        tr{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
        }

        table colgroup{
            display: none
        }
        tfoot tr{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 5px;
        }
    </style>
    <div class="py-12" id="listarplanes">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Lista de planes
                    </h2>

                    <h3>Filtros avanzados</h3>

                    <div class="search-area">
                        <span class="rtl:text-left">Lapso</span>
                        <span class="text-left">Codigo del plan</span>
                        <span class="text-left">Codigo carrera</span>
                        <span class="text-left">Nombre de La carrera</span>
                        <span class="text-left">Estado</span>
                        <span class="text-left">Accion</span>
                    </div>
                    

                    <p><label for="onlyactive"><input type="checkbox" name="onlyactive">Mostrar solo planes activos</label></p>

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="tabla-planes">
                        {{-- <tfoot>
                            <th class="rtl:text-left">Lapso</th>
                            <th class="text-left">Codigo del plan</th>
                            <th class="text-left">Codigo carrera</th>
                            <th class="text-left">Nombre de La carrera</th>
                            <th class="text-left">Estado</th>
                            <th class="text-left">Accion</th>
                        </tfoot> --}}
                        
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="text-left">
                                <th class="rtl:text-left">Lapso</th>
                                <th class="text-left">Codigo del plan</th>
                                <th class="text-left">Codigo carrera</th>
                                <th class="text-left">Nombre de La carrera</th>
                                <th class="text-left">Estado</th>
                                <th class="text-left">Accion</th>
                            </tr>
                        </thead>
                    
                        @foreach ($planes as $plan)
                        <tr class="plan-row">
                            <td>{{$plan->sdd100d_lapso}}</td>
                            <td>{{$plan->sdd100d_cod_plan}}</td>
                            <td>{{$plan->sdd100d_cod_carr}}</td>
                            <td>{{$plan->sdd080d_nom_carr}}</td>
                            <td class="estado">{{$plan->sdd100d_status}}</td>
                            <td>
                                {{-- <a class="cta cta-primary" href="{{ route('general.listarasignaturaslapsocarrera', ['lapso'=>$plan->sdd100d_lapso, 'carrera'=>$plan->sdd100d_cod_carr]) }}">Asignaturas</a> --}}
                                <a class="cta cta-primary" href="{{ route('general.listarasignaturaslapsocarrerav2', ['lapso'=>$plan->sdd100d_lapso, 'carrera'=>$plan->sdd100d_cod_carr, 'version'=>1]) }}">Asignaturas</a>
                            </td>
                        </tr>
                        @endforeach

                        
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
    <script>
        $('[name=onlyactive]').click(e=>{
            console.log(e.target)
            if(e.target.checked){
                plan = document.querySelectorAll('.plan-row')

            plan.forEach(element => {
                estado = element.querySelector('.estado')
                if(estado.innerText == 'I'){
                    estado.parentElement.classList.add('hide')
                }
            });
            }else{
                select = document.querySelectorAll('.hide')

                select.forEach(e=>{
                    e.classList.remove('hide')
                })
            }
        })


        $(document).ready(function () {
        // Setup - add a text input to each footer cell
        // $('#tabla-planes tfoot th').each(function (i) {
        //     var title = $('#tabla-planes thead th')
        //         .eq($(this).index())
        //         .text();
        //     $(this).html(
        //         '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
        //     );
        // });

        $('.search-area span').each(function (i) {
            var title = $('#tabla-planes thead th')
                .eq($(this).index())
                .text();
            $(this).html(
                '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
            );
        });
    
        // DataTable
        var table = $('#tabla-planes').DataTable({
            scrollY: '400px',
            // scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            bAutoWidth : false
        });
    
        // Filter event handler
        // $(table.table().container()).on('keyup', 'tfoot input', function () {
        //     table
        //         .column($(this).data('index'))
        //         .search(this.value)
        //         .draw();
        // });

        $('#listarplanes').on('keyup', '.search-area input', function () {
            table
                .column($(this).data('index'))
                .search(this.value)
                .draw();
        });

        $('table colgroup').remove()
    });
    </script>
</x-app-layout>