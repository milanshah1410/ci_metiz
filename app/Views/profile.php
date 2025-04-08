<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 bg-indigo-600 sm:px-8">
        <h2 class="text-lg font-bold text-white">My Profile</h2>
        <p class="text-indigo-200">Update your personal information</p>
    </div>

    <form id="profile" action="<?= base_url('/dashboard/update-profile') ?>" method="post" class="p-6 sm:p-8">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                <input type="text" name="first_name" id="first_name" value="<?= $employee['first_name'] ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <?php if (isset($validation) && $validation->hasError('first_name')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('first_name') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="<?= $employee['last_name'] ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <?php if (isset($validation) && $validation->hasError('last_name')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('last_name') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="text" id="email" value="<?= $employee['email'] ?>" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                <p class="mt-1 text-xs text-gray-500">Email cannot be changed</p>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="phone" id="phone" value="<?= $employee['phone'] ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <?php if (isset($validation) && $validation->hasError('phone')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('phone') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-6">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea name="address" id="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"><?= $employee['address'] ?></textarea>
            <?php if (isset($validation) && $validation->hasError('address')): ?>
                <p class="mt-1 text-sm text-red-600"><?= $validation->getError('address') ?></p>
            <?php endif; ?>
        </div>

        <div class="mt-6 flex items-center justify-end">
            <a href="<?= base_url('/dashboard') ?>" class="text-sm text-indigo-600 hover:text-indigo-900 mr-4">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save Changes
            </button>
        </div>
    </form>
</div>

<?php if (session()->has('success')): ?>
    <div class="mt-4 p-4 bg-green-100 rounded-md">
        <p class="text-green-700"><?= session('success') ?></p>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="mt-4 p-4 bg-red-100 rounded-md">
        <p class="text-red-700"><?= session('error') ?></p>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function () {
        $('#profile').validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 15
                },
                address: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                first_name: {
                    required: "First name is required",
                    minlength: "At least 2 characters"
                },
                last_name: {
                    required: "Last name is required",
                    minlength: "At least 2 characters"
                },
                phone: {
                    required: "Phone number is required",
                    digits: "Only digits allowed",
                    minlength: "At least 10 digits",
                    maxlength: "No more than 15 digits"
                },
                address: {
                    required: "Address is required",
                    minlength: "At least 5 characters"
                }
            },
            errorClass: 'text-red-600 text-sm mt-1',
            errorElement: 'div',
            highlight: function (element) {
                $(element).addClass('border-red-500');
            },
            unhighlight: function (element) {
                $(element).removeClass('border-red-500');
            }
        });
    });
</script>

<?= $this->endSection() ?>