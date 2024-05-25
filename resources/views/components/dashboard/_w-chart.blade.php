{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-chart-three/>.
* 
*/

--}}


<div class="widget widget-chart-three">
    <div class="widget-heading">
        <div class="">
            <h5 class="">Chart Pagu dan Realisasi {{ $year }}</h5>
        </div>

        <div class="dropdown ">
            <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-more-horizontal">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="19" cy="12" r="1"></circle>
                    <circle cx="5" cy="12" r="1"></circle>
                </svg>
            </a>

            <div class="dropdown-menu left" aria-labelledby="uniqueVisitors">
                <a class="dropdown-item" href="?year=2024">2024</a>
                <a class="dropdown-item" href="?year=2025">2025</a>
            </div>
        </div>
    </div>

    <div class="widget-content">
        <div id="chartPagu"></div>
    </div>
</div>

<script>
    /**
     *
     * Widget Chart Three
     *
     **/

    window.addEventListener("load", function() {
        try {
            let getcorkThemeObject = sessionStorage.getItem("theme");
            let getParseObject = JSON.parse(getcorkThemeObject);
            let ParsedObject = getParseObject;

            if (ParsedObject.settings.layout.darkMode) {
                var Theme = "dark";

                Apex.tooltip = {
                    theme: Theme,
                };

                /**
          ==============================
          |    @Options Charts Script   |
          ==============================
        */

                /*
          ===================================
              Unique Visitors | Options
          ===================================
        */

                var d_1options1 = {
                    chart: {
                        height: 350,
                        type: "bar",
                        toolbar: {
                            show: false,
                        },
                    },
                    colors: ["#622bd7", "#ffbb44"],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "55%",
                            endingShape: "rounded",
                            borderRadius: 10,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        position: "bottom",
                        horizontalAlign: "center",
                        fontSize: "14px",
                        markers: {
                            width: 10,
                            height: 10,
                            offsetX: -5,
                            offsetY: 0,
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 8,
                        },
                    },
                    grid: {
                        borderColor: "#191e3a",
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ["transparent"],
                    },
                    series: [{
                            name: "Direct",
                            data: [58, 44, 55, 57, 56, 61, 58, 63, 60, 66, 56, 63],
                        },
                        {
                            name: "Organic",
                            data: [
                                91, 76, 85, 101, 98, 87, 105, 91, 114, 94, 66, 70,
                            ],
                        },
                    ],
                    xaxis: {
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec",
                        ],
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: Theme,
                            type: "vertical",
                            shadeIntensity: 0.3,
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 0.8,
                            stops: [0, 100],
                        },
                    },
                    tooltip: {
                        marker: {
                            show: false,
                        },
                        theme: Theme,
                        y: {
                            formatter: function(val) {
                                return val;
                            },
                        },
                    },
                    responsive: [{
                        breakpoint: 767,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 0,
                                    columnWidth: "50%",
                                },
                            },
                        },
                    }, ],
                };
            } else {
                var Theme = "dark";

                Apex.tooltip = {
                    theme: Theme,
                };

                /**
          ==============================
          |    @Options Charts Script   |
          ==============================
        */

                /*
          ===================================
              Unique Visitors | Options
          ===================================
        */

                var d_1options1 = {
                    chart: {
                        height: 350,
                        type: "bar",
                        toolbar: {
                            show: false,
                        },
                    },
                    colors: ["#622bd7", "#ffbb44"],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "55%",
                            endingShape: "rounded",
                            borderRadius: 10,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        position: "bottom",
                        horizontalAlign: "center",
                        fontSize: "14px",
                        markers: {
                            width: 10,
                            height: 10,
                            offsetX: -5,
                            offsetY: 0,
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 8,
                        },
                    },
                    grid: {
                        borderColor: "#e0e6ed",
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ["transparent"],
                    },
                    series: [{
                            name: "Pagu",
                            data: @json($chartPagu['pagu']),
                        },
                        {
                            name: "Realisasi / Serapan",
                            data: @json($chartPagu['realisasi']),
                        },
                    ],
                    xaxis: {
                        categories: @json($chartPagu['code']),
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: Theme,
                            type: "vertical",
                            shadeIntensity: 0.3,
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 0.8,
                            stops: [0, 100],
                        },
                    },
                    tooltip: {
                        marker: {
                            show: false,
                        },
                        theme: Theme,
                        y: {
                            formatter: function(val) {
                                return val;
                            },
                        },
                    },
                    responsive: [{
                        breakpoint: 767,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 0,
                                    columnWidth: "50%",
                                },
                            },
                        },
                    }, ],
                };
            }

            /**
                ==============================
                |    @Render Charts Script    |
                ==============================
            */

            /*
                ===================================
                    Unique Visitors | Script
                ===================================
            */

            let d_1C_3 = new ApexCharts(
                document.querySelector("#chartPagu"),
                d_1options1
            );
            d_1C_3.render();

            /**
             * =================================================================================================
             * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
             * =================================================================================================
             */

            document
                .querySelector(".theme-toggle")
                .addEventListener("click", function() {
                    let getcorkThemeObject = sessionStorage.getItem("theme");
                    let getParseObject = JSON.parse(getcorkThemeObject);
                    let ParsedObject = getParseObject;

                    // console.log(ParsedObject.settings.layout.darkMode)

                    if (ParsedObject.settings.layout.darkMode) {
                        /*
                ==============================
                |    @Re-Render Charts Script    |
                ==============================
            */

                        /*
                ===================================
                    Unique Visitors | Script
                ===================================
            */

                        d_1C_3.updateOptions({
                            grid: {
                                borderColor: "#191e3a",
                            },
                        });
                    } else {
                        /*
                ==============================
                |    @Re-Render Charts Script    |
                ==============================
            */

                        /*
                ===================================
                    Unique Visitors | Script
                ===================================
            */

                        d_1C_3.updateOptions({
                            grid: {
                                borderColor: "#e0e6ed",
                            },
                        });
                    }
                });
        } catch (e) {
            // statements
            console.log(e);
        }
    });
</script>
