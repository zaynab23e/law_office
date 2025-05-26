@extends('layout')
@section('main')

<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

<div class="container dashboard">
    <div class="row">

       
        <!-- كروت الإحصائيات -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">المستخدمين <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $users }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- المستخدمين الغير مقبولين -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">المستخدمين <span>| الغير مقبولين</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-x"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $unApprovedUsers }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- المستخدمين المقبولين -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">المستخدمين <span>| المقبولين</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $approvedUsers }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- المستخدمين الشهر الحالي -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">المستخدمين <span>| للشهر الحالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $currentMonthUsers }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- العملاء -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">العملاء <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $customers }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- القضايا -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">القضايا <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{  $cases  }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- الجلاسات -->

<div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">الجلاسات <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                        <i class="bi bi-bank"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $Sessions }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الرسم البياني للمستخدمين خلال 7 أيام -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">المستخدمين <span>| آخر 7 أيام</span></h5>
                    <div id="usersChart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const last7Days = @json(array_keys($last7DaysUsers));
                            const dailyUsers = @json(array_values($last7DaysUsers));
                            
                            new ApexCharts(document.querySelector("#usersChart"), {
                                series: [{
                                    name: 'المستخدمين',
                                    data: dailyUsers,
                                }],
                                chart: {
                                    height: 350,
                                    type: 'area',
                                    toolbar: { show: false },
                                },
                                markers: { size: 4 },
                                colors: ['#0e123e'],
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.4,
                                        stops: [0, 90, 100]
                                    }
                                },
                                dataLabels: { enabled: false },
                                stroke: { curve: 'smooth', width: 2 },
                                xaxis: {
                                    type: 'datetime',
                                    categories: last7Days,
                                },
                                yaxis: {
                                    labels: {
                                        formatter: function (val) {
                                            return Math.round(val);
                                        }
                                    },
                                    min: 0,
                                    forceNiceScale: true
                                },
                                tooltip: {
                                    x: {
                                        format: 'dd/MM/yy'
                                    },
                                }
                            }).render();
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- تقويم الأحداث -->
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">التقويم</h5>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ar',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            buttonText: {
                today: 'اليوم',
                month: 'شهر',
                week: 'أسبوع',
                day: 'يوم',
                list: 'قائمة'
            },
            events: [
                {
                    title: 'جلسة استشارة',
                    start: '2025-05-21'
                },
                {
                    title: 'اجتماع عميل',
                    start: '2025-05-22T14:30:00'
                }
            ]
        });

        calendar.render();
    });
</script>

@endsection
