import { getCSRFToken, getGlobalEnvironment } from "../../global-functions";

const ComponentAutocomplete = (function () {

    const inputInputHandler = (input) => {
        const currentInputWrap = input.closest('.component__autocomplete');
        const list = currentInputWrap.find('.component__autocomplete-list');

        const url = currentInputWrap.data('url');

        const query = input.val().toLowerCase();

        list.empty();

        function successResponseHandler(names) {
            names.forEach(name => {
                const item = $('<div>').addClass('component__autocomplete-list-item').text(name);
                item.on('click', function () {
                    input.val(name);
                    list.addClass('d-none');
                });
                list.append(item);
            });

            if (names.length) {
                list.removeClass('d-none');
            } else {
                list.addClass('d-none');
            }
        }

        const errorResponseHandler = (error = '') => {
            console.error(`Error fetching data: ${error}`);
            list.addClass('d-none');
        }
        if (getGlobalEnvironment() != '') {
            if (query) {
                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken()
                    },
                    method: 'POST',
                    data: { search: query },
                    success: function (response) {
                        successResponseHandler(response);
                    },
                    error: function (error) {
                        errorResponseHandler(error);
                    }
                });
            } else {
                errorResponseHandler("Query is empty");
            }
        } else {
            const demo_names = [
                "Evangeline Davis", "Eve Taylor", "Eve Wilson",
                "Evelyn Jones", "Evelyn Richards", "Evette Smith",
                "Adam Everhart", "Jeremy Eve"
            ];
            successResponseHandler(demo_names);
        }
    }

    // const inputFocusinHandler = (input) => {
    //     if (!input.closest('#autocomplete-input').length) {
    //         $list.addClass('d-none');
    //     }
    // }

    const init = (jqWrapElem) => {
        const currentInput = jqWrapElem.find('.js__autocomplete-input');
        const list = jqWrapElem.find('.component__autocomplete-list');

        currentInput.each(function () {
            $(this).on('input', function (e) {
                inputInputHandler($(this));
            });

            // $(this).on('focusin', function (e) {
            //     inputFocusinHandler($(this));
            // });
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.js__autocomplete-input').length) {
                list.addClass('d-none');
            }
        });
    }

    return {
        init: init
    }
})();

export default ComponentAutocomplete;

