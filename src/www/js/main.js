function getBaseURL() {
    return $('#doc_root').val();
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
        }
        else {
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
        }
        else {
            return month1 < month2;
        }
    } else {
        return year1 < year2;
    }
}
$('.history_back').on('click', function () {
    history.back();
})