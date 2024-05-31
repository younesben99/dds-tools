document.addEventListener('DOMContentLoaded', function() {
    try {
        // Check if form with class .dds_form is in the DOM
        var form = document.querySelector('.dds_form');
        if (form) {
            // Function to get URL parameters
            function getUrlParameter(name) {
                name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            }

            // Get URL parameters
            var keyword = getUrlParameter('keyword');
            var placement = getUrlParameter('placement');
            var locInterest = getUrlParameter('loc_interest');
            var locPhysical = getUrlParameter('loc_physical');
            var campaignid = getUrlParameter('campaignid');

            // Function to safely set value to hidden fields by name
            function setHiddenFieldValue(fieldName, value) {
                var field = form.querySelector('input[name="' + fieldName + '"]');
                if (field) {
                    field.value = value;
                } 
            }

            // Set hidden fields with URL parameters if they exist
            setHiddenFieldValue('keyword', keyword);
            setHiddenFieldValue('placement', placement);
            setHiddenFieldValue('loc_interest', locInterest);
            setHiddenFieldValue('loc_physical', locPhysical);
            setHiddenFieldValue('campaignid', campaignid);
        }
    } catch (error) {
        console.error('Error setting URL parameters to hidden fields:', error);
    }
});
