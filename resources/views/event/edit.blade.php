<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Appointment</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="user_id" class="form-label">User ID</label>
                                <input type="number" class="form-control @error('user_id') is-invalid @enderror"
                                    id="user_id" name="user_id" value="{{ old('user_id', $appointment->user_id) }}">
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="midwife_id" class="form-label">Midwife ID</label>
                                <input type="number" class="form-control @error('midwife_id') is-invalid @enderror"
                                    id="midwife_id" name="midwife_id" value="{{ old('midwife_id', $appointment->midwife_id) }}">
                                @error('midwife_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="hospital_id" class="form-label">Hospital ID</label>
                                <input type="number" class="form-control @error('hospital_id') is-invalid @enderror"
                                    id="hospital_id" name="hospital_id" value="{{ old('hospital_id', $appointment->hospital_id) }}">
                                @error('hospital_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date_time" class="form-label">Date & Time</label>
                                <input type="datetime-local" class="form-control @error('date_time') is-invalid @enderror"
                                    id="date_time" name="date_time" value="{{ old('date_time', date('Y-m-d\TH:i', strtotime($appointment->date_time))) }}">
                                @error('date_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="canceled" {{ old('status', $appointment->status) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                    id="notes" name="notes" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Update Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
