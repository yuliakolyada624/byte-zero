import moment from 'moment';
import 'daterangepicker';

const ComponentDateRangeFilter = (function () {
    const today = moment();

    function setDateRange(optionElem, startDate, endDate) {
        const componentWrapperElem = optionElem.closest('.filter-daterange');
        componentWrapperElem.find('.filter-daterange__startdate').val(startDate.format('YYYY-MM-DD'));
        componentWrapperElem.find('.filter-daterange__enddate').val(endDate.format('YYYY-MM-DD'));
        componentWrapperElem.find('.js__fdaterange-input').val(`${startDate.format('MM-DD-YYYY')} to ${endDate.format('MM-DD-YYYY')}`).trigger('change');
        componentWrapperElem.removeClass('open');
    }

    const optionCustomRangeClickHandler = (optionElem) => {
        const componentWrapperElem = optionElem.closest('.filter-daterange');
        setDateRangeLabel(optionElem, "Custom range");
        const rangeInput = componentWrapperElem.find('.js__filter-daterange__custom');
        rangeInput.daterangepicker({
            startDate: moment().subtract(2, 'weeks'),
            endDate: today,
            opens: 'left',
            "autoApply": true,
            "locale": {
                "format": "MM/DD/YYYY",
                "separator": " - ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Su",
                    "Mo",
                    "Tu",
                    "We",
                    "Th",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
                "firstDay": 0
            },
            autoUpdateInput: false,
            linkedCalendars: false,
            alwaysShowCalendars: true
        }, function (start, end) {
            setDateRange(optionElem, start, end);
        }).trigger('click');
        return;
    }

    const rangeInputClickHandler = (input) => {
        const componentWrapperElem = input.closest('.filter-daterange');
        componentWrapperElem.addClass('open');
    }

    const arrowClickHandler = (elem) => {
        const componentWrapperElem = elem.closest('.filter-daterange');
        componentWrapperElem.removeClass('open');
    } 

    const setDateRangeLabel = (optionElem, text) => {
        optionElem.closest('.filter-daterange').find('.js__filter-daterange').text(text)
    }

    const optionClickHandler = (optionElem) => {
        const option = optionElem.data('value');
        let startDate, endDate;

        switch (option) {
            case 'last_30_day':
                startDate = moment().subtract(30, 'days');
                endDate = today;
                setDateRangeLabel(optionElem, "Last 30 days");
                break;
            case 'last_year':
                startDate = moment().subtract(1, 'year');
                endDate = today;
                setDateRangeLabel(optionElem, "Last year");
                break;
            case 'month_to_date':
                startDate = moment().startOf('month');
                endDate = today;
                setDateRangeLabel(optionElem, "Month-to-date");
                break;
            case 'year_to_date':
                startDate = moment().startOf('year');
                endDate = today;
                setDateRangeLabel(optionElem, "Year-to-date");
                break;
        }

        setDateRange(optionElem, startDate, endDate);
    }

    const init = (componentWrapperElem) => {
        const optionItems = componentWrapperElem.find('.js__fdaterange-list-item');
        const optionCustomRange = componentWrapperElem.find('.js__fdaterange-custom-range');
        const rangeInput = componentWrapperElem.find('.js__fdaterange-input');
        const arrow = componentWrapperElem.find('.js__fdaterange-arrow');

        optionItems.on('click', function (e) {
            optionClickHandler($(this));
        });

        optionCustomRange.on('click', function (e) {
            optionCustomRangeClickHandler($(this));
        });

        rangeInput.on('click', function (e) {
            rangeInputClickHandler($(this));
        });

        arrow.on('click', function (e) {
            arrowClickHandler($(this));
        })

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.filter-daterange').length && !$(event.target).closest('.daterangepicker').length) {
                componentWrapperElem.removeClass('open');
            }
        });
    }

    return {
        init: init
    }

})()

export default ComponentDateRangeFilter