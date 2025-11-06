<style>
    .banner {
        background: url('<?php echo BASE_URL; ?>public/img/Redragon-banner.webp') no-repeat center center;
        background-size: cover;
        height: 400px; /* Altura aumentada */
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3); /* Sombra más suave y profunda */
    }

    .banner-content {
        background-color: rgba(0, 0, 0, 0.6); /* Un poco más oscuro para mejor contraste */
        padding: 40px 60px;
        border-radius: 12px;
    }

    .banner h1 {
        font-size: 56px; /* Texto más grande */
        margin-bottom: 20px;
    }

    .banner p {
        font-size: 20px; /* Texto más visible */
        margin: 0;
    }
</style>

<div class="banner">
    <div class="banner-content">
        <h1><?php echo $title; ?></h1>
        <p>Bienvenido al sistema de gestión para la venta de accesorios</p>
        <p>Usa el menú superior para navegar</p>
    </div>
</div>
<div style="display: flex; justify-content: center; gap: 40px; margin-bottom: 50px; flex-wrap: wrap;">

    <!-- Gráfico de barras -->
    <div style="flex: 1 1 350px; max-width: 450px;">
        <canvas id="ventasBarChart" style="height: 350px;"></canvas>
    </div>

    <!-- Gráfico de pastel -->
    <div style="flex: 1 1 350px; max-width: 450px;">
        <canvas id="ventasPieChart" style="height: 350px;"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctxBar = document.getElementById('ventasBarChart').getContext('2d');
    const ventasBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
            datasets: [{
                label: 'Ventas del Mes',
                data: [120, 150, 180, 130],
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1,
                borderRadius: 4,
                hoverBackgroundColor: 'rgba(220, 53, 69, 0.9)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // importante para que respete la altura fija
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 20 }
                }
            },
            plugins: {
                legend: {
                    labels: { font: { size: 16 } }
                }
            }
        }
    });

    const ctxPie = document.getElementById('ventasPieChart').getContext('2d');
    const ventasPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Accesorios A', 'Accesorios B', 'Accesorios C', 'Accesorios D'],
            datasets: [{
                label: 'Ventas por Producto',
                data: [300, 150, 100, 50],
                backgroundColor: [
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(23, 162, 184, 0.8)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // también para el pie chart
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 } }
                }
            }
        }
    });
</script>

