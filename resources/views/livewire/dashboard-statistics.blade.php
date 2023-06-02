@php
$flat_colors = collect([
'#2196f3',
'#2196f3dd',
'#7cc5ffaa',
'#9ed2fb88',
'#0fb8ff66',
'#5aceff44',
'#8eddff22',
'#c5edff00',
'#c5edff00',
'#c5edff00',
'#c5edff00',
]);
@endphp
<div class="col-12 p-0">
   <div class="col-12 row p-0 d-flex">
        <div class="col-12 col-lg-6 p-2">
            <div class="col-12 p-0 main-box">
                <div class="col-12 px-0">
                    <div class="col-12 px-3 py-3">
                        <div class="col-12 p-0">
                            <div class="col-12 p-0 row">
                                <div class="col-9">
                                    {{ __('New appointments rates (Last weak)') }}
   
                                </div>
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    

                                    <div class="spinner-grow text-info mx-2" role="status" style="width:15px;height: 15px">
                                      <span class="visually-hidden"></span>
                                    </div>

                                    <span style="font-weight: bold;"><a href="">{{ array_sum($data['appointments']) }}</a></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-12 " style="min-height: 1px;background: var(--border-color);"></div>
                </div>
                <div class="col-12 p-3">
                    <canvas id="appointments-chart">
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 p-2">
            <div class="col-12 p-0 main-box">
                <div class="col-12 px-0">
                    <div class="col-12 px-3 py-3">
                        {{ __('New Invoices (Last weak)')}}
                    </div>
                    <div class="col-12 " style="min-height: 1px;background: var(--border-color);"></div>
                </div>
                <div class="col-12 p-3">
                    <canvas id="new-invoices">
                    </canvas>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
    <script type="module" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script type="module">

        new Chart(document.getElementById('appointments-chart').getContext('2d'), {
            type: 'line',
            data: {     
            labels: [
            @foreach(array_reverse($data['appointments']) as $key => $value)
            "{{$key}}",
            @endforeach
            ],
            datasets: [{
                label: '# معدل المواعيد',
                    data: [
                    @foreach(array_reverse($data['appointments']) as $key => $value)
                    "{{$value}}",
                    @endforeach
                    ],
                        backgroundColor: "#2196f3cc",
                        borderColor: '#2196f3',
                        pointStyle: 'rect',
                        lineTension: '.15',
                        tension: 0.1,
                        fill: true,
                        pointStyle:"circle",
                        pointBorderColor:"#2196f3",
                        pointBackgroundColor:"#fff",
                        pointRadius:4,
                        borderWidth: 3.5,
                }]
            },
            options: {
                responsive:true,
                plugins: {
                    legend: {
                        display:false,
                        labels: {
                            font: {
                                size: 14,
                                family:"kufi-arabic"
                            }
                        }
                    }
                },
                scales: {

                    x: {
                    beginAtZero:false,
                    grid: {
                      display: false
                    }
                  },
                  y: { 
                    grid: {
                      display: true,
                      color:"rgb(3,169,244,0.05)"
                    }
                  },

                },
                hover: {
                    mode: 'index'
                },
                legend: {
                    labels: {

                        fontFamily: 'kufi-arabic',
                        defaultFontFamily: 'kufi-arabic',
                    }
                },
                elements: {
                    line: {
                        tension: 1
                    }
                }
            }
        });

        new Chart(document.getElementById('new-invoices').getContext('2d'), {
            type: 'line',
            data: {     
            labels: [
            @foreach(array_reverse($data['new_invoices']['daysList']) as $day)
            "{{$day}}",
            @endforeach
            ],
            datasets: [{
                label: '# معدل الفواتير الجدد',
                    data: [
                    @foreach(array_reverse($data['new_invoices']['countsList']) as $count)
                    "{{$count}}",
                    @endforeach
                    ],
                        backgroundColor: "#2196f3cc",
                        borderColor: '#2196f3',
                        pointStyle: 'rect',
                        lineTension: '.15',
                        tension: 0.1,
                        fill: true,
                        pointStyle:"circle",
                        pointBorderColor:"#2196f3",
                        pointBackgroundColor:"#fff",
                        pointRadius:4,
                        borderWidth: 3.5,
                }]
            },
            options: {
                responsive:true,
                plugins: {
                    legend: {
                        display:false,
                        labels: {
                            font: {
                                size: 14,
                                family:"kufi-arabic"
                            }
                        }
                    }
                },
                scales: {

                    x: {
                    beginAtZero:false,
                    grid: {
                      display: false
                    }
                  },
                  y: { 
                    grid: {
                      display: true,
                      color:"rgb(3,169,244,0.05)"
                    }
                  },

                },
                hover: {
                    mode: 'index'
                },
                legend: {
                    labels: {

                        fontFamily: 'kufi-arabic',
                        defaultFontFamily: 'kufi-arabic',
                    }
                },
                elements: {
                    line: {
                        tension: 1
                    }
                }
            }
        });
  
    </script>
    
    
    @endsection
</div>