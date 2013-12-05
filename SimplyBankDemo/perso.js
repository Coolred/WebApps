$(function() {

    $("#tabs").tabs();

    function log(msg) {
        if (window.console) {
            console.log(msg);
        }
    }

    $("#track2ConvertButton").click(function() {
        var convertedTrackData = "ENTER_YOUR_SWIPE_DATA_TO_FILL_THIS_IN";
        try {
            var swipeInput = $("#swipeInput").val();
            if (swipeInput) {
                convertedTrackData = convertSwipeDataToApduCommand(swipeInput);
            }
        } catch (ex) {
            alert("Invalid swipe input")
        }

        try {
            modifyPersonalizationScript(convertedTrackData);
        } catch (ex) {
            log(ex.message);
        }
    });

    function modifyPersonalizationScript(convertedTrackData) {
        var text = $("#swipeYoursScript").val();
        text = text.replace(/\/send\b.*/, "/send " + convertedTrackData);
        $("#swipeYoursScript").val(text);
    }


    function convertSwipeDataToApduCommand(swipeData) {
        // strip any whitespace and then match the track 2 portion of the data
        var apduPayload = swipeData.replace(/\s/g, '').match(/[0-9]+=[0-9]+/)[0];

        // replace the equal sign with a hex 'D'
        apduPayload = apduPayload.replace('=', 'D');

        // append a hex 'F' if the ascii length is odd
        if (apduPayload.length % 2 !== 0) {
            apduPayload += 'F';
        }

        // divide the length of the payload in hex by two in order to get the
        // payload byte count
        var payloadLength = (apduPayload.length / 2).toString(16);

        // 00e20000: CLA = 00, INS = e2, P1 = 00, p2 = 00
        return "00e20000" + payloadLength +  apduPayload + "00";
    }

});