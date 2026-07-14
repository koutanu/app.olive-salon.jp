$(function () {
    const salesGraph = document.getElementById('grossprofit_graph');
    let grossprofit_graph = JSON.parse($('#grossprofit_graph_data').val());
    let label = grossprofit_graph.map(function (graph) {
        return setDateFormatMonth(graph.created_at);
    });
    let data = grossprofit_graph.map(function (graph) {
        return Math.floor(graph.gross_profit);
    });
    const sum = data.reduce(function (acc, cur) {
        return Number(acc) + Number(cur);
    });
    // $('#ave-grossprofit').text(Math.floor(sum / data.length).toLocaleString());
    new Chart(salesGraph, {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: '総粗利',
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
    let menu_graph = JSON.parse($('#menu_graph_data').val());
    let label = menu_graph.map(function (graph) {
        return setDateFormatMonth(graph.created_at);
    });
    let data = menu_graph.map(function (graph) {
        return graph.gross_profit;
    });
    const sum = data.reduce(function (acc, cur) {
        return Number(acc) + Number(cur);
    });
    // $('#ave-menu').text(Math.floor(sum / data.length).toLocaleString());
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
    let products_graph = JSON.parse($('#products_graph_data').val());
    let label = products_graph.map(function (product) {
        return setDateFormatMonth(product.created_at);
    });
    let data = products_graph.map(function (product) {
        return Math.floor(product.gross_profit);
    });
    const sum = data.reduce(function (acc, cur) {
        return Number(acc) + Number(cur);
    });
    // $('#ave-products').text(Math.floor(sum / data.length).toLocaleString());
    new Chart(productsGraph, {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: '商品売上',
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
    let count = [];
    let label = [];
    const ageGroup = document.getElementById('age_group');
    let age_groups = JSON.parse($('#age_group_data').val());
    $.each(age_groups, function (i, val) {
        count.push(val);
    });
    $.each(age_groups, function (i) {
        label.push(i);
    });
    new Chart(ageGroup, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: '年齢層',
                data: count,
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
    const purchasePrice = document.getElementById('purchase_price_graph');
    if (!purchasePrice) {
        return;
    }
    var raw = $('#purchase_price').val();
    var prices = [];
    try {
        prices = raw ? JSON.parse(raw) : [];
    } catch (e) {
        prices = [];
    }
    if (!Array.isArray(prices) || !prices.length) {
        return;
    }
    let label = prices.map(function (price) {
        return setDateFormatMonth(price.created_at);
    });
    let data = prices.map(function (price) {
        return price.purchase_price;
    });
    new Chart(purchasePrice, {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: '仕入値 + 送料',
                data: data,
                backgroundColor: ['#1e88e5'],
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
$(document).on('click', '.select_stock', function () {
    let id = $(this).data('id');
    window.location.href = getBaseURL() + 'stock';
});
$(window).on('load', function () {
    let container = $('.products-group');
    var raw = $('#products_monthly').val();
    var products_monthly = [];
    try {
        products_monthly = raw ? JSON.parse(raw) : [];
    } catch (e) {
        products_monthly = [];
    }
    if (!Array.isArray(products_monthly)) {
        products_monthly = [];
    }
    let html = '';
    html += '<div>';
    html += '<span class="products-group-name">商品名</span>';
    html += '<span class="products-group-price">金額(税込み)</span>';
    html += '<span class="products-group-lot">販売個数</span>';
    html += '<span class="products-group-unit">(バラ)</span>';
    html += '</div>';
    products_monthly.forEach(function (value) {
        html += '<div>';
        var name = value.name || '';
        if (name.length > 20) {
            html += '<span class="products-group-name">' + escapeHtml(name.substring(0, 20)) + '...</span>';
        } else {
            html += '<span class="products-group-name">' + escapeHtml(name) + '</span>';
        }
        html += '<span class="products-group-price">' + Math.floor(value.price * (1 + (0.01 * value.tax_rate))).toLocaleString() + '</span>';
        html += '<span class="products-group-lot">' + ((value.lot == null) ? '0' : value.lot) + 'セット ' + '</span>';
        html += '<span class="products-group-unit">' + ((value.unit == null) ? '0' : value.unit) + '個</span>';
        html += '</div>';
    });
    $('.products-group').css('height', container.height());
    $('.prodcuts_item_wrap').html(html);
});
$('.products_date').on('change', function () {
    var url = getBaseURL() + 'home/get_products_count_monthly';
    postWithToken(url, {
        date: $('.products_date').val(),
        method: 'index'
    }).done(function (result) {
        let container = $('.products-group');
        var rows = result.data || result;
        if (rows && rows.length) {
            let html = '';
            html += '<div>';
            html += '<span class="products-group-name">商品名</span>';
            html += '<span class="products-group-price">金額(税込み)</span>';
            html += '<span class="products-group-lot">販売個数</span>';
            html += '<span class="products-group-unit">(バラ)</span>';
            html += '</div>';
            rows.forEach(function (value) {
                html += '<div>';
                var name = value.name || '';
                if (name.length > 20) {
                    html += '<span class="products-group-name">' + escapeHtml(name.substring(0, 20)) + '...</span>';
                } else {
                    html += '<span class="products-group-name">' + escapeHtml(name) + '</span>';
                }
                html += '<span class="products-group-price">' + Math.floor(value.price * (1 + (0.01 * value.tax_rate))).toLocaleString() + '</span>';
                html += '<span class="products-group-lot">' + ((value.lot == null) ? '0' : value.lot) + 'セット ' + '</span>';
                html += '<span class="products-group-unit">' + ((value.unit == null) ? '0' : value.unit) + '個</span>';
                html += '</div>';
            });
            $('.products-group').css('height', container.height());
            $('.prodcuts_item_wrap').html(html);
        } else {
            showToast(result.result || 'データがありません。', true);
        }
    });
});