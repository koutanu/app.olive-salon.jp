function getBaseURL() {
    return $('#doc_root').val();
}

function escapeHtml(str) {
    if (str === null || str === undefined) {
        return '';
    }
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function refreshToken(result) {
    if (result && result.token) {
        $('#token').val(result.token);
    }
}

function showToast(message, isError) {
    var $toast = $('#app-toast');
    if (!$toast.length) {
        $toast = $('<div id="app-toast" role="status" aria-live="polite"></div>').appendTo('body');
    }
    $toast.text(message).toggleClass('is-error', !!isError).addClass('is-visible');
    clearTimeout(window._toastTimer);
    window._toastTimer = setTimeout(function () {
        $toast.removeClass('is-visible');
    }, 3000);
}

/**
 * 共通 POST（トークン付与・二重送信防止・トークン更新）
 */
function postWithToken(url, data, options) {
    options = options || {};
    var $btn = options.$button;
    if ($btn && $btn.data('loading')) {
        return $.Deferred().reject('busy').promise();
    }
    if ($btn) {
        $btn.data('loading', true).prop('disabled', true);
    }
    var payload = $.extend({}, data, {
        token: $('#token').val(),
        method: data.method || $('#method').val()
    });
    return $.ajax({
        type: 'POST',
        url: url,
        data: payload,
        dataType: options.dataType || 'json'
    }).done(function (result) {
        refreshToken(result);
    }).fail(function () {
        if (!options.silent) {
            showToast('通信に失敗しました。', true);
        }
    }).always(function () {
        if ($btn) {
            $btn.data('loading', false).prop('disabled', false);
        }
    });
}

function setDateFormatMonth(data) {
    if (!data || data === '0000-00-00 00:00:00') {
        return '';
    } else {
        var $date = new Date(data.replace(/-/g, "/"));
        return (parseInt($date.getMonth()) + 1) + "月";
    }
}

function lowerThanDateFromToday(d) {
    let date = new Date(d);
    let today = new Date();
    let year1 = date.getFullYear();
    let month1 = date.getMonth() + 1;
    let day1 = date.getDate();
    let year2 = today.getFullYear();
    let month2 = today.getMonth() + 1;
    let day2 = today.getDate();
    if (year1 == year2) {
        if (month1 == month2) {
            return day1 < day2;
        } else {
            return month1 < month2;
        }
    } else {
        return year1 < year2;
    }
}

function lowerThanDateFromVisitDay(d, visit) {
    let date = new Date(d);
    let today = new Date(visit);
    let year1 = date.getFullYear();
    let month1 = date.getMonth() + 1;
    let day1 = date.getDate();
    let year2 = today.getFullYear();
    let month2 = today.getMonth() + 1;
    let day2 = today.getDate();
    if (year1 == year2) {
        if (month1 == month2) {
            return day1 < day2;
        } else {
            return month1 < month2;
        }
    } else {
        return year1 < year2;
    }
}

$(function () {
    $('.history_back').on('click', function () {
        history.back();
    });

    $('.side-menu-toggle').on('click', function () {
        $('body').toggleClass('side-menu-open');
        var expanded = $('body').hasClass('side-menu-open');
        $(this).attr('aria-expanded', expanded ? 'true' : 'false');
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('body').removeClass('side-menu-open');
            $('.side-menu-toggle').attr('aria-expanded', 'false');
            $('.modal, .modal-overlay').removeClass('is-active');
        }
    });
});
