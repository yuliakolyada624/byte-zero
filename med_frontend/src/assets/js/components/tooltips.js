const AddonTooltips = (function () {

    const init = (elemSelector) => {
        const elem = $(elemSelector);
        //Data
        
        tippy(elemSelector, {
            arrow: true,
            allowHTML: true,
            followCursor: true,
        });
    }

    return {
        init: init
    }
})()

export default AddonTooltips