$(function () {
    const visitorsGraph = document.getElementById('visitors_graph');
    let all_visitors_data = JSON.parse($('#all_visitors_graph_data').val());
    let label = all_visitors_data.map(function (data) {
        return setDateFormatMonth(data.created_at);
    });
    let all_data = all_visitors_data.map(function (data) {
        return data.visitors_count;
    });
    let new_visitors_data = JSON.parse($('#new_visitors_graph_data').val());
    let new_data = new_visitors_data.map(function (data) {
        return data.visitors_count;
    });
    let existing_visitors_data = JSON.parse($('#existing_visitors_graph_data').val());
    let existing_data = existing_visitors_data.map(function (data) {
        return data.visitors_count;
    });
    new Chart(visitorsGraph, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [
                {
                    label: '総顧客数',
                    data: all_data,
                    backgroundColor: ['#1e88e5']
                },
                {
                    label: '新規顧客',
                    data: new_data,
                    backgroundColor: ['#cc6633']
                },
                {
                    label: '既存顧客',
                    data: existing_data,
                    backgroundColor: ['#3cb371']
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#ccc'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#333',
                    },
                    ticks: {
                        color: '#ccc',
                    }
                },
                x: {
                    beginAtZero: true,
                    grid: {
                        color: '#333'
                    },
                    ticks: {
                        color: '#ccc'
                    }
                }
            }
        }
    });
});
$(function () {
    const reservationGraph = document.getElementById('reservation_graph');
    let all_reservation_data = JSON.parse($('#all_reservation_graph_data').val());
    let label = all_reservation_data.map(function (data) {
        return setDateFormatMonth(data.created_at);
    });
    let all_data = all_reservation_data.map(function (data) {
        return data.reservation_rate;
    });
    let new_reservation_data = JSON.parse($('#new_reservation_graph_data').val());
    let new_data = new_reservation_data.map(function (data) {
        return data.reservation_rate;
    });
    let existing_reservation_data = JSON.parse($('#existing_reservation_graph_data').val());
    let existing_data = existing_reservation_data.map(function (data) {
        return data.reservation_rate;
    });
    new Chart(reservationGraph, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [
                {
                    label: '全体予約率',
                    data: all_data,
                    backgroundColor: ['#1e88e5']
                },
                {
                    label: '新規予約率',
                    data: new_data,
                    backgroundColor: ['#cc6633']
                },
                {
                    label: '既存予約率',
                    data: existing_data,
                    backgroundColor: ['#3cb371']
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#ccc'
                    }
                }
            },
            scales: {
                y: {
                    suggestedMin: 0,
                    suggestedMax: 100,
                    beginAtZero: true,
                    grid: {
                        color: '#333',
                    },
                    ticks: {
                        color: '#ccc',
                    }
                },
                x: {
                    beginAtZero: true,
                    grid: {
                        color: '#333'
                    },
                    ticks: {
                        color: '#ccc'
                    }
                }
            }
        }
    });
});
$(function () {
    const advertisement_graph = document.getElementById('advertisement_graph');
    let data = JSON.parse($('#advertisement_graph_data').val());
    new Chart(advertisement_graph, {
        type: 'bar',
        data: {
            labels: ["紹介", "HP", "Instagram", "その他"],
            datasets: [{
                label: '来店きっかけ',
                data: [data['ad1'], data['ad2'], data['ad3'], data['ad_other']],
                backgroundColor: ['#3cb371'],
                borderWidth: 1,
                pointRadius: 7,
                pointHoverRadius: 10,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#333'
                    },
                    ticks: {
                        color: '#ccc'
                    }
                },
                x: {
                    beginAtZero: true,
                    grid: {
                        color: '#333'
                    },
                    ticks: {
                        color: '#ccc'
                    }
                }
            }
        }
    });
});
$(function () {
    const advertisement_graph = document.getElementById('total_sales');
    let sales_data = JSON.parse($('#total_sales_data').val());
    let sales_label = sales_data.map(function (data) {
        return data.year;
    });
    let toatl_sales = sales_data.map(function (data) {
        return data.sales;
    });
    let grossprofit_data = JSON.parse($('#total_grossprofit_data').val());
    let total_grossprofit = grossprofit_data.map(function (data) {
        return data.grossprofit;
    });
    new Chart(advertisement_graph, {
        type: 'bar',
        data: {
            labels: sales_label,
            datasets: [
                {
                    label: '総売上',
                    data: toatl_sales,
                    backgroundColor: ['#1e88e5']
                },
                {
                    label: '総利益(粗利)',
                    data: total_grossprofit,
                    backgroundColor: ['#cc6633']
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#ccc'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#333',
                    },
                    ticks: {
                        color: '#ccc',
                    }
                },
                x: {
                    beginAtZero: true,
                    grid: {
                        color: '#333'
                    },
                    ticks: {
                        color: '#ccc'
                    }
                }
            }
        }
    });
});