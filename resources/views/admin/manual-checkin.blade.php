<!DOCTYPE html>
<html>
<head>
    <title>Admin Manual Check-In</title>
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('js/select2.min.js') }}"></script>
</head>
<body>
    <center>
        <h2>Manual Check-In</h2>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <!-- Manual Check-In Form -->
        <form action="{{ route('admin.manual-checkin.process') }}" method="POST">
            @csrf

            <!-- Text Code Input -->
            <label for="text_code">Enter Text Code:</label><br>
            <textarea rows="10" cols="40" name="text_code" id="text_code" required placeholder="Enter text code here"></textarea>
            <br><br>

            <!-- Business Dropdown -->
            <label for="business_id">Select Business:</label><br>
            <select name="business_id" id="business_id" style="width: 300px;" required>
                <option value="">Search and Select a Business</option>
            </select>
            <br><br>

            <button type="submit">Process Check-In</button>
        </form>
    </center>
    
    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function() {
            $('#business_id').select2({
                ajax: {
                    url: '{{ route("admin.get-businesses") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { q: params.term }; // Pass the search term
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return { 
                                    id: item.id, 
                                    text: `${item.name} - ${item.email}` // Show name and email
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'Search for a business by name or email',
                minimumInputLength: 1,
            });
        });
    </script>
</body>
</html>
