
    {!! $website->html_code !!}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('submit-form');
            const submitButton = document.getElementById('submit-button');

            submitButton.addEventListener('click', function(event) {
                event.preventDefault();
                const actionUrl = '{{ route('admin.phishing.test-action') }}';
                const formData = new FormData(form);
                fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    // Handle the response data here
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
