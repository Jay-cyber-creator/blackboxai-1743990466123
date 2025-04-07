$(document).ready(function() {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Handle appointment booking form
    $('#book-appointment-form').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            type: 'POST',
            url: '/appointments/book',
            data: formData,
            success: function(response) {
                $('#booking-result').html(`
                    <div class="alert alert-success">
                        Appointment booked successfully!
                    </div>
                `);
                $('#book-appointment-form')[0].reset();
            },
            error: function(xhr) {
                $('#booking-result').html(`
                    <div class="alert alert-danger">
                        ${xhr.responseJSON?.message || 'Booking failed'}
                    </div>
                `);
            }
        });
    });

    // Load available slots when doctor or date changes
    $('#doctor-select, #date-picker').change(function() {
        const doctorId = $('#doctor-select').val();
        const date = $('#date-picker').val();
        
        if (doctorId && date) {
            $.get(`/doctors/${doctorId}/availability?date=${date}`, function(slots) {
                const $slotsContainer = $('#time-slots');
                $slotsContainer.empty();
                
                if (slots.length > 0) {
                    slots.forEach(slot => {
                        $slotsContainer.append(`
                            <button type="button" class="btn btn-outline-primary m-1 time-slot" 
                                    data-time="${slot}">
                                ${slot}
                            </button>
                        `);
                    });
                } else {
                    $slotsContainer.html('<p>No available slots for this date</p>');
                }
            });
        }
    });
});