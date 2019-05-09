function dataJson(url) {
    var mydata = [];
    jQuery.ajax({
        url: url,
        async: false,
        dataType: 'json',
        success: function (json) {
            mydata = json.data;
        }
    });

    var json = jQuery.parseJSON(JSON.stringify(mydata));
    return json;
}

function makeSelect(param) {
    var make;
    make = 'table=' + param.param.table;
    make += '&table=' + param.param.table;
    make += '&id=' + param.param.id;
    make += '&text=' + param.param.text;

    if (param.param.where) {
        jQuery.each(param.param.where, function (key, val) {
            make += '&wheres[]=' + val.field + ',' + val.comparison + ',' + val.value;
        })
    }
    
    var mydata = [];
    jQuery.ajax({
        type: "GET",
        url: param.url + '?' + make,
        async: false,
        dataType: 'json',
        success: function (json) {
            mydata = json.data;
        }
    });

    var data = jQuery.parseJSON(JSON.stringify(mydata));
    return data;
}

function makeSelectFromgeneralData(param) {
    var data = makeSelect({
        url: param.url,
        param: {
            table: 'tm_general_data',
            where: [
                { field: 'general_code', comparison: 'equal', value: param.code }
            ],
            id: 'description_code',
            text: 'description'
        }
    });    
    return data;    
}


function notify(param) {
    Command: toastr[param.type](param.message)

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}

function binEncode(data) {
    var binArray = []
    var datEncode = "";

    for (i = 0; i < data.length; i++) {
        binArray.push(data[i].charCodeAt(0).toString(2));
    }
    for (j = 0; j < binArray.length; j++) {
        var pad = padding_left(binArray[j], '0', 8);
        datEncode += pad + ' ';
    }

    function padding_left(s, c, n) {
        if (!s || !c || s.length >= n) {
            return s;
        }

        var max = (n - s.length) / c.length;
        for (var i = 0; i < max; i++) {
            s = c + s;
        } return s;
    }
    return binArray;
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}