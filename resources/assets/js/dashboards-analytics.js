'use strict';

(function () {
  let cardColor, headingColor, labelColor, shadeColor, grayColor;
  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    headingColor = config.colors_dark.headingColor;
    shadeColor = 'dark';
    grayColor = '#5E6692'; // gray color is for stacked bar chart
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    headingColor = config.colors.headingColor;
    shadeColor = '';
    grayColor = '#817D8D';
  }
  //Appointments This Month
  const AppointmentspermonthEl = document.querySelector('#Appointmentspermonth');

  if (AppointmentspermonthEl) {
    fetch('/api/appointments-daily-count') // Fetch data from the API
      .then((response) => response.json())
      .then((data) => {
        const AppointmentspermonthConfig = {
          chart: {
            height: 110,
            type: 'area',
            toolbar: {
              show: true
            },
            sparkline: {
              enabled: true
            }
          },
          markers: {
            colors: 'transparent',
            strokeColors: 'transparent'
          },
          grid: {
            show: false
          },
          colors: [config.colors.success],
          fill: {
            type: 'gradient',
            gradient: {
              shade: shadeColor,
              shadeIntensity: 0.8,
              opacityFrom: 0.6,
              opacityTo: 0.1
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 5,
            curve: 'smooth'
          },
          series: [
            {
              name: 'Appointments',
              data: data.dailyCounts // Use the fetched daily counts
            }
          ],
          xaxis: {
            show: true,
            categories: data.days, // Use the fetched days for the x-axis
            lines: {
              show: false
            },
            labels: {
              show: true, // Ensure labels are visible
              style: {
                colors: '#6e6b7b',
                fontSize: '12px',
                fontFamily: 'Public Sans'
              }
            },
            stroke: {
              width: 0
            },
            axisBorder: {
              show: false
            }
          },
          yaxis: {
            stroke: {
              width: 0
            },
            show: false
          },
          tooltip: {
            enabled: true,
            x: {
              formatter: function (val, opts) {
                return data.days[opts.dataPointIndex]; // Show the day in the tooltip
              }
            },
            y: {
              formatter: function (val) {
                return `${val} Appointments`; // Show the count in the tooltip
              }
            }
          },
          // Responsive settings
          responsive: [
            {
              breakpoint: 1387,
              options: {
                chart: {
                  height: 80
                }
              }
            },
            {
              breakpoint: 1200,
              options: {
                chart: {
                  height: 123
                }
              }
            }
          ]
        };
// Initialize the chart
        const averageDailySales = new ApexCharts(AppointmentspermonthEl, AppointmentspermonthConfig);
        averageDailySales.render();
      })
      .catch((error) => console.error('Error fetching appointments data:', error));
  }

  // Fetch and display the total number of appointments
  const totalAppointmentsEl = document.querySelector('#totalAppointments'); // Ensure this ID exists in your HTML
// Corrected ID to match the HTML element
  if (totalAppointmentsEl) {
    fetch('/api/total-appointments') // Fetch data from the API
      .then((response) => response.json())
      .then((data) => {
        totalAppointmentsEl.textContent = data.totalAppointments; // Update the total appointments count
      })
      .catch((error) => console.error('Error fetching total appointments:', error));
  }
//////////////////////////////////////Appointments This Month///////////////////////////////////////////////////
  // Fetch and display the total number of doctors
  const totalDoctorsEl = document.querySelector('#totalDoctors'); // Ensure this ID exists in your HTML
// Corrected ID to match the HTML element
  if (totalDoctorsEl) {
    fetch('/api/total-doctors') // Corrected API endpoint
      .then((response) => response.json())
      .then((data) => {
        totalDoctorsEl.textContent = data.totalDoctors; // Corrected variable reference
      })
      .catch((error) => console.error('Error fetching total doctors:', error));
  }
/////////////////////////////////////////////Doctor caunter////////////////////////////////////////////////////



// Fetch and display the total number of patients
const totalPatientsEl = document.querySelector('#totalPatients'); // Ensure this ID exists in your HTML

  if (totalPatientsEl) {
    fetch('/api/total-patients') // Corrected API endpoint
      .then((response) => response.json())
      .then((data) => {
        totalDoctorsEl.textContent = data.totalDoctors; // Corrected variable reference
      })
      .catch((error) => console.error('Error fetching total doctors:', error));
  }
  // Fetch and display the total number of patients
  // --------------------------------------------------------------------  // Total Doctors Chart
  const totalDoctorsChartEl = document.querySelector('#totalDoctorsChart');

  if (totalDoctorsChartEl) {
    fetch('/api/total-doctors') // Fetch data from the API
      .then((response) => response.json())
      .then((data) => {
        const totalDoctorsChartOptions = {
          series: [data.totalDoctors], // Use the fetched total doctors count
          chart: {
            height: 300,
            type: 'radialBar'
          },// Customize the chart type
          plotOptions: {
            radialBar: {
              hollow: {
                size: '65%'
              },
              dataLabels: {
                name: {
                  offsetY: -10,
                  color: '#6e6b7b',
                  fontSize: '16px',
                  fontFamily: 'Public Sans'
                },
                value: {
                  offsetY: 5,
                  color: '#7367F0',
                  fontSize: '36px',
                  fontWeight: 'bold',
                  fontFamily: 'Public Sans'
                }
              }
            }
          },// Customize the radial bar chart
          labels: ['Doctors'],
          colors: ['#7367F0'], // Customize the color
          fill: {
            type: 'gradient',
            gradient: {
              shade: 'dark',
              shadeIntensity: 0.5,
              gradientToColors: ['#28C76F'],
              inverseColors: true,
              opacityFrom: 1,
              opacityTo: 0.6,

            }
          }
        };

        const totalDoctorsChart = new ApexCharts(totalDoctorsChartEl, totalDoctorsChartOptions);
        totalDoctorsChart.render();
      })
      .catch((error) => console.error('Error fetching total doctors data:', error));
  }
  /////////////////////////////////////////////Doctor Chart////////////////////////////////////////////////////


  // Weekly Earning Reports Bar Chart
  // --------------------------------------------------------------------
  const weeklyEarningReportsEl = document.querySelector('#weeklyEarningReports'),
    weeklyEarningReportsConfig = {
      // Initialize the chart
      chart: {
        height: 161,
        parentHeightOffset: 0,
        type: 'bar',
        toolbar: {
          show: false
        }
      },//  Customize the chart type
      plotOptions: {
        bar: {
          barHeight: '60%',
          columnWidth: '38%',
          startingShape: 'rounded',
          endingShape: 'rounded',
          borderRadius: 4,
          distributed: true
        }
      },// Customize the bar chart
      grid: {
        show: false,
        padding: {
          top: -30,
          bottom: 0,
          left: -10,
          right: -10
        }
      },//    Customize the grid
      colors: [
        '#7367F0', '#7367F0', '#7367F0', '#7367F0', '#28C76F', '#7367F0', '#7367F0'
      ],
      dataLabels: {
        enabled: false
      },
      series: [
        {
          data: [40, 65, 50, 45, 90, 55, 70] // Hardcoded data for weekly earnings
        }
      ],
      legend: {
        show: false
      },
      xaxis: {
        categories: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: '#a1acb8',
            fontSize: '13px',
            fontFamily: 'Public Sans'
          }
        }
      },// Customize the x-axis
      yaxis: {
        labels: {
          show: false
        }
      },
      tooltip: {
        enabled: true,
        y: {
          formatter: function (val) {
            return `$${val}`;
          }
        }
      }
    };
// Initialize the chart
  if (typeof weeklyEarningReportsEl !== undefined && weeklyEarningReportsEl !== null) {
    const weeklyEarningReports = new ApexCharts(weeklyEarningReportsEl, weeklyEarningReportsConfig);
    weeklyEarningReports.render();
  }



  // Top 3 Diseases Chart
  const topDiseasesEl = document.querySelector('#topDiseasesChart');

  // Fetch data from the API
  fetch('http://127.0.0.1:8000/api/top-diseases')
    .then((response) => response.json())
    .then((data) => {
        const topDiseases = data.top_diseases;

        const topDiseasesConfig = {
            chart: {
                height: 200,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                    distributed: true,
                    borderRadius: 4
                }
            },
            colors: ['#7367F0', '#28C76F', '#EA5455'],
            series: [
                {
                    name: 'Cases',
                    data: Object.values(topDiseases)
                }
            ],
            xaxis: {
                categories: Object.keys(topDiseases),
                labels: {
                    style: {
                        colors: '#a1acb8',
                        fontSize: '13px',
                        fontFamily: 'Public Sans'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#a1acb8',
                        fontSize: '13px',
                        fontFamily: 'Public Sans'
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return `${val} cases`;
                    }
                }
            }
        };

        const topDiseasesChart = new ApexCharts(topDiseasesEl, topDiseasesConfig);
        topDiseasesChart.render();
    })
    .catch((error) => console.error('Error fetching top diseases:', error));


})();
// Fetch and display the total number of patients
document.addEventListener('DOMContentLoaded', function () {
    // Fetch data from the API
    fetch('/api/patient-statistics')
        .then((response) => response.json())
        .then((data) => {
            // Total Patients Chart
            var totalPatientsOptions = {
                series: [{
                    name: 'Patients',
                    data: data.counts // Use the fetched patient counts
                }],
                chart: {
                    type: 'line', // Line chart
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: data.months, // Use the fetched months
                    title: {
                        text: 'Months'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Number of Patients'
                    }
                },
                colors: ['#7367F0'], // Primary color
                grid: {
                    borderColor: '#e7e7e7'
                },
                tooltip: {
                    x: {
                        format: 'MMM'
                    }
                }
            };
// Initialize the chart
            var totalPatientsChart = new ApexCharts(
                document.querySelector("#totalPatientsChart"),
                totalPatientsOptions
            );

            totalPatientsChart.render();
        })
        .catch((error) => console.error('Error fetching patient statistics:', error));
});
document.addEventListener('DOMContentLoaded', function () {
    // Fetch total patients from the API
    fetch('/api/total-patients')
        .then(response => response.json())
        .then(data => {
            // Update the Total Patients counter
            document.getElementById('totalPatients').textContent = data.totalPatients;
        })
        .catch(error => console.error('Error fetching total patients:', error));
});
