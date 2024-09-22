@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">
@endsection

@section('content')
    <div class="row">
        @include('theme.admin.header')
        @include('theme.admin.aside3')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="inform-admin">
            <div class="row p-3">
                <div class="col text-end">
                    <button class="btn btn-sm btn-outline-secondary" onclick="captureAndDownloadPDF()">Generar PDF</button>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-lg-5 col-12 text-center">
                    <div class="row">
                        <div class="col">
                            <?php
                                $totalUsers = \App\Models\User::where('fk_type', '!=', 1)->count();
                            ?>
                            <p>Total de Usarios: {{$totalUsers}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <canvas id="typeUsers" class="my-4 w-100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12 text-center">
                    <div class="row">
                        <div class="col">
                            <p>Registros por fecha</p>
                        </div>
                    </div>
                    <div class="row justify-content-between px-3">
                        <div class="col">
                            <label for="startDate">Fecha inicio:</label>
                            <input type="date" id="startDate" class="form-control">
                        </div>
                        <div class="col">
                            <label for="endDate">Fecha fin:</label>
                            <input type="date" id="endDate" class="form-control">
                        </div>
                        <div class="col-2">
                            <button id="filterButton" class="btn btn-primary mt-4">Filtrar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <canvas id="registrationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-12 text-center">
                    <div class="row">
                        <div class="col">
                            <p>Recetas por tipo</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <canvas id="recipeChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-12 text-center">
                    <div class="row h-100 align-items-center">
                        <div class="col">
                            <?php
                            $totalRecipes = \App\Models\Recipe::all()->count();
                            ?>
                            <h3>Total de Recetas</h3>
                            <h3>{{$totalRecipes}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $recipes = \App\Models\Recipe::orderBy('created_at','desc')->paginate(5);
            ?>
            <h2>Recetas</h2>
            <div class="table-responsive small">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Fecha creacion</th>
                        <th scope="col">Receta</th>
                        <th scope="col">Creador</th>
                        <th scope="col">Tipo receta</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($recipes as $recipe)
                            <tr>
                                <td>{{ $recipe->created_at ? $recipe->created_at->format('Y-m-d') : 'Desconocido' }}</td>
                                <td>{{ $recipe->name }}</td>
                                <td>{{ $recipe->creator->nickname ?? 'Desconocido' }}</td>
                                <td>{{ $recipe->type->type_recipe ?? 'Desconocido' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$recipes->links()}}
            </div>
        </main>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Usar fetch para obtener los datos desde el controlador
            fetch('{{ route("users.getData") }}')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.type ? item.type : 'Desconocido'); // Maneja el caso nulo
                    const counts = data.map(item => item.count);

                    // Crear la gráfica de dona con Chart.js
                    const ctx = document.getElementById('typeUsers').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels, // Etiquetas para la dona
                            datasets: [{
                                label: 'Cantidad de usuarios por tipo',
                                data: counts, // Cantidades por tipo de usuario
                                backgroundColor: [
                                    '#F2AE2E',
                                    '#4738A6',
                                ],
                                borderColor: [
                                    '#F2AE2E',
                                    '#4738A6',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error al obtener los datos:', error));
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startDate = new Date();
            startDate.setMonth(startDate.getMonth() - 1);
            const endDate = new Date();

            // Convertir las fechas a formato YYYY-MM-DD
            const startDateString = startDate.toISOString().split('T')[0];
            const endDateString = endDate.toISOString().split('T')[0];

            // Establecer las fechas en los inputs de fecha
            document.getElementById('startDate').value = startDateString;
            document.getElementById('endDate').value = endDateString;

            // Cargar los datos para el rango de fechas por defecto
            updateCharts(startDateString, endDateString);

            // Añadir listener al botón de filtro
            document.getElementById('filterButton').addEventListener('click', function () {
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                updateCharts(startDate, endDate);
            });
        });

        function updateCharts(startDate, endDate) {
            fetch(`{{ route("users.getRegistrationData") }}?startDate=${startDate}&endDate=${endDate}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.date);
                    const counts = data.map(item => item.count);

                    renderBarChart(labels, counts);
                })
                .catch(error => console.error('Error al obtener los datos:', error));
        }

        function renderBarChart(labels, data) {
            const ctx = document.getElementById('registrationChart').getContext('2d');
            const registrationChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels, // Fechas de registro
                    datasets: [{
                        label: 'Usuarios registrados',
                        data: data, // Cantidades de usuarios registrados
                        backgroundColor: '#C82EF2',
                        borderColor: '#C82EF2',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true, // El eje Y comenzará en 0
                            ticks: {
                                stepSize: 0.01,  // Los pasos serán de 1 en 1
                                precision: 0  // Sin decimales
                            },
                            title: {
                                display: true,
                                text: 'Número de usuarios',
                                color: 'blue'
                            }
                        },
                        x: {
                            type: 'time', // Si estás trabajando con fechas
                            time: {
                                unit: 'day', // Cambia a 'month', 'week', etc. si es necesario
                                tooltipFormat: 'YYYY-MM-DD'
                            },
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 10, // Cambia para ajustar el número de etiquetas
                                maxRotation: 45,
                                minRotation: 0
                            },
                            title: {
                                display: true,
                                text: 'Fecha de registro',
                                color: 'blue'
                            }
                        }
                    }
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('recipeChart').getContext('2d');

            // Realizar la petición fetch para obtener los datos
            fetch('{{ route("recipes.recipeChartData") }}', { // Cambia la URL a la ruta correcta de tu controlador
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    // Procesar los datos para Chart.js
                    const labels = data.map(item => item.type);
                    const counts = data.map(item => item.count);

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Número de recetas',
                                data: counts,
                                backgroundColor: '#F2622E',
                                borderColor: '#F2622E',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1 // Controla el tamaño de los pasos del eje Y
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                });
        });
    </script>
    <script>
        async function captureAndDownloadPDF() {
            const { jsPDF } = window.jspdf;
            const element = document.getElementById('inform-admin');

            try {
                const canvas = await html2canvas(element);
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');

                // Calcula el tamaño de la imagen en la página del PDF
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 295; // A4 height in mm
                const imgHeight = canvas.height * imgWidth / canvas.width;
                let heightLeft = imgHeight;

                let position = 0;

                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                pdf.save('report.pdf');
            } catch (error) {
                console.error('Error capturando el PDF:', error);
            }
        }
    </script>
@endpush
