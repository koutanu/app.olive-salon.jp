$('.sales_create').on('click', function () {
    let id = $('#id').val();
    window.location.href = getBaseURL() + 'sales/create/' + id;
});

$('.customer_detail').on('click', function () {
    let id = $('#id').val();
    window.location.href = getBaseURL() + 'customer/detail/' + id;
});

$(document).on('click', '.select_sales', function () {
    let id = $(this).data('id');
    window.location.href = getBaseURL() + 'sales/detail/' + id;
});
$(function () {
    const salesGraph = document.getElementById('grossprofit_graph');
    var grossprofit_graph = JSON.parse($('#grossprofit_graph_data').val());
    var label = grossprofit_graph.map(function (graph) {
        return setDateFormatMonth(graph.created_at);
    });
    var data = grossprofit_graph.map(function (graph) {
        return Math.floor(graph.gross_profit);
    });
    new Chart(salesGraph, {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: '粗利益',
                data: data,
                backgroundColor: ['#1e88e5'],
                borderColor: '#eee',
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
                        color: '#333',
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
    const workGraph = document.getElementById('menu_graph');
    var menu_graph = JSON.parse($('#menu_graph_data').val());
    var label = menu_graph.map(function (graph) {
        return setDateFormatMonth(graph.created_at);
    });
    var data = menu_graph.map(function (graph) {
        return graph.gross_profit;
    });
    new Chart(workGraph, {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: '施術売上',
                data: data,
                backgroundColor: ['#1e88e5'],
                borderColor: '#eee',
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
                        color: '#333',
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
    const productsGraph = document.getElementById('products_graph');
    var products_graph = JSON.parse($('#products_graph_data').val());
    var label = products_graph.map(function (product) {
        return setDateFormatMonth(product.created_at);
    });
    var data = products_graph.map(function (product) {
        return Math.floor(product.gross_profit);
    });
    new Chart(productsGraph, {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: '商品売上(税抜き)',
                data: data,
                backgroundColor: ['#1e88e5'],
                borderColor: '#eee',
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
                        color: '#333',
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
//画像もすべて読み込んでから発動
$(window).on('load', function () {
    var container = $('.canvas-container');
    var ctx = $('.canvas');
    ctx.attr('width', container.width());
    ctx.attr('height', container.height());
});