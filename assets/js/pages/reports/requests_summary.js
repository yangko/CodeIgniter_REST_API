/* -----------------------------------------------------------------------------------

*  Reports

*  Request Summary In Flight

*  Description: Showing statistics of requests in bar chart group by request status.

* ------------------------------------------------------------------------------------*/

$(function() {

  // Enable bar chart

  var config = {

    type: "bar",

    data: {

      labels: chartLabels,

      datasets: [

        {

          label: timestamp,

          data: chartData,

          backgroundColor: chartBackground

        }

      ]

    },

    options: {

      hover: {

        animationDuration: 0

      },

      animation: {

        duration: 1,

        onComplete: function() {

          var chartInstance = this.chart,

            ctx = chartInstance.ctx;

 

          ctx.font = Chart.helpers.fontString(

            14,

            "bold",

            Chart.defaults.global.defaultFontFamily

          );

          ctx.textAlign = "center";

          ctx.textBaseline = "bottom";

 

          this.data.datasets.forEach(function(dataset, i) {

            var meta = chartInstance.controller.getDatasetMeta(i);

            meta.data.forEach(function(bar, index) {

              var data = dataset.data[index];

              if (data !== 0) {

                ctx.fillText(data, bar._model.x, bar._model.y - 5);

              }

            });

          });

        }

      },

      legend: {

        display: true,

        labels: {

          boxWidth: 0,

          fontSize: 14,

          fontStyle: "bold",

          fontColor: "#333"

        }

      },

      title: {

        display: true,

        fontSize: 18,

        fontColor: "#333",

        text: "Request Summary in Flight"

      },

      tooltips: {

        enabled: false

      },

      responsive: true,

      maintainAspectRatio: false,

      scales: {

        xAxes: [

          {

            stacked: true,

            gridLines: {

              display: false

            },

            ticks: {

              autoSkip: false

            },

            barPercentage: 0.75

          }

        ],

        yAxes: [

          {

            stacked: true,

            ticks: {

              beginAtZero: true

            }

          }

        ]

      }

    }

  };

 

  var ctx = document.getElementById("myChart").getContext("2d");

  var ReqChart = new Chart(ctx, config);

 

  document.getElementById("myChart").onclick = function(evt) {

    var activePoints = ReqChart.getElementsAtEvent(evt);

    var firstPoint = activePoints[0];

    var label = ReqChart.data.labels[firstPoint._index];

    var value =

      ReqChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];

    if (label !== undefined) {

      window.location.href =

        "/reports/application/request_summary/" +

        encodeURIComponent(label)

          .replace(/\(/g, "%28")

          .replace(/\)/g, "%29");

    }

  };

 

  // Enable dataTable

  $("#req_table").dataTable({

    select: true,

    deferRender: true,

    paging: true,

    dom:

      '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',

    buttons: [

      {

        extend: "csvHtml5",

        className: "btn bg-blue",

        title: "Request Summary - " + label

      },

      {

        extend: "copyHtml5",

        className: "btn bg-blue",

        title: "Request Summary - " + label

      },

      {

        extend: "excelHtml5",

        className: "btn bg-blue",

        title: "Request Summary - " + label

      }

    ],

    columnDefs: [

      {

        // Task History

        targets: [8],

        searchable: false

      }

    ]

  });

 

  // Lightbox

  $('[data-popup="lightbox"]').fancybox({

    padding: 3

  });

});