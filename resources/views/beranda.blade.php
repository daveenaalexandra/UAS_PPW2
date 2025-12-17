@push('js')
    <script src="{{ asset('plugins/chartjs-4/chart-4.5.0.js') }}"></script>
    <script>
        // --- CHART 1: GENDER ---
        const ctx1 = document.getElementById('chart1');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                // Ambil Label dari Controller
                labels: {!! json_encode($genderLabels) !!}, 
                datasets: [{
                    label: 'Jumlah',
                    // Ambil Data Angka dari Controller
                    data: {!! json_encode($genderCounts) !!},
                    backgroundColor: [
                        '#3b82f6', // Biru (untuk data pertama)
                        '#ec4899'  // Pink (untuk data kedua)
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    title: {
                        display: true,
                        text: 'Persentase Pegawai Berdasarkan Gender'
                    }
                }
            }
        });

        // --- CHART 2: TOP PEKERJAAN ---
        const ctx2 = document.getElementById('chart2').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                // Ambil Label Nama Pekerjaan dari Controller
                labels: {!! json_encode($jobLabels) !!},
                datasets: [{
                    label: 'Jumlah Pegawai',
                    // Ambil Data Jumlah Pegawai dari Controller
                    data: {!! json_encode($jobCounts) !!},
                    backgroundColor: '#C0392B',
                    borderColor: '#922B21',
                    borderWidth: 1,
                    borderRadius: 4,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 5 Pekerjaan Dengan Jumlah Pegawai Terbanyak'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Agar sumbu Y angkanya bulat (tidak desimal)
                        }
                    },
                }
            }
        });
    </script>
@endpush