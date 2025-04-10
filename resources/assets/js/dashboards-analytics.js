/**
 * Dashboard Analytics
 */

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

  // swiper loop and autoplay
  // --------------------------------------------------------------------
  const swiperWithPagination = document.querySelector('#swiper-with-pagination-cards');
  if (swiperWithPagination) {
    new Swiper(swiperWithPagination, {
      loop: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false
      },
      pagination: {
        clickable: true,
        el: '.swiper-pagination'
      }
    });
  }

  // Average Daily Sales (Dynamic Data from Appointments Table)
  // --------------------------------------------------------------------
  const averageDailySalesEl = document.querySelector('#averageDailySales');

  if (averageDailySalesEl) {
    fetch('/api/appointments-daily-count') // Fetch data from the API
      .then((response) => response.json())
      .then((data) => {
        const averageDailySalesConfig = {
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

        const averageDailySales = new ApexCharts(averageDailySalesEl, averageDailySalesConfig);
        averageDailySales.render();
      })
      .catch((error) => console.error('Error fetching appointments data:', error));
  }

  // Fetch and display the total number of appointments
  const totalAppointmentsEl = document.querySelector('#totalAppointments'); // Ensure this ID exists in your HTML

  if (totalAppointmentsEl) {
    fetch('/api/total-appointments') // Fetch data from the API
      .then((response) => response.json())
      .then((data) => {
        totalAppointmentsEl.textContent = data.totalAppointments; // Update the total appointments count
      })
      .catch((error) => console.error('Error fetching total appointments:', error));
  }

  // Fetch and display the total number of doctors
  const totalDoctorsEl = document.querySelector('#totalDoctors'); // Ensure this ID exists in your HTML

  if (totalDoctorsEl) {
    fetch('/api/total-doctors') // Corrected API endpoint
      .then((response) => response.json())
      .then((data) => {
        totalDoctorsEl.textContent = data.totalDoctors; // Corrected variable reference
      })
      .catch((error) => console.error('Error fetching total doctors:', error));
  }

  // Total Doctors Chart
  // --------------------------------------------------------------------
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
          },
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
          },
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
              stops: [0, 100]
            }
          }
        };

        const totalDoctorsChart = new ApexCharts(totalDoctorsChartEl, totalDoctorsChartOptions);
        totalDoctorsChart.render();
      })
      .catch((error) => console.error('Error fetching total doctors data:', error));
  }

  // Doctors Growth Chart
  // --------------------------------------------------------------------
  const doctorsGrowthChartEl = document.querySelector('#doctorsGrowthChart');

  if (doctorsGrowthChartEl) {
    fetch('/api/doctors-growth') // Fetch data from the API
      .then((response) => response.json())
      .then((data) => {
        const doctorsGrowthChartOptions = {
          chart: {
            height: 300,
            type: 'line',
            toolbar: {
              show: true
            }
          },
          series: [
            {
              name: 'Doctors Added',
              data: data.growthCounts // Use the fetched growth data
            }
          ],
          xaxis: {
            categories: data.months, // Use the fetched months for the x-axis
            title: {
              text: 'Months'
            },
            labels: {
              style: {
                colors: '#6e6b7b',
                fontSize: '12px',
                fontFamily: 'Public Sans'
              }
            }
          },
          yaxis: {
            title: {
              text: 'Number of Doctors'
            },
            labels: {
              style: {
                colors: '#6e6b7b',
                fontSize: '12px',
                fontFamily: 'Public Sans'
              }
            }
          },
          colors: ['#7367F0'], // Customize the color
          stroke: {
            width: 3,
            curve: 'smooth'
          },
          tooltip: {
            enabled: true,
            x: {
              formatter: function (val, opts) {
                return data.months[opts.dataPointIndex]; // Show the month in the tooltip
              }
            },
            y: {
              formatter: function (val) {
                return `${val} Doctors`; // Show the count in the tooltip
              }
            }
          },
          grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 5
          }
        };

        const doctorsGrowthChart = new ApexCharts(doctorsGrowthChartEl, doctorsGrowthChartOptions);
        doctorsGrowthChart.render();
      })
      .catch((error) => console.error('Error fetching doctors growth data:', error));
  }

  // Earning Reports Bar Chart
  // --------------------------------------------------------------------
  const weeklyEarningReportsEl = document.querySelector('#weeklyEarningReports'),
    weeklyEarningReportsConfig = {
      chart: {
        height: 161,
        parentHeightOffset: 0,
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          barHeight: '60%',
          columnWidth: '38%',
          startingShape: 'rounded',
          endingShape: 'rounded',
          borderRadius: 4,
          distributed: true
        }
      },
      grid: {
        show: false,
        padding: {
          top: -30,
          bottom: 0,
          left: -10,
          right: -10
        }
      },
      colors: [
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors.primary,
        config.colors_label.primary,
        config.colors_label.primary
      ],
      dataLabels: {
        enabled: false
      },
      series: [
        {
          data: [40, 65, 50, 45, 90, 55, 70]
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
            colors: labelColor,
            fontSize: '13px',
            fontFamily: 'Public Sans'
          }
        }
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      tooltip: {
        enabled: false
      },
      responsive: [
        {
          breakpoint: 1025,
          options: {
            chart: {
              height: 199
            }
          }
        }
      ]
    };
  if (typeof weeklyEarningReportsEl !== undefined && weeklyEarningReportsEl !== null) {
    const weeklyEarningReports = new ApexCharts(weeklyEarningReportsEl, weeklyEarningReportsConfig);
    weeklyEarningReports.render();
  }

  // Support Tracker - Radial Bar Chart
  // --------------------------------------------------------------------
  const supportTrackerEl = document.querySelector('#supportTracker'),
    supportTrackerOptions = {
      series: [85],
      labels: ['Completed Task'],
      chart: {
        height: 360,
        type: 'radialBar'
      },
      plotOptions: {
        radialBar: {
          offsetY: 10,
          startAngle: -140,
          endAngle: 130,
          hollow: {
            size: '65%'
          },
          track: {
            background: cardColor,
            strokeWidth: '100%'
          },
          dataLabels: {
            name: {
              offsetY: -20,
              color: labelColor,
              fontSize: '13px',
              fontWeight: '400',
              fontFamily: 'Public Sans'
            },
            value: {
              offsetY: 10,
              color: headingColor,
              fontSize: '38px',
              fontWeight: '400',
              fontFamily: 'Public Sans'
            }
          }
        }
      },
      colors: [config.colors.primary],
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          shadeIntensity: 0.5,
          gradientToColors: [config.colors.primary],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 0.6,
          stops: [30, 70, 100]
        }
      },
      stroke: {
        dashArray: 10
      },
      grid: {
        padding: {
          top: -20,
          bottom: 5
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      },
      responsive: [
        {
          breakpoint: 1025,
          options: {
            chart: {
              height: 330
            }
          }
        },
        {
          breakpoint: 769,
          options: {
            chart: {
              height: 280
            }
          }
        }
      ]
    };
  if (typeof supportTrackerEl !== undefined && supportTrackerEl !== null) {
    const supportTracker = new ApexCharts(supportTrackerEl, supportTrackerOptions);
    supportTracker.render();
  }

  // Total Earning Chart - Bar Chart
  // --------------------------------------------------------------------
  const totalEarningChartEl = document.querySelector('#totalEarningChart'),
    totalEarningChartOptions = {
      series: [
        {
          name: 'Earning',
          data: [15, 10, 20, 8, 12, 18, 12, 5]
        },
        {
          name: 'Expense',
          data: [-7, -10, -7, -12, -6, -9, -5, -8]
        }
      ],
      chart: {
        height: 175,
        parentHeightOffset: 0,
        stacked: true,
        type: 'bar',
        toolbar: { show: false }
      },
      tooltip: {
        enabled: false
      },
      legend: {
        show: false
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '20%',
          borderRadius: 6,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      fill: {
        opacity: [1, 1]
      },
      colors: [config.colors.primary, config.colors.secondary],
      dataLabels: {
        enabled: false
      },
      grid: {
        show: false,
        padding: {
          top: -40,
          bottom: -20,
          left: -10,
          right: -2
        }
      },
      xaxis: {
        labels: {
          show: false
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      responsive: [
        {
          breakpoint: 1468,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '22%'
              }
            }
          }
        },
        {
          breakpoint: 1197,
          options: {
            chart: {
              height: 212
            },
            plotOptions: {
              bar: {
                borderRadius: 8,
                columnWidth: '26%'
              }
            }
          }
        },
        {
          breakpoint: 783,
          options: {
            chart: {
              height: 210
            },
            plotOptions: {
              bar: {
                borderRadius: 6,
                columnWidth: '28%'
              }
            }
          }
        },
        {
          breakpoint: 589,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '16%'
              }
            }
          }
        },
        {
          breakpoint: 520,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 6,
                columnWidth: '18%'
              }
            }
          }
        },
        {
          breakpoint: 426,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 5,
                columnWidth: '20%'
              }
            }
          }
        },
        {
          breakpoint: 381,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '24%'
              }
            }
          }
        }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof totalEarningChartEl !== undefined && totalEarningChartEl !== null) {
    const totalEarningChart = new ApexCharts(totalEarningChartEl, totalEarningChartOptions);
    totalEarningChart.render();
  }

  //  For Datatable
  // --------------------------------------------------------------------
  var dt_projects_table = $('.datatables-projects');

  if (dt_projects_table.length) {
    var dt_project = dt_projects_table.DataTable({
      ajax: assetsPath + 'json/user-profile.json',
      columns: [
        { data: '' },
        { data: 'id' },
        { data: 'project_name' },
        { data: 'project_leader' },
        { data: '' },
        { data: 'status' },
        { data: '' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          // For Checkboxes
          targets: 1,
          orderable: false,
          searchable: false,
          responsivePriority: 3,
          checkboxes: true,
          render: function () {
            return '<input type="checkbox" class="dt-checkboxes form-check-input">';
          },
          checkboxes: {
            selectAllRender: '<input type="checkbox" class="form-check-input">'
          }
        },
        {
          // Avatar image/badge, Name and post
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $user_img = full['project_img'],
              $name = full['project_name'],
              $date = full['date'];
            if ($user_img) {
              // For Avatar image
              var $output =
                '<img src="' + assetsPath + 'img/icons/brands/' + $user_img + '" alt="Avatar" class="rounded-circle">';
            } else {
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'];
              var $state = states[stateNum],
                $name = full['project_name'],
                $initials = $name.match(/\b\w/g) || [];
              $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
              $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
            }
            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-left align-items-center">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar avatar-sm me-3">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<h6 class="text-truncate mb-0">' +
              $name +
              '</h6>' +
              '<small class="text-truncate">' +
              $date +
              '</small>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // Task
          targets: 3,
          render: function (data, type, full, meta) {
            var $task = full['project_leader'];
            return '<span class="text-heading">' + $task + '</span>';
          }
        },
        {
          // Teams
          targets: 4,
          orderable: false,
          searchable: false,
          render: function (data, type, full, meta) {
            var $team = full['team'],
              $team_item = '',
              $team_count = 0;
            for (var i = 0; i < $team.length; i++) {
              $team_item +=
                '<li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kim Karlos" class="avatar avatar-sm pull-up">' +
                '<img class="rounded-circle" src="' +
                assetsPath +
                'img/avatars/' +
                $team[i] +
                '"  alt="Avatar">' +
                '</li>';
              $team_count++;
              if ($team_count > 2) break;
            }
            if ($team_count > 2) {
              var $remainingAvatars = $team.length - 3;
              if ($remainingAvatars > 0) {
                $team_item +=
                  '<li class="avatar avatar-sm">' +
                  '<span class="avatar-initial rounded-circle pull-up text-heading" data-bs-toggle="tooltip" data-bs-placement="top" title="' +
                  $remainingAvatars +
                  ' more">+' +
                  $remainingAvatars +
                  '</span >' +
                  '</li>';
              }
            }
            var $team_output =
              '<div class="d-flex align-items-center">' +
              '<ul class="list-unstyled d-flex align-items-center avatar-group mb-0 z-2">' +
              $team_item +
              '</ul>' +
              '</div>';
            return $team_output;
          }
        },
        {
          // Label
          targets: -2,
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            return (
              '<div class="d-flex align-items-center">' +
              '<div class="progress w-100 me-3" style="height: 6px;">' +
              '<div class="progress-bar" style="width: ' +
              $status_number +
              '" aria-valuenow="' +
              $status_number +
              '" aria-valuemin="0" aria-valuemax="100"></div>' +
              '</div>' +
              '<span class="text-heading">' +
              $status_number +
              '</span></div>'
            );
          }
        },
        {
          // Actions
          targets: -1,
          searchable: false,
          title: 'Action',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
              '<a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-md"></i></a>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              '<a href="javascript:;" class="dropdown-item">Details</a>' +
              '<a href="javascript:;" class="dropdown-item">Archive</a>' +
              '<div class="dropdown-divider"></div>' +
              '<a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a>' +
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[2, 'desc']],
      dom: '<"card-header pb-0 pt-sm-0"<"head-label text-center"><"d-flex justify-content-center justify-content-md-end"f>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 5,
      lengthMenu: [5, 10, 25, 50, 75, 100],
      language: {
        search: '',
        searchPlaceholder: 'Search Project',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of "' + data['project_name'] + '" Project';
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
    $('div.head-label').html('<h5 class="card-title mb-0">Project List</h5>');
  }

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
})();
