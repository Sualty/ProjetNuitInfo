$(document).ready(function() {
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    
    // Set default lang (french) if array
    if(TS_globalLang.__my_js == undefined)
        TS_globalLang = {'Su': 'Di', 'Mo': 'Lu', 'Tu': 'Ma', 'We': 'Me', 'Th': 'Je', 'Fr': 'Ve', 'Sa': 'Sa', 'Jan': 'Janvier', 'Feb': 'Février', 'Mar': 'Mars', 'Apr': 'Avril', 'May': 'Mai', 'Jun': 'Juin', 'Jul': 'Juillet', 'Aug': 'Août', 'Sep': 'Septembre', 'Oct': 'Octobre', 'Nov': 'Novembre', 'Dec': 'Décembre', 'Today': "Aujourd'hui", 'Last 7 Days': '7 Derniers Jours', 'Last 30 Days': '30 Derniers Jours', 'This Month': 'Ce mois-ci', '3 Last Months': '3 Derniers Mois', 'Last Month': 'Ce Dernier Mois', 'Customizable': 'Personalisé', 'Apply': 'Appliquer', 'Cancel': 'Annuler', 'from': 'De', 'to': 'À'};

    // Dynamic keys setting for ranges
    my_ranges = {};
    my_ranges[TS_globalLang['Today']] = [moment(), moment()];
    my_ranges[TS_globalLang['Last 7 Days']] = [moment().subtract(6, 'days'), moment()];
    my_ranges[TS_globalLang['Last 30 Days']] = [moment().subtract(29, 'days'), moment()];
    my_ranges[TS_globalLang['This Month']] = [moment().startOf('month'), moment().endOf('month')];
    my_ranges[TS_globalLang['3 Last Months']] = [moment().subtract(3, 'month'), moment()];
    my_ranges[TS_globalLang['Last Month']] = [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];

    $('#reportrange').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
            ,separator: ' - '
            ,applyLabel: TS_globalLang['Apply']
            ,cancelLabel: TS_globalLang['Cancel']
            ,fromLabel: TS_globalLang['from']
            ,toLabel: TS_globalLang['to']
            ,customRangeLabel: TS_globalLang['Customizable']
            ,daysOfWeek: [TS_globalLang['Su'], TS_globalLang['Mo'], TS_globalLang['Tu'], TS_globalLang['We'],
                TS_globalLang['Th'], TS_globalLang['Fr'], TS_globalLang['Sa']]
            ,monthNames: [TS_globalLang['Jan'], TS_globalLang['Feb'], TS_globalLang['Mar'], TS_globalLang['Apr'],
                TS_globalLang['May'], TS_globalLang['Jun'], TS_globalLang['Jul'], TS_globalLang['Aug'],
                TS_globalLang['Sep'], TS_globalLang['Oct'], TS_globalLang['Nov'], TS_globalLang['Dec']]
            ,firstDay: 1
        }
        ,ranges: my_ranges
    }, cb);



    //    $('#reportrange span').html(moment().subtract('days', 29).format('D MMMM YYYY') + ' - ' + moment().format('D MMMM YYYY'));
    var dateReport = $('#reportrange_init').html().split(' - ');

    $('#reportrange').data('daterangepicker').setStartDate(moment(dateReport[0],'DD/MM/YYYY'));
    $('#reportrange').data('daterangepicker').setEndDate(moment(dateReport[1],'DD/MM/YYYY'));


});