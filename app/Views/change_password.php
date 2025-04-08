<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 bg-indigo-600 sm:px-8">
        <h2 class="text-lg font-bold text-white">Change Password</h2>
        <p class="text-indigo-200">Update your personal information</p>
    </div>

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

    <form id="passwordForm" action="<?= base_url('/dashboard/change-password') ?>" method="post" class="p-6 sm:p-8">
        <?= csrf_field() ?>
        <div class="mt-6 border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
            <p class="text-sm text-gray-500 mb-4">Leave blank if you don't want to change your password</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php if (isset($validation) && $validation->hasError('current_password')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= $validation->getError('current_password') ?></p>
                    <?php endif; ?>
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php if (isset($validation) && $validation->hasError('new_password')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= $validation->getError('new_password') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= $validation->getError('confirm_password') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Submit -->
                <div class="mt-6 flex items-center justify-end col-span-2">
                    <a href="<?= base_url('/dashboard') ?>" class="text-sm text-indigo-600 hover:text-indigo-900 mr-4">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Changes
                    </button>
                </div>
            </div>

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
        $("#passwordForm").validate({
            rules: {
                current_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            },
            messages: {
                current_password: {
                    required: "Please enter your current password"
                },
                new_password: {
                    required: "Please enter a new password",
                    minlength: "Password must be at least 6 characters long"
                },
                confirm_password: {
                    required: "Please confirm your new password",
                    equalTo: "Passwords do not match"
                }
            },
            errorClass: "text-red-600 text-sm mt-1",
            errorElement: "div"
        });
    });
</script>



<?= $this->endSection() ?>