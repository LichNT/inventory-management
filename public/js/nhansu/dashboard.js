
/**
 * EVENT PAGE LOAD
 */
$(window).load(function () {
    setPie('phanloainhansu', [{ label: 'loading ...', data: 100, color: '#dd4b39' }]);
    setPie('phanloainhansutheophongban', [{ label: 'loading ...', data: 100, color: '#dd4b39' }]);
    setPie('phanloainhansutheotrinhdo', [{ label: 'loading ...', data: 100, color: '#dd4b39' }]);
    get_phan_loai_nhansu_data();
});

function get_phan_loai_nhansu_data() {
    var ajax = new XMLHttpRequest();
    ajax.addEventListener("load", function (e) {
        if (e.target.status == 200) {
            if (e.target.response) {
                let response = JSON.parse(e.target.response);
                if (response && response.data) {
                    if (response.data.classification_nhan_su_by_inactive_data) {
                        setPie('phanloainhansu', response.data.classification_nhan_su_by_inactive_data);
                    }

                    if (response.data.classification_nhan_su_by_phong_ban_data) {
                        setPie('phanloainhansutheophongban', response.data.classification_nhan_su_by_phong_ban_data);
                    }

                    if (response.data.classification_nhan_su_by_trinh_do_data) {
                        setPie('phanloainhansutheotrinhdo', response.data.classification_nhan_su_by_trinh_do_data);
                    }
                }
            }
        }
    }, false);

    ajax.addEventListener("error", function (e) {

    }, false);

    ajax.open("GET", "/nhansu/dashboard/classification");

    var uploaderForm = new FormData();
    ajax.send(uploaderForm);
}

function setPie(pie_id, data) {
    if ($.isArray(data)) {
        $.plot('#' + pie_id, data, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0.5,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }
                }
            },
            legend: {
                show: true
            }
        });
    }
}

/*
* Custom Label formatter
* ----------------------
*/
function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
        + label
        + '<br>'
        + Math.round(series.percent) + '%</div>'
}