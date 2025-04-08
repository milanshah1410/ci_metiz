<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 bg-indigo-600 sm:px-8">
        <h2 class="text-lg font-bold text-white">Leave Application</h2>
        <p class="text-indigo-200">Apply for a leave from your available balance</p>
    </div>

    <form action="<?= base_url('/leave/submit') ?>" method="post" id="leaveForm" class="p-6 sm:p-8">
        <?= csrf_field() ?>

        <?php if (session()->has('validation')) : ?>
            <div class="text-red-500 text-sm mb-4">
                <?= session('validation')->listErrors() ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div class="mb-4 p-4 bg-green-100 rounded-md">
                <p class="text-green-700"><?= session('success') ?></p>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="mb-4 p-4 bg-red-100 rounded-md">
                <p class="text-red-700"><?= session('error') ?></p>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="employee_code" class="block text-sm font-medium text-gray-700 mb-1">Employee Code</label>
                <input type="text" name="employee_code" id="employee_code" value="<?= $employee['employee_code'] ?>" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                <?php if (isset($validation) && $validation->hasError('employee_code')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('employee_code') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-1">Employee Name</label>
                <input type="text" id="employee_name" value="<?= $employee['first_name'] . ' ' . $employee['last_name'] ?>" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
            </div>

            <div>
                <label for="leave_type" class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                <select name="leave_type" id="leave_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Select Leave Type</option>
                    <?php foreach ($leaveTypes as $type): ?>
                        <option value="<?= $type->id ?>" <?= old('leave_type') == $type->id ? 'selected' : '' ?>>
                            <?= $type->leaveType ?> (Balance: <?= $type->current_balance ?> days)
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($validation) && $validation->hasError('leave_type')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('leave_type') ?></p>
                <?php endif; ?>
            </div>


            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" name="from_date" id="from_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required min="<?= date('Y-m-d') ?>" value="<?= old('from_date') ?>">
                <?php if (isset($validation) && $validation->hasError('from_date')): ?>
                    <p class=" mt-1 text-sm text-red-600"><?= $validation->getError('from_date') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" name="to_date" id="to_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required min="<?= date('Y-m-d') ?>" value="<?= old('to_date') ?>">
                <?php if (isset($validation) && $validation->hasError('to_date')): ?>
                    <p class=" mt-1 text-sm text-red-600"><?= $validation->getError('to_date') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="number_of_days" class="block text-sm font-medium text-gray-700 mb-1">Number of Days</label>
                <input type="text" name="number_of_days" id="number_of_days" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" value="<?= old('number_of_days') ?>">
                <p class=" mt-1 text-xs text-gray-500" id="working_days_note"></p>
            </div>
        </div>

        <div class="mt-6">
            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
            <select name="country" id="country" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="">Select Country</option>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country['id'] ?>"
                        <?= old('country', $employee['country'] ?? '') == $country['id'] ? 'selected' : '' ?>>
                        <?= $country['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                <select name="state" id="state" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Select State</option>
                </select>
            </div>

            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <select name="city" id="city" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Select City</option>
                </select>
            </div>
        </div>

        <div class="mt-6">
            <label for="comments" class="block text-sm font-medium text-gray-700 mb-1">Comments</label>
            <textarea name="comments" id="comments" rows="3" maxlength="300" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required><?= old('comments', $employee['comments'] ?? '') ?></textarea>
            <p class="mt-1 text-xs text-gray-500"><span id="char_count">0</span>/300 characters</p>
            <?php if (isset($validation) && $validation->hasError('comments')): ?>
                <p class="mt-1 text-sm text-red-600"><?= $validation->getError('comments') ?></p>
            <?php endif; ?>
        </div>

        <div class="mt-6 flex items-center justify-end">
            <a href="<?= base_url('/leave/') ?>" class="text-sm text-indigo-600 hover:text-indigo-900 mr-4">Cancel</a>
            <button type="submit" id="submitBtn" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit Leave Request
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#leaveForm').validate({
            rules: {
                leave_type: {
                    required: true
                },
                from_date: {
                    required: true,
                    date: true
                },
                to_date: {
                    required: true,
                    date: true
                },
                country: {
                    required: true
                },
                state: {
                    required: true
                },
                city: {
                    required: true
                },
                comments: {
                    required: true,
                    maxlength: 300
                }
            },
            messages: {
                leave_type: {
                    required: "Please select a leave type"
                },
                from_date: {
                    required: "Please select a start date"
                },
                to_date: {
                    required: "Please select an end date"
                },
                country: {
                    required: "Please select a country"
                },
                state: {
                    required: "Please select a state"
                },
                city: {
                    required: "Please select a city"
                },
                comments: {
                    required: "Please provide comments",
                    maxlength: "Comments must be under 300 characters"
                }
            },
            errorClass: 'text-red-600 text-sm mt-1',
            errorElement: 'div',
            highlight: function(element) {
                $(element).addClass('border-red-500');
            },
            unhighlight: function(element) {
                $(element).removeClass('border-red-500');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for comments
        const fromDateInput = document.getElementById('from_date');
        const toDateInput = document.getElementById('to_date');

        const commentsField = document.getElementById('comments');
        const charCount = document.getElementById('char_count');

        commentsField.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });

        // Date validation - ensure to_date is not before from_date
        fromDateInput.addEventListener('change', function() {
            // Set the minimum value of to_date to the selected from_date
            toDateInput.min = fromDateInput.value;

            // If to_date is earlier than from_date, update to_date to match from_date
            if (toDateInput.value && toDateInput.value < fromDateInput.value) {
                toDateInput.value = fromDateInput.value;
            }
        });

        // Leave type selection updates current balance
        const leaveTypeSelect = document.getElementById('leave_type');
        const currentBalanceField = document.getElementById('current_balance');

        leaveTypeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                currentBalanceField.value = selectedOption.dataset.balance + ' days';
            } else {
                currentBalanceField.value = '';
            }
        });

        // Date calculations
        const fromDateField = document.getElementById('from_date');
        const toDateField = document.getElementById('to_date');
        const numberOfDaysField = document.getElementById('number_of_days');
        const workingDaysNote = document.getElementById('working_days_note');

        function calculateDays() {
            if (fromDateField.value && toDateField.value) {
                const fromDate = new Date(fromDateField.value);
                const toDate = new Date(toDateField.value);

                // Validation: To date must be greater than from date
                if (toDate < fromDate) {
                    toDateField.setCustomValidity('To date must be greater than or equal to from date');
                    numberOfDaysField.value = '';
                    workingDaysNote.textContent = '';
                    return;
                } else {
                    toDateField.setCustomValidity('');
                }

                // Calculate days including the end date
                const timeDiff = toDate.getTime() - fromDate.getTime();
                const dayDiff = Math.floor(timeDiff / (1000 * 3600 * 24)) + 1;

                numberOfDaysField.value = dayDiff;
                workingDaysNote.textContent = `Total days: ${dayDiff}`;

            }
        }

        fromDateField.addEventListener('change', calculateDays);
        toDateField.addEventListener('change', calculateDays);

        // Country, State, City dropdowns
        const countrySelect = document.getElementById('country');
        const stateSelect = document.getElementById('state');
        const citySelect = document.getElementById('city');

        // Load states based on country
        countrySelect.addEventListener('change', function() {
            if (this.value) {
                fetch(`<?= base_url('/leave/get-states') ?>/${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        stateSelect.innerHTML = '<option value="">Select State</option>';
                        citySelect.innerHTML = '<option value="">Select City</option>';

                        data.forEach(state => {
                            const option = document.createElement('option');
                            option.value = state.id;
                            option.textContent = state.name;
                            stateSelect.appendChild(option);
                        });

                        // If employee has a state set, select it
                        if (<?= json_encode($employee['state'] ?? '') ?>) {
                            stateSelect.value = <?= json_encode($employee['state'] ?? '') ?>;
                            stateSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => {
                        console.error('Error loading states:', error);
                    });
            } else {
                stateSelect.innerHTML = '<option value="">Select State</option>';
                citySelect.innerHTML = '<option value="">Select City</option>';
            }
        });

        // Load cities based on state
        stateSelect.addEventListener('change', function() {
            if (this.value) {
                fetch(`<?= base_url('/leave/get-cities') ?>/${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">Select City</option>';

                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });

                        // If employee has a city set, select it
                        if (<?= json_encode($employee['city'] ?? '') ?>) {
                            citySelect.value = <?= json_encode($employee['city'] ?? '') ?>;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading cities:', error);
                    });
            } else {
                citySelect.innerHTML = '<option value="">Select City</option>';
            }
        });

        // Form validation
        const leaveForm = document.getElementById('leaveForm');
        const submitBtn = document.getElementById('submitBtn');

        leaveForm.addEventListener('submit', function(event) {
            // Check if any field is empty
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.setCustomValidity('This field is required');
                    isValid = false;
                } else {
                    field.setCustomValidity('');
                }
            });

            // Check if leave balance is sufficient
            if (leaveTypeSelect.value && numberOfDaysField.value) {
                const selectedOption = leaveTypeSelect.options[leaveTypeSelect.selectedIndex];
                const balance = parseInt(selectedOption.dataset.balance);
                const daysRequested = parseInt(numberOfDaysField.value);

                if (daysRequested > balance) {
                    event.preventDefault();
                    alert('Insufficient leave balance. You have only ' + balance + ' days available.');
                    return false;
                }
            }
        });

        // Trigger country change to load states
        if (countrySelect.value) {
            countrySelect.dispatchEvent(new Event('change'));
        }
    });
</script>

<?= $this->endSection() ?>